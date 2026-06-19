<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $users = User::factory(50)->create([
            'role' => 'user',
        ]);

        $owners = User::factory(4)->create([
            'role' => 'owner',
        ]);

        $shops = Shop::factory(12)->recycle()->create([
            'user_id' => $owners->random()->id,
        ]);

        Reservation::factory(100)->recycle()->create([
            'user_id' => $users->random()->id,
            'shop_id' => $shops->random()->id,
        ]);

    }
}
