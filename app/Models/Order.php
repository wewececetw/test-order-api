<?php

namespace App\Models;

class Order
{
    public static function all()
    {
        return [
            ["order_id" => 1, "order_date" => "2024-06-01", "total_amount" => 300],
            ["order_id" => 2, "order_date" => "2024-06-02", "total_amount" => 500],
            ["order_id" => 3, "order_date" => "2024-06-03", "total_amount" => 200],
        ];
    }
} 