<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::with('user')->latest()->paginate(10);
        return view('shops.index', compact('shops'));
    }

    public function create()
    {
        $this->authorize('create', Shop::class);
        return view('shops.create');
    }

    public function store(StoreShopRequest $request)
    {
        $request->user()->shops()->create($request->validated());
        return redirect()->route('shops.index')
            ->with('success', '店舗を登録しました');
    }

    public function show(Shop $shop)
    {
        return view('shops.show', compact('shop'));
    }

    public function edit(Shop $shop)
    {
        $this->authorize('update', $shop);
        return view('shops.edit', compact('shop'));
    }

    public function update(UpdateShopRequest $request, Shop $shop)
    {
        $this->authorize('update', $shop);
        $shop->update($request->validated());
        return redirect()->route('shops.index')
            ->with('success', '店舗情報を更新しました');
    }

    public function destroy(Shop $shop)
    {
        $this->authorize('delete', $shop);
        $shop->delete();
        return redirect()->route('shops.index')
            ->with('success', '店舗を削除しました');
    }

}
