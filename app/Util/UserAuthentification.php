<?php

declare(strict_types=1);

namespace App\Util;

use Nette;
use Nette\Security\Authenticator;
use Nette\Security\SimpleIdentity;

class UserAuthentificator implements Authenticator
{
    public function authenticate(string $username, string $password): SimpleIdentity {

    }
}