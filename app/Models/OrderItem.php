<?php

namespace App\Models;

class OrderItem
{
    public static function all()
    {
        return [
            ["item_id" => 1, "order_id" => 1, "product_name" => "蘋果", "category" => "水果", "quantity" => 10, "price" => 10],
            ["item_id" => 2, "order_id" => 1, "product_name" => "香蕉", "category" => "水果", "quantity" => 5, "price" => 20],
            ["item_id" => 3, "order_id" => 2, "product_name" => "牛奶", "category" => "飲料", "quantity" => 10, "price" => 30],
            ["item_id" => 4, "order_id" => 2, "product_name" => "麵包", "category" => "食品", "quantity" => 5, "price" => 40],
            ["item_id" => 5, "order_id" => 3, "product_name" => "水", "category" => "飲料", "quantity" => 10, "price" => 20],
        ];
    }
} 