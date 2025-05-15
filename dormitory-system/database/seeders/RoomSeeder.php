<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create([
            'label' => '2F1',
            'floor' => 2,
            'monthly_rent' => 650.00,
            'capacity' => '5',
            'occupancy' => '3',
            'image' => 'images\room2f1.jpg',
        ]);
    }
}
