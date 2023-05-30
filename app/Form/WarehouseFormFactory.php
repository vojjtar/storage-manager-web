<?php
declare(strict_types=1);

namespace App\Form;

use Nette\Application\UI\Form;

class WarehouseFormFactory
{
    public function createComponentWarehouseForm(): Form {
		$form = new Form;
		$form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('location', 'Location:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('email', 'Owner email:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addSubmit('send', 'Add')->setHtmlAttribute('class', 'btn btn-primary float-right');
		return $form;
    }

	public function createComponentWarehouseEditForm(): Form
    {
		$form = new Form;
        $form->addHidden('id');
		$form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('location', 'Location:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('email', 'Owner email:')->setRequired()->setHtmlAttribute('class', 'form-control');
        $form->addSubmit('delete', 'Delete')->setHtmlAttribute('class', 'btn btn-primary float-right');
		$form->addSubmit('edit', 'Edit')->setHtmlAttribute('class', 'btn btn-primary');
		return $form;
    }
}