<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSummaryController extends Controller
{
    public function summary(Request $request)
    {
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $category = $request->query('category');

        // 日期格式檢查
        if (!self::validateDate($start_date) || !self::validateDate($end_date)) {
            return response()->json(['error' => '日期格式錯誤'], 400);
        }

        $orders = collect(Order::all())
            ->where('order_date', ">=", $start_date)
            ->where('order_date', "<=", $end_date);
        $order_ids = $orders->pluck('order_id')->toArray();

        $items = collect(OrderItem::all())
            ->whereIn('order_id', $order_ids);
        if ($category) {
            $items = $items->where('category', $category);
        }

        $summary = $items->groupBy('category')->map(function ($group, $cat) {
            return [
                'category' => $cat,
                'total_quantity' => $group->sum('quantity'),
                'total_amount' => $group->sum(function ($item) {
                    return $item['quantity'] * $item['price'];
                })
            ];
        })->values();

        // 日誌記錄
        Log::info('訂單匯總查詢', [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'category' => $category,
            'result_count' => $summary->count()
        ]);

        if ($summary->isEmpty()) {
            return response()->json(['message' => '查無資料']);
        }
        return response()->json($summary);
    }

    private static function validateDate($date)
    {
        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) && strtotime($date);
    }
} 