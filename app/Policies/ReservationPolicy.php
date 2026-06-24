<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{

    public function viewAny(User $user): bool
    {
        return $user->isUser();
    }

    public function viewAsOwner(User $user, Reservation $reservation): bool
    {
        return $user->isOwner() && $reservation->shop->user_id === $user->id;
    }

    public function view(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isUser();
    }

    public function update(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->user_id
            && $reservation->status === 'pending';
    }

    public function delete(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->user_id
            && $reservation->status === 'cancelled';
    }

    public function confirm(User $user, Reservation $reservation): bool
    {
        return $user->isOwner() && $reservation->shop->user_id === $user->id
            && $reservation->status === 'pending';
    }

    public function cancel(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->user_id
            && $reservation->status !== 'cancelled';
    }

}
