<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Material;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get today's orders count
        $todayOrdersCount = Order::whereDate('order_date', Carbon::today())->count();

        // Get orders in progress
        $inProgressOrdersCount = Order::whereIn('status', ['Proses Desain', 'Proses Cetak', 'Finishing'])->count();

        // Get completed orders
        $completedOrdersCount = Order::where('status', 'Selesai')->count();

        // Get low stock materials
        $lowStockMaterialsCount = Material::whereRaw('current_stock <= minimum_stock')->count();

        // Get recent orders
        $recentOrders = Order::with('customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get material stock status
        $materials = Material::orderBy('name')->get();

        return view('dashboard', compact(
            'todayOrdersCount',
            'inProgressOrdersCount',
            'completedOrdersCount',
            'lowStockMaterialsCount',
            'recentOrders',
            'materials'
        ));
    }
}
