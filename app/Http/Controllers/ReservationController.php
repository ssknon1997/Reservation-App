<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Shop;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;

class ReservationController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny', Reservation::class);
        $reservations = auth()->user()
            ->reservations()
            ->with('shop')
            ->latest()
            ->paginate(10);
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $this->authorize('create', Reservation::class);
        $shop = request('shop_id') ? Shop::findOrFail(request('shop_id')) : null;
        $shops = $shop ? collect() : Shop::select('id', 'name')->get();
        return view('reservations.create', compact('shops', 'shop'));
    }

    public function store(StoreReservationRequest $request)
    {
        auth()->user()->reservations()->create($request->validated());
        return redirect()->route('reservations.index')
            ->with('success', '予約を作成しました');
    }

    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $this->authorize('update', $reservation);
        return view('reservations.edit', compact('reservation'));
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);
        $reservation->update($request->validated());
        return redirect()->route('reservations.index')
            ->with('success', '予約を編集しました');
    }

    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);
        $reservation->delete();
        return redirect()->route('reservations.index')
            ->with('success', '予約を削除しました');
    }

    public function cancel(Reservation $reservation)
    {
        $this->authorize('cancel', $reservation);
        $reservation->update(['status' => 'cancelled']);
        return redirect()->route('reservations.index')
            ->with('success', '予約をキャンセルしました');
    }
}
