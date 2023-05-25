<?php

namespace App\Exports;





class DeliveryReport implements  
{
    public function mapping(): array
    {
        return [
            'name'  => 'G1',
            'email' => 'B2',
        ];
    }
    public function model(array $row)
    {
        return new UserOrderItem([
            'name' => $row['product_name'],
            'email' => $row['email'],
        ]);
    }
}
