<?php

namespace Seat\HermesDj\Industry\Policies;

class UserPolicy
{
    public static function checkUser($user, $user_id): bool
    {
        return $user->id === $user_id || $user->can('global.superuser') || $user->can('seat-industry.admin');
    }

    public static function modifyOrder($user, $order): bool
    {
        return $user->id === $order->user_id || $user->can('global.superuser') || $user->can('seat-industry.admin') || $user->can('seat-industry.manager');
    }

    public static function modifyDelivery($user, $delivery): bool
    {
        return $user->id === $delivery->user_id || $user->can('global.superuser') || $user->can('seat-industry.admin') || $user->can('seat-industry.manager');
    }
}
