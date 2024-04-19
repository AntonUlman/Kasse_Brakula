<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuItems = [
            ['Wasser', 1.60, 10],
            ['Kaffee', 2.50, 20],
            ['Tee', 2.00, 15],
            ['Saft', 2.80, 12],
            ['Bier', 3.50, 25],
            ['Wein', 4.00, 30],
            ['Kuchen', 3.00, 10],
            ['Sandwich', 5.00, 10],
            ['Salat', 4.50, 10],
            ['Pasta', 6.50, 10],
        ];

        foreach ($menuItems as $index => $item) {
            Menu::create([
                'name' => $item[0],
                'price' => $item[1],
                'pieces' => $item[2]
            ]);
        }
    }
}
