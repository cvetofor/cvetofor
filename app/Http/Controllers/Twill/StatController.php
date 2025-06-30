<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatController extends Controller {
    public function index(Request $request) {
        $startDate = $request->input('start_date', Carbon::now()->subDays(31)->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $query = Order::query()
            ->where('order_status_id', 4) // Статус "Выполнен"
            ->whereBetween('created_at', [$startDate, Carbon::parse($endDate)->endOfDay()]);

        $stats = [
            'total_orders' => $query->count(),
            'total_revenue' => $query->sum('total_price'),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        return view('twill.stats.index', [
            'stats' => $stats,
        ]);
    }
}
