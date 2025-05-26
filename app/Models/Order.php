<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    // 測試資料
    public static function all($columns = ['*'])
    {
        return collect([
            [
                'order_id' => 1,
                'order_date' => '2024-03-20',
                'total_amount' => 1500.00  // 3個水果(100*3) + 2個肉類(200*2) + 5個蔬菜(50*5)
            ],
            [
                'order_id' => 2,
                'order_date' => '2024-03-21',
                'total_amount' => 800.00   // 2個水果(100*2) + 3個蔬菜(50*3)
            ],
            [
                'order_id' => 3,
                'order_date' => '2024-03-22',
                'total_amount' => 600.00   // 1個肉類(200*1) + 4個蔬菜(50*4)
            ],
            [
                'order_id' => 4,
                'order_date' => '2024-03-23',
                'total_amount' => 0.00     // 異常案例：無明細項目
            ],
            [
                'order_id' => 5,
                'order_date' => '2024-03-24',
                'total_amount' => -100.00  // 異常案例：負金額
            ]
        ]);
    }
} 