<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

    $testUser = User::create([
        'name'              => 'テストユーザー',
        'email'             => 'user@example.com',
        'password'          => Hash::make('password'),
        'role'              => 'user',
        'email_verified_at' => now(),
    ]);

    $testOwner = User::create([
        'name'              => 'テストオーナー',
        'email'             => 'owner@example.com',
        'password'          => Hash::make('password'),
        'role'              => 'owner',
        'email_verified_at' => now(),
    ]);


    $testShop = Shop::create([
        'user_id'     => $testOwner->id,
        'name'        => 'テスト店舗',
        'address'     => '神奈川県横浜市西区南幸1-2-3',
        'description' => 'これはテスト用の店舗です。',
    ]);

    Reservation::create([
        'user_id'     => $testUser->id,
        'shop_id'     => $testShop->id,
        'reserved_at' => now()->addDays(3),
        'status'      => 'confirmed',
        'note'        => 'テスト用の予約です',
    ]);

    Reservation::create([
        'user_id'     => $testUser->id,
        'shop_id'     => $testShop->id,
        'reserved_at' => now()->addDays(5),
        'status'      => 'pending',
        'note'        => 'オーナー確認用のテスト予約です',
    ]);

    }
}
