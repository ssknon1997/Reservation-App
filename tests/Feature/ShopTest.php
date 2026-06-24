<?php

use App\Models\Shop;
use App\Models\User;


test('店舗一覧はログインしていなくても見られる', function () {
    $response = $this->get(route('shops.index'));
    $response->assertStatus(200);
});

test('店舗詳細はログインしていなくても見られる', function () {
    $shop = Shop::factory()->create();
    $response = $this->get(route('shops.show', $shop));
    $response->assertStatus(200);
});

test('オーナーは店舗を作成できる', function () {
    $owner = User::factory()->create(['role' => 'owner']);

    $response = $this->actingAs($owner)->post(route('shops.store'), [
        'name'        => 'テスト店舗',
        'address'     => '神奈川横浜市1-1-1',
        'description' => 'テスト用の店舗です',
    ]);

    $response->assertRedirect(route('shops.index'));
    $this->assertDatabaseHas('shops', ['name' => 'テスト店舗']);
});

test('一般ユーザーは店舗を作成できない', function () {
    $user = User::factory()->create(['role' => 'user']);

    $response = $this->actingAs($user)->post(route('shops.store'), [
        'name'        => 'テスト店舗',
        'address'     => '神奈川横浜市1-1-1',
        'description' => 'テスト用の店舗です',
    ]);

    $response->assertStatus(403);
});

test('オーナーは自分の店舗を編集できる', function(){
    $owner = User::factory()->create(['role' => 'owner']);
    $shop = Shop::factory()->create(['user_id' => $owner->id]);

    $response = $this->actingAs($owner)->put(route('shops.update', $shop), [
        'name'        => '更新後の店舗',
        'address'     => '神奈川横浜市2-2-2',
        'description' => '更新後の説明です',
    ]);

    $response->assertRedirect(route('shops.index'));
    $this->assertDatabaseHas('shops', ['name' => '更新後の店舗']);
});

test('オーナーは他人の店舗を編集できない', function() {
    $owner = User::factory()->create(['role' => 'owner']);
    $other = User::factory()->create(['role' => 'owner']);
    $shop  = Shop::factory()->create(['user_id' => $other->id]);

    $response = $this->actingAs($owner)->put(route('shops.update', $shop), [
        'name'        => '不正な更新',
        'address'     => '不正な住所',
        'description' => '不正な説明',
    ]);

    $response->assertStatus(403);
});

test('オーナーは自分の店舗を削除できる', function() {
    $owner = User::factory()->create(['role' => 'owner']);
    $shop = Shop::factory()->create(['user_id' => $owner->id]);

    $response = $this->actingAs($owner)->delete(route('shops.destroy', $shop));

    $response->assertRedirect(route('shops.index'));
    $this->assertDatabaseMissing('shops', ['id' => $shop->id]);
});
