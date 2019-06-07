<?php

namespace App\Policies;

use App\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
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
    public function pass(User $user, Order $order)
    {
        return $user->hasRole('Super Administrator') || $user->id == $order->user_id;
    }    
    public function order(User $user)
    {
        return $user->hasRole('Super Administrator') || $user->hasPermissionTo("Order");
    }    
}
