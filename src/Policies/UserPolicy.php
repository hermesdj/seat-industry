<?php

namespace Seat\HermesDj\Industry\Policies;

class UserPolicy
{
    public static function checkUser($user, $user_id): bool
    {
        return $user->id === $user_id || $user->can('global.superuser') || $user->can('Industry.admin');
    }
}
