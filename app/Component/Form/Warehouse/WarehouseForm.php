<?php
declare(strict_types=1);

namespace App\Component\Form\Warehouse;

use App\Model\Service\WarehouseService;
use Nette\Application\UI\Form;
use App\Model\Entity\Warehouse;
use App\Model\Manager\WarehouseManager;
use Nette\Application\UI\Control;
use Nette\Forms\Controls\SubmitButton;

class WarehouseForm extends Control
{
	public function __construct(
		private Warehouse|null   $warehouse,
        private WarehouseService $warehouseService,
	) {
        //parent::__construct();
        $this->warehouse = $warehouse;
        $this->warehouseService = $warehouseService;
	}

    public function render(): void {
        $this->template->render(__DIR__ . '/Template/default.latte');
    }

    public function createComponentWarehouseForm(): Form {
		$form = new Form;
		$form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('location', 'Location:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('email', 'Owner email:')->setRequired()->setHtmlAttribute('class', 'form-control');
        $form->addHidden('id', '');


        if ($this->warehouse !== null) {
            $form->addSubmit('edit', 'Edit')->setHtmlAttribute('class', 'btn btn-primary float-right');
            $form->setDefaults(
                [
                    'id' => $this->warehouse->getId(),
                    'name' => $this->warehouse->getName(),
                    'location' => $this->warehouse->getLocation(),
                    'email' => $this->warehouse->getEmail(),
                ]
            );
        }
        else {
            $form->addSubmit('add', 'Add')->setHtmlAttribute('class', 'btn btn-primary float-right');
        }

        $form->onSuccess[] = [$this, 'warehouseFormOnSuccess'];

		return $form;
    }

	public function warehouseFormOnSuccess(Form $form, $data): void {
        if ($data->id !== '') {
            $this->warehouseService->editWarehouse($data);
            $this->presenter->flashMessage('Warehouse edited');
        }
        else {
            $this->warehouseService->addWarehouse($data);
            $this->presenter->flashMessage('Warehouse added');
        }
        $this->presenter->redirect('default');
	}
}