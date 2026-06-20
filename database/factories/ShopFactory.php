<?php

namespace Database\Factories;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //整体・リラクゼーションサロンの名前
        $shops = [
            ['name' => 'リラクゼーションサロン 癒しの森',   'description' => '心と体を癒すリラクゼーションサロンです。',       'address' => '神奈川県横浜市西区南幸1-2-3'],
            ['name' => 'リラクゼーションサロン ほっと一息', 'description' => '日常の疲れを癒すリラクゼーションサロンです。',   'address' => '神奈川県横浜市鶴見区鶴見中央4-5-6'],
            ['name' => 'ボディケアサロン 癒しの手',        'description' => '手技で体を癒すボディケアサロンです。',          'address' => '神奈川県川崎市川崎区駅前本町1-1-1'],
            ['name' => '整体院 健康の杜',                 'description' => '体の不調を改善する整体院です。',              'address' => '神奈川県川崎市中原区小杉町2-2-2'],
            ['name' => 'リフレクソロジーサロン 足の癒し',   'description' => '足裏から全身を癒すリフレクソロジーサロンです。', 'address' => '神奈川県藤沢市藤沢3-3-3'],
            ['name' => '整体サロン ほぐしの館',            'description' => '筋肉のコリをほぐす整体サロンです。',           'address' => '神奈川県小田原市栄町6-16-17'],
            ['name' => '整体院 体のメンテナンス',          'description' => '体のメンテナンスを行う整体院です。',           'address' => '神奈川県茅ヶ崎市本村3-17-18'],
            ['name' => '鈴木整体院',                      'description' => '30年の経験を持つ院長が施術。スポーツ障害や慢性疲労にも対応します。', 'address' => '神奈川県相模原市中央区中央3-11-12'],
            ['name' => 'ボディケア結',                    'description' => 'スポーツマッサージとストレッチを組み合わせた施術が好評です。', 'address' => '神奈川県厚木市中町2-13-14'],
            ['name' => '整体院 健',                       'description' => '指圧とカイロプラクティックを融合した独自メソッドで施術します。', 'address' => '神奈川県平塚市紅谷町5-15-16'],
        ];

            $shop = fake()->unique()->randomElement($shops);

        return [
            'user_id' => User::factory(),
            'name' => $shop['name'],
            'address' => $shop['address'],
            'description' => $shop['description'],
        ];
    }
}
