<?php

namespace App\Policies;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShopPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Shop $shop): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isOwner();
    }

    public function update(User $user, Shop $shop): bool
    {
        return $user->isOwner() && $user()->id === $shop->user_id;
    }

    public function delete(User $user, Shop $shop): bool
    {
        return $user->isOwner() && $user()->id === $shop->user_id;
    }

}
