<?php

use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;

test('一般ユーザーは予約を作成できる', function () {
    $user = User::factory()->create(['role' => 'user']);
    $shop = Shop::factory()->create();

    $response = $this->actingAs($user)->post(route('reservations.store'), [
        'shop_id' => $shop->id,
        'reserved_at'    => now()->addDays(3)->format('Y-m-d H:i:s'),
        'note'    => 'テストメモ',
    ]);

    $response->assertRedirect(route('reservations.index'));
    $this->assertDatabaseHas('reservations', [
        'user_id' => $user->id,
        'shop_id' => $shop->id,
    ]);
});

test('オーナは予約を作成できない', function () {
    $owner = User::factory()->create(['role' => 'owner']);
    $shop = Shop::factory()->create();

    $response = $this->actingAs($owner)->post(route('reservations.store'), [
        'shop_id' => $shop->id,
        'reserved_at'    => now()->addDays(3)->format('Y-m-d H:i:s'),
    ]);

    $response->assertStatus(403);
});

test('一般ユーザーは自分の予約を編集できる', function () {
    $user = User::factory()->create(['role' => 'user']);
    $reservation = Reservation::factory()->create([
        'user_id' => $user->id,
        'status'  => 'pending',
    ]);

    $response = $this->actingAs($user)->put(route('reservations.update', $reservation), [
        'reserved_at' => now()->addDays(5)->format('Y-m-d H:i:s'),
        'note' => '更新後のメモ',
    ]);

    $response->assertRedirect(route('reservations.index'));
    $this->assertDatabaseHas('reservations', ['note' => '更新後のメモ',]);
});

test('一般ユーザーは他人の予約を編集できない', function () {
    $user = User::factory()->create(['role' => 'user']);
    $other = User::factory()->create(['role' => 'user']);
    $reservation = Reservation::factory()->create([
        'user_id' => $other->id,
        'status'  => 'pending',
        ]);

    $response = $this->actingAs($user)->put(route('reservations.update', $reservation), [
        'reserved_at' => now()->addDays(5)->format('Y-m-d H:i:s'),
    ]);

    $response->assertStatus(403);
});

test('一般ユーザーはキャンセル済みの自分の予約を削除できる', function (){
    $user = User::factory()->create(['role' => 'user']);
    $reservation = Reservation::factory()->create([
        'user_id' => $user->id,
        'status' => 'cancelled',
    ]);

    $response = $this->actingAs($user)->delete(route('reservations.destroy', $reservation));

    $response->assertRedirect(route('reservations.index'));
    $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);
});

test('ログインしていないユーザーは予約一覧を見られない', function () {
    $response = $this->get(route('reservations.index'));
    $response->assertRedirect(route('login'));
});

test('一般ユーザーは自分の予約をキャンセルできる', function () {
    $user        = User::factory()->create(['role' => 'user']);
    $reservation = Reservation::factory()->create([
        'user_id' => $user->id,
        'status'  => 'pending',
    ]);

    $response = $this->actingAs($user)->patch(route('reservations.cancel', $reservation));

    $response->assertRedirect(route('reservations.index'));
    $this->assertDatabaseHas('reservations', [
        'id'     => $reservation->id,
        'status' => 'cancelled',
    ]);
});

test('一般ユーザーは他人の予約をキャンセルできない', function () {
    $user        = User::factory()->create(['role' => 'user']);
    $other       = User::factory()->create(['role' => 'user']);
    $reservation = Reservation::factory()->create([
        'user_id' => $other->id,
        'status'  => 'pending',
    ]);

    $response = $this->actingAs($user)->patch(route('reservations.cancel', $reservation));

    $response->assertStatus(403);
    $this->assertDatabaseHas('reservations', [
        'id'     => $reservation->id,
        'status' => 'pending',
    ]);
});

test('オーナーは自分の店舗への予約を確定できる', function () {
    $owner       = User::factory()->create(['role' => 'owner']);
    $shop        = Shop::factory()->create(['user_id' => $owner->id]);
    $reservation = Reservation::factory()->create([
        'shop_id' => $shop->id,
        'status'  => 'pending',
    ]);

    $response = $this->actingAs($owner)->patch(route('owner.reservations.confirm', $reservation));

    $response->assertRedirect(route('owner.reservations.index'));
    $this->assertDatabaseHas('reservations', [
        'id'     => $reservation->id,
        'status' => 'confirmed',
    ]);
});

test('オーナーは他店舗の予約を確定できない', function () {
    $owner       = User::factory()->create(['role' => 'owner']);
    $otherOwner  = User::factory()->create(['role' => 'owner']);
    $otherShop   = Shop::factory()->create(['user_id' => $otherOwner->id]);
    $reservation = Reservation::factory()->create([
        'shop_id' => $otherShop->id,
        'status'  => 'pending',
    ]);

    $response = $this->actingAs($owner)->patch(route('owner.reservations.confirm', $reservation));

    $response->assertStatus(403);
    $this->assertDatabaseHas('reservations', [
        'id'     => $reservation->id,
        'status' => 'pending',
    ]);
});

test('一般ユーザーは予約を確定できない', function() {
    $user = User::factory()->create(['role' => 'user']);
    $reservation = Reservation::factory()->create(['status' => 'pending']);

    $response = $this->actingAs($user)->patch(route('owner.reservations.confirm', $reservation));

    $response->assertStatus(403);
});
