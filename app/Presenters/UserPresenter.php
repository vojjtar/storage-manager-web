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

    public function actionLogin(): void {
        $this->isLogin = true;
        $this->template->setFile(__DIR__ . '/templates/User/default.latte');
    }

    public function actionRegister(): void {
        $this->isLogin = false;
        $this->template->setFile(__DIR__ . '/templates/User/default.latte');
    }

    public function createComponentUserForm(): UserForm
    {
        return $this->userFormFactory->create();
    }

}