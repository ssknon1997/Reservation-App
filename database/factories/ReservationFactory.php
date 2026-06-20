<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $notes = [
        '肩こりがひどいです',
        '腰痛が続いています',
        '全身疲労気味です',
        '頭痛もあります',
        'デスクワークで肩が張っています',
        'スポーツ後の筋肉疲労です',
        null,
        ];

        return [
            'user_id' => User::factory(),
            'shop_id' => Shop::factory(),
            'reserved_at' => fake()->dateTimeBetween('now', '+1 month'),
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
            'note' => fake()->optional()->randomElement($notes),
        ];
    }
}
