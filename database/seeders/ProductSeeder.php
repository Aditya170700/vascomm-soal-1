<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = date('Y-m-d H:i:s');

        Product::insert([
            [
                'id' => 1,
                'name' => 'Kursi',
                'price' => 100000,
                'user_id' => 1,
                'created_at' => $date
            ],
            [
                'id' => 2,
                'name' => 'Meja',
                'price' => 150000,
                'user_id' => 1,
                'created_at' => $date
            ]
        ]);
    }
}
