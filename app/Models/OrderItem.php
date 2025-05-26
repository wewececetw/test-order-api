<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'item_id';
    public $timestamps = false;

    public static function all($columns = ['*'])
    {
        return collect([
            // 訂單 1 的項目
            [
                'item_id' => 1,
                'order_id' => 1,
                'product_name' => '蘋果',
                'category' => '水果',
                'quantity' => 3,
                'price' => 100.00
            ],
            [
                'item_id' => 2,
                'order_id' => 1,
                'product_name' => '豬肉',
                'category' => '肉類',
                'quantity' => 2,
                'price' => 200.00
            ],
            [
                'item_id' => 3,
                'order_id' => 1,
                'product_name' => '胡蘿蔔',
                'category' => '蔬菜',
                'quantity' => 5,
                'price' => 50.00
            ],
            // 訂單 2 的項目
            [
                'item_id' => 4,
                'order_id' => 2,
                'product_name' => '香蕉',
                'category' => '水果',
                'quantity' => 2,
                'price' => 100.00
            ],
            [
                'item_id' => 5,
                'order_id' => 2,
                'product_name' => '高麗菜',
                'category' => '蔬菜',
                'quantity' => 3,
                'price' => 50.00
            ],
            // 訂單 3 的項目
            [
                'item_id' => 6,
                'order_id' => 3,
                'product_name' => '雞肉',
                'category' => '肉類',
                'quantity' => 1,
                'price' => 200.00
            ],
            [
                'item_id' => 7,
                'order_id' => 3,
                'product_name' => '白菜',
                'category' => '蔬菜',
                'quantity' => 4,
                'price' => 50.00
            ],
            // 訂單 4 無項目（異常案例）
            // 訂單 5 的項目（異常案例：負價格）
            [
                'item_id' => 8,
                'order_id' => 5,
                'product_name' => '壞掉的蘋果',
                'category' => '水果',
                'quantity' => 2,
                'price' => -50.00
            ]
        ]);
    }
} 