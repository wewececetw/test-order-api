<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class ConsistencyCheckController extends Controller
{
    public function check()
    {
        $orders = Order::all();
        $orderItems = OrderItem::all();
        $errors = [];
        $orderMap = collect($orders)->keyBy('order_id');
        $itemsByOrder = collect($orderItems)->groupBy('order_id');

        foreach ($orderMap as $order_id => $order) {
            $items = $itemsByOrder->get($order_id, collect());
            // 檢查空項目
            if ($items->isEmpty()) {
                $errors[] = "訂單 {$order_id} 無明細項目";
                continue;
            }
            
            // 初始化訂單總金額
            $total = 0;
            
            // 檢查金額
            foreach ($items as $item) {
                // 檢查負價格
                if ($item['price'] < 0) {
                    $errors[] = "訂單 {$order_id} 項目 {$item['item_id']} 價格為負";
                }
                // 計算該項目的總金額並加入訂單總金額
                $itemTotal = $item['price'] * $item['quantity'];
                $total += $itemTotal;
            }
            
            // 檢查訂單總金額是否相符
            if ($total != $order['total_amount']) {
                $errors[] = "訂單 {$order_id} 金額不符，明細總和 {$total}，訂單金額 {$order['total_amount']}";
            }
            // 檢查日期（此範例略過，因 item 無創建時間）
        }
        
        return response()->json([
            'errors' => $errors,
            'status' => empty($errors) ? '通過' : '有異常'
        ]);
    }
} 