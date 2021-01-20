<?php

namespace App\Services\Adapters;

interface AuthenticationInterface
{
    public function authenticate($username, $password);
}
