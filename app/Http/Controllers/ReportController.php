<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Material;
use App\Models\StockLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function orders(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());
        $status = $request->input('status', 'all');

        $query = Order::with('customer')
            ->whereBetween('order_date', [$startDate, $endDate]);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->orderBy('order_date', 'desc')->get();

        // Calculate totals
        $totalOrders = $orders->count();
        $totalAmount = $orders->sum('final_amount');
        $totalDiscount = $orders->sum('discount');

        // Group by status
        $ordersByStatus = $orders->groupBy('status')->map->count();

        return view('reports.orders', compact(
            'orders',
            'startDate',
            'endDate',
            'status',
            'totalOrders',
            'totalAmount',
            'totalDiscount',
            'ordersByStatus'
        ));
    }

    public function customers(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());
        $statusFilter = $request->input('status_filter', 'all'); // Get the new filter

        $customers = Customer::with(['orders' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }])->get();

        // Filter customers with orders in the date range
        $customersWithOrders = $customers->filter(function ($customer) {
            return $customer->orders->isNotEmpty();
        })->map(function ($customer) {
            $customer->total_order_amount = $customer->orders->sum('final_amount');
            $customer->total_paid_amount = $customer->orders->sum('paid_amount');
            $customer->outstanding_debt = $customer->total_order_amount - $customer->total_paid_amount;
            return $customer;
        });

        // Apply the new status filter
        if ($statusFilter === 'outstanding_debt') {
            $customersWithOrders = $customersWithOrders->filter(function ($customer) {
                return $customer->outstanding_debt > 0;
            });
        }

        // Calculate totals
        $totalCustomers = $customersWithOrders->count();
        $totalOrders = $customersWithOrders->sum(function ($customer) {
            return $customer->orders->count();
        });
        $totalAmount = $customersWithOrders->sum('total_order_amount'); // Sum of final_amount
        $totalPaid = $customersWithOrders->sum('total_paid_amount');
        $totalOutstandingDebt = $customersWithOrders->sum('outstanding_debt');

        return view('reports.customers', compact(
            'customersWithOrders',
            'startDate',
            'endDate',
            'statusFilter', // Pass the statusFilter to the view
            'totalCustomers',
            'totalOrders',
            'totalAmount',
            'totalPaid',
            'totalOutstandingDebt'
        ));
    }

    public function production(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());

        $orders = Order::with(['customer', 'productionLogs.operator'])
            ->whereBetween('order_date', [$startDate, $endDate])
            ->orderBy('order_date', 'desc')
            ->get();

        // Group by status
        $ordersByStatus = $orders->groupBy('status')->map->count();

        // Calculate production time
        $ordersWithProductionTime = $orders->map(function ($order) {
            $logs = $order->productionLogs;

            $firstLog = $logs->first();

            if (!$firstLog || !$firstLog->start_time) {
                $order->production_time = null;
                return $order;
            }

            $start = Carbon::parse($firstLog->start_time);

            $lastLogWithEndTime = $logs->whereNotNull('end_time')->last();

            $end = $lastLogWithEndTime ? Carbon::parse($lastLogWithEndTime->end_time) : now();

            $order->production_time = $start->diffInHours($end);

            return $order;
        });

        // Average production time
        $avgProductionTime = $ordersWithProductionTime->whereNotNull('production_time')->avg('production_time');

        return view('reports.production', compact(
            'orders',
            'startDate',
            'endDate',
            'ordersByStatus',
            'avgProductionTime'
        ));
    }

    public function materials(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());

        $materials = Material::with(['stockLogs' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }])->get();

        // Calculate totals
        $totalIn = $materials->sum(function ($material) {
            return $material->stockLogs->where('type', 'in')->sum('quantity');
        });
        $totalOut = $materials->sum(function ($material) {
            return $material->stockLogs->where('type', 'out')->sum('quantity');
        });

        // Materials with low stock
        $lowStockMaterials = $materials->filter(function ($material) {
            return $material->isLowStock();
        });

        return view('reports.materials', compact(
            'materials',
            'startDate',
            'endDate',
            'totalIn',
            'totalOut',
            'lowStockMaterials'
        ));
    }

    public function profit(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());

        $orders = Order::whereBetween('order_date', [$startDate, $endDate])
            ->where('status', 'Selesai')
            ->get();

        // Calculate revenue
        $totalRevenue = $orders->sum('final_amount');

        // Calculate material costs (simplified)
        $materialCosts = StockLog::whereBetween('created_at', [$startDate, $endDate])
            ->where('type', 'out')
            ->get()
            ->sum(function ($log) {
                return $log->quantity * $log->material->price;
            });

        // Calculate profit
        $profit = $totalRevenue - $materialCosts;
        $profitMargin = $totalRevenue > 0 ? ($profit / $totalRevenue) * 100 : 0;

        return view('reports.profit', compact(
            'startDate',
            'endDate',
            'totalRevenue',
            'materialCosts',
            'profit',
            'profitMargin'
        ));
    }
}
