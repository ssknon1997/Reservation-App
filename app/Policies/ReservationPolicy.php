<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->role === 'user';
    }

    public function view(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->user_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'user';
    }

    public function update(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->user_id;
    }

    public function delete(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->user_id;
    }

    public function confirm(User $user, Reservation $reservation): bool
    {
        return $user->isOwner() && $reservation->shop->user_id === $user->id;
    }

    public function cancel(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->user_id;
    }

}
