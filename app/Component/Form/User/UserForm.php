<?php

declare(strict_types=1);

namespace App\Component\Form\User;

use App\Model\Service\UserService;
use Nette\Application\UI\Control;
use App\Model\Entity\User;
use Nette\Application\UI\Form;

class UserForm extends Control
{
    public function __construct(
		private User|null   $user,
        private UserService $userService,
	) {
        //parent::__construct();
        $this->user = $user;
        $this->userService = $userService;
	}

    public function render(): void {
        if ($this->presenter->isLogin) {
            $this->template->render(__DIR__ . '/Template/login.latte');
        } else {
            $this->template->render(__DIR__ . '/Template/register.latte');
        }
    }

    public function createComponentUserLoginForm(): Form
    {
        $form = new Form;
        $form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control mt-1');
        $form->addPassword('password', 'Password:')->setRequired()->setHtmlAttribute('class', 'form-control mt-1');
        $form->addSubmit('submit', 'OK')->setHtmlAttribute('class', 'btn btn-primary float-right mt-2');
        
        $form->onSuccess[] = [$this, 'loginFormOnSuccess'];

        return $form;
    }

    public function createComponentUserRegisterForm(): Form
    {
        $form = new Form;
        $form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control mt-1');
        $form->addText('email', 'Email:')->setRequired()->setHtmlAttribute('class', 'form-control mt-1');
        $form->addPassword('password', 'Password:')->setRequired()->setHtmlAttribute('class', 'form-control mt-1');
        $form->addSubmit('submit', 'OK')->setHtmlAttribute('class', 'btn btn-primary float-right mt-2');
        
        $form->onSuccess[] = [$this, 'registerFormOnSuccess'];

        return $form;
    }

    public function loginFormOnSuccess(Form $form, $data): void {
        
    }

    public function registerFormOnSuccess(Form $form, $data): void {

        if ($this->userService->findUserByName($data['name'])) {
            $this->presenter->flashMessage('Username already taken!');
            return;
        }

        $this->userService->registerUser($data);
        $this->presenter->flashMessage('Registered successfully');
    }
}