<?php

namespace App\Component\Form\User;

use App\Model\Entity\User;
use App\Component\Form\User\UserForm;

interface UserFormFactory
{
	public function create(?User $user = null): UserForm;
}