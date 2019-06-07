<?php

namespace App\Policies;

use App\User;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function pass(User $user, Product $product)
    {
        return $user->hasRole('Super Administrator') || $user->id == $product->user_id;
    }    
    public function product(User $user)
    {
        return $user->hasRole('Super Administrator') || $user->hasPermissionTo("Product");
    }    
}
