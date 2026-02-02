<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::with(['specifications', 'priceOptions'])->orderBy('name')->get();
        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.price_option_id' => 'nullable|exists:product_price_options,id', // New
            'items.*.selected_price' => 'required|numeric|min:0', // New: The actual price selected
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.size' => 'nullable|string|max:255',
            'items.*.specifications' => 'nullable|array',
            'discount' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0', // Added validation
            'payment_status' => 'required|in:unpaid,partial,paid', // Added validation
        ]);

        try {
            DB::beginTransaction();

            // Generate custom order number: YYYYMMDD-XXX
            $datePrefix = now()->format('Ymd');
            $latestOrder = Order::where('order_number', 'like', $datePrefix . '-%')->latest('id')->first();
            $sequence = 1;
            if ($latestOrder) {
                $lastSequence = (int) substr($latestOrder->order_number, -3);
                $sequence = $lastSequence + 1;
            }
            $orderNumber = $datePrefix . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);

            // Calculate total amount and prepare items data
            $totalAmount = 0;
            $itemsToStore = [];

            foreach ($request->items as $itemData) {
                $product = Product::find($itemData['product_id']);
                // Get the base price for the item, either from selected_price or product's default price
                $itemPrice = $itemData['selected_price'];
                $selectedSpecifications = [];

                if (isset($itemData['specifications']) && is_array($itemData['specifications'])) {
                    // Assuming specifications are sent as an array of IDs from the frontend
                    foreach ($itemData['specifications'] as $specId) {
                        $spec = $product->specifications()->find($specId);
                        if ($spec) {
                            $itemPrice += $spec->additional_price;
                            $selectedSpecifications[] = [
                                'id' => $spec->id,
                                'name' => $spec->name,
                                'value' => $spec->value,
                                'additional_price' => $spec->additional_price,
                            ];
                        }
                    }
                }

                $subtotal = $itemPrice * $itemData['quantity'];
                $size = null;
                if ($product->unit === 'meter' && !empty($itemData['size'])) {
                    $size = $itemData['size'];
                    $dimensions = explode('x', $size);
                    if (count($dimensions) === 2) {
                        $width = floatval(trim($dimensions[0]));
                        $height = floatval(trim($dimensions[1]));
                        $area = ($width / 100) * ($height / 100); // Convert cm to m and calculate area
                        if ($area > 0 && $area < 1) {
                            $area = 1;
                        }
                        $subtotal = $itemPrice * $itemData['quantity'] * $area;
                    }
                }

                $totalAmount += $subtotal;

                $itemsToStore[] = [
                    'product_id' => $itemData['product_id'],
                    'product_price_option_id' => $itemData['price_option_id'] ?? null, // Added
                    'quantity' => $itemData['quantity'],
                    'size' => $size,
                    'price' => $itemPrice, // Price per unit including specifications
                    'subtotal' => $subtotal,
                    'specifications' => json_encode($selectedSpecifications), // Store as JSON string
                ];
            }

            $discountAmount = $request->input('discount', 0);
            $finalAmount = $totalAmount - $discountAmount;
            $paidAmount = $request->input('paid_amount', 0); // Get paid_amount from request
            $paymentStatus = $request->input('payment_status', 'unpaid'); // Get payment_status from request

            // Create order
            $order = new Order;
            $order->order_number = $orderNumber;
            $order->customer_id = $request->customer_id;
            $order->order_date = $request->order_date;
            $order->deadline = $request->deadline;
            $order->notes = $request->notes;
            $order->total_amount = $totalAmount;
            $order->discount = $discountAmount;
            $order->final_amount = $finalAmount;
            $order->payment_status = $paymentStatus;
            $order->paid_amount = $paidAmount;
            $order->status = 'Menunggu Desain';
            $order->created_by = Auth::id();
            $order->save();

            // Create order items
            foreach ($itemsToStore as $itemData) {
                $orderItem = new OrderItem($itemData);
                $order->items()->save($orderItem);
            }

            // Create initial production log
            ProductionLog::create([
                'order_id' => $order->id,
                'status' => 'Menunggu Desain',
                'operator_id' => Auth::id(),
            ]);

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error creating order: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $order->load([
            'customer',
            'items.product',
            'items.designFiles',
            'productionLogs.operator'
        ]);

        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::with(['specifications', 'priceOptions'])->orderBy('name')->get();
        $order->load('items.product.specifications', 'items.productPriceOption'); // Load priceOptions on products and productPriceOption on order items

        return view('orders.edit', compact('order', 'customers', 'products'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.price_option_id' => 'nullable|exists:product_price_options,id', // New
            'items.*.selected_price' => 'required|numeric|min:0', // New: The actual price selected
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.size' => 'nullable|string|max:255',
            'items.*.specifications' => 'nullable|array', // nullable as it might be empty
            'items.*.item_id' => 'nullable|exists:order_items,id', // for existing items
            'discount' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0', // Added validation
            'payment_status' => 'required|in:unpaid,partial,paid', // Added validation
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $itemsToKeep = []; // To track items that are still in the request

            foreach ($request->items as $itemData) {
                $product = Product::find($itemData['product_id']);
                // Get the base price for the item, either from selected_price or product's default price
                $itemPrice = $itemData['selected_price'];
                $selectedSpecifications = [];

                if (isset($itemData['specifications']) && is_array($itemData['specifications'])) {
                    foreach ($itemData['specifications'] as $specId) {
                        $spec = $product->specifications()->find($specId);
                        if ($spec) {
                            $itemPrice += $spec->additional_price;
                            $selectedSpecifications[] = [
                                'id' => $spec->id,
                                'name' => $spec->name,
                                'value' => $spec->value,
                                'additional_price' => $spec->additional_price,
                            ];
                        }
                    }
                }

                $subtotal = $itemPrice * $itemData['quantity'];
                $size = null;
                if ($product->unit === 'meter' && !empty($itemData['size'])) {
                    $size = $itemData['size'];
                    $dimensions = explode('x', $size);
                    if (count($dimensions) === 2) {
                        $width = floatval(trim($dimensions[0]));
                        $height = floatval(trim($dimensions[1]));
                        $area = ($width / 100) * ($height / 100); // Convert cm to m and calculate area
                        if ($area > 0 && $area < 1) {
                            $area = 1;
                        }
                        $subtotal = $itemPrice * $itemData['quantity'] * $area;
                    }
                }

                $totalAmount += $subtotal;

                // Prepare item data for update/create
                $preparedItemData = [
                    'product_id' => $itemData['product_id'],
                    'product_price_option_id' => $itemData['price_option_id'] ?? null, // Added
                    'quantity' => $itemData['quantity'],
                    'size' => $size,
                    'price' => $itemPrice,
                    'subtotal' => $subtotal,
                    'specifications' => json_encode($selectedSpecifications),
                ];

                if (isset($itemData['item_id'])) {
                    // Update existing item
                    $orderItem = OrderItem::where('id', $itemData['item_id'])
                        ->where('order_id', $order->id)
                        ->firstOrFail();
                    $orderItem->update($preparedItemData);
                    $itemsToKeep[] = $orderItem->id;
                } else {
                    // Create new item
                    $orderItem = new OrderItem($preparedItemData);
                    $order->items()->save($orderItem);
                    $itemsToKeep[] = $orderItem->id;
                }
            }

            // Delete items that are no longer in the request
            $order->items()->whereNotIn('id', $itemsToKeep)->delete();

            $discountAmount = $request->input('discount', 0);
            $finalAmount = $totalAmount - $discountAmount;
            $paidAmount = $request->input('paid_amount', 0); // Get paid_amount from request
            $paymentStatus = $request->input('payment_status', 'unpaid'); // Get payment_status from request

            // Update order details
            $order->update([
                'customer_id' => $request->customer_id,
                'order_date' => $request->order_date,
                'deadline' => $request->deadline,
                'notes' => $request->notes,
                'total_amount' => $totalAmount,
                'discount' => $discountAmount,
                'final_amount' => $finalAmount,
                'payment_status' => $paymentStatus, // Use payment_status from request
                'paid_amount' => $paidAmount, // Use paid_amount from request
            ]);

            // Log production status change if status changed
            if ($request->has('status') && $order->status !== $request->status) {
                // End previous production log if exists
                $previousLog = ProductionLog::where('order_id', $order->id)
                    ->whereNull('end_time')
                    ->first();

                if ($previousLog) {
                    $previousLog->update(['end_time' => now()]);
                }

                // Create new production log
                ProductionLog::create([
                    'order_id' => $order->id,
                    'status' => $request->status,
                    'operator_id' => Auth::id(),
                    'start_time' => now(),
                ]);

                $order->update(['status' => $request->status]);
            }

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error updating order: ' . $e->getMessage());
        }
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Desain,Proses Desain,Proses Cetak,Finishing,Siap Diambil,Selesai',
            'notes' => 'nullable|string',
        ]);

        // End previous production log if exists
        $previousLog = ProductionLog::where('order_id', $order->id)
            ->whereNull('end_time')
            ->first();

        if ($previousLog) {
            $previousLog->update(['end_time' => now()]);
        }

        // Create new production log
        ProductionLog::create([
            'order_id' => $order->id,
            'status' => $request->status,
            'notes' => $request->notes,
            'operator_id' => Auth::id(),
            'start_time' => now(),
        ]);

        // Update order status
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function invoice(Request $request, Order $order)
    {
        $order->load('customer', 'items.product');

        // Set the locale for translation within the print blade
        app()->setLocale($request->query('lang') === 'en' ? 'en' : 'id');

        return view('orders.print_invoice', compact('order'));
    }
}
