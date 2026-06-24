<?php

namespace App\Http\Controllers;

use App\Models\Reservation;

class OwnerReservationController extends Controller
{

    public function index()
    {
        $reservations = auth()->user()
            ->shops()
            ->with(['reservations.user', 'reservations.shop'])
            ->get()
            ->pluck('reservations')
            ->flatten()
            ->sortByDesc('reserved_at');

        return view('owner.reservations.index', compact('reservations'));
    }

    public function show(Reservation $reservation)
    {
        $this->authorize('viewAsOwner', $reservation);
        return view('owner.reservations.show', compact('reservation'));
    }

    public function confirm(Reservation $reservation)
    {
        $this->authorize('confirm', $reservation);
        $reservation->update(['status' => 'confirmed']);
        return redirect()->route('owner.reservations.index')
            ->with('success', '予約を確定しました');
    }
}
