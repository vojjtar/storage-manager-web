<?php

declare(strict_types=1);

namespace App\Form;

use Nette\Application\UI\Form;


class StorageFormFactory
{
    public function createComponentStorageForm($id): Form
    {
		$form = new Form;
        
        $form->addHidden('id', $id);
		$form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('description', 'Description:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('code', 'Code:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('price', 'Price ($USD):')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addSubmit('send', 'Add')->setHtmlAttribute('class', 'btn btn-primary float-right');
		return $form;
    }

    public function createComponentEditStorageForm($id): Form {
		$form = new Form;
        
        $form->addHidden('id', $id);
        $form->addHidden('warehouse_id');
		$form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('description', 'Description:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('code', 'Code:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('price', 'Price ($USD):')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addSubmit('send', 'Edit')->setHtmlAttribute('class', 'btn btn-primary float-right');
		return $form;
    }
    public function createComponentMoveStorageForm($warehouses): Form
    {
        $form = new Form;

        foreach ($warehouses as $warehouse) {
            $form->addButton(strval($warehouse->getId()), $warehouse->getName())->setHtmlAttribute('class', 'btn btn-primary')
                                                                                ->getControlPrototype()->type('submit');
        }
        $form->addHidden('id');
        return $form;
    }
}