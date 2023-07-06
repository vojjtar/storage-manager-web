<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\Service\UserService;
use Nette;
use Nette\Application\UI\Presenter;


final class UserPresenter extends Presenter
{
    private UserService $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    public function renderDefault(): void
    {

    }

    public function createComponentUserLoginForm()
    {
        
    }

    public function createComponentUserRegisterForm()
    {

    }

}