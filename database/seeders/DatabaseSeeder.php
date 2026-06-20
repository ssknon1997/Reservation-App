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

    $users = User::factory(10)->create(['role' => 'user']);

    $owners = User::factory(5)->create(['role' => 'owner']);

    $shops = collect();
    foreach ($owners as $owner) {
        $ownerShops = Shop::factory(2)->create(['user_id' => $owner->id]);
        $shops = $shops->merge($ownerShops);
    }

    foreach ($users as $user) {
        Reservation::factory(3)->create([
            'user_id' => $user->id,
            'shop_id' => $shops->random()->id,
        ]);
    }

    }
}
