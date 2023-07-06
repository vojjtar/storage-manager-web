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
        if ($this->presenter->login) {
            $this->template->render(__DIR__ . '/Template/login.latte');
        } else {
            $this->template->render(__DIR__ . '/Template/register.latte');
        }
    }

    public function createComponentUserLoginForm(): Form
    {
        $form = new Form;
        $form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control');
        $form->addPassword('password', 'Password:')->setRequired()->setHtmlAttribute('class', 'form-control');
        
        return $form;
    }

    public function createComponentUserRegisterForm(): Form
    {
        $form = new Form;
        $form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control');
        $form->addText('email', 'Email:')->setRequired()->setHtmlAttribute('class', 'form-control');
        $form->addPassword('password', 'Password:')->setRequired()->setHtmlAttribute('class', 'form-control');
        
        return $form;
    }
}