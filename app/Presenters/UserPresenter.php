<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Component\Form\User\UserForm;
use App\Model\Service\UserService;
use Nette;
use Nette\Application\UI\Presenter;
use App\Component\Form\User\UserFormFactory;


final class UserPresenter extends Presenter
{
    private UserService $userService;
    private UserFormFactory $userFormFactory;
    public bool|null $isLogin = null;

    public function __construct(
        UserService     $userService,
        UserFormFactory $userFormFactory
    ) {
        $this->userFormFactory = $userFormFactory;
        $this->userService = $userService;
    }

    public function renderDefault(): void
    {
        $route = 'register';
        if ($route === 'login') {
            $this->isLogin = true;
        }
        else {
            $this->isLogin = false;
        }
    }

    public function createComponentUserForm(): UserForm
    {
        return $this->userFormFactory->create();
    }

}