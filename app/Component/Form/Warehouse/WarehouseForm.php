<?php
declare(strict_types=1);

namespace App\Component\Form\Warehouse;

use App\Model\Service\WarehouseService;
use Nette\Application\UI\Form;
use App\Model\Entity\Warehouse;
use App\Model\Manager\WarehouseManager;

class WarehouseForm extends Form
{
	public function __construct(
		private Warehouse|null   $warehouse,
        private WarehouseManager $warehouseManager,
        private WarehouseService $warehouseService,
	) {
        parent::__construct();
        $this->warehouse = $warehouse;
        $this->warehouseManager = $warehouseManager;
        $this->warehouseService = $warehouseService;
	}

    public function createComponentAddEditWarehouseForm(): Form {
		$form = new Form;
		$form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('location', 'Location:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('email', 'Owner email:')->setRequired()->setHtmlAttribute('class', 'form-control');
        $form->addSubmit('send', 'Add')->setHtmlAttribute('class', 'btn btn-primary float-right');
        $form->addHidden('id', '');

        // if ($this->warehouse !== null) {
        //     dump($this->warehouse);
        //     $form->setDefaults(
        //         [
        //             'name' => $this->warehouse->getName(),
        //             'location' => $this->warehouse->getLocation(),
        //             'email' => $this->warehouse->getEmail(),
        //         ]
        //     );
        // }

        $form->onSuccess[] = [$this, 'warehouseFormOnSuccess'];

		return $form;
    }

	// public function createComponentWarehouseEditForm(): Form
    // {
	// 	$form = new Form;
    //     $form->addHidden('id');
	// 	$form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control')->setDefaultValue('123');
	// 	$form->addText('location', 'Location:')->setRequired()->setHtmlAttribute('class', 'form-control');
	// 	$form->addText('email', 'Owner email:')->setRequired()->setHtmlAttribute('class', 'form-control');
    //     $form->addSubmit('delete', 'Delete')->setHtmlAttribute('class', 'btn btn-primary float-right');
	// 	$form->addSubmit('edit', 'Edit')->setHtmlAttribute('class', 'btn btn-primary');
	// 	return $form;
    // }

	public function warehouseFormOnSuccess(Form $form, $data): void {
        $this->warehouseService->addWarehouse($data);

		//$this->redirect('this');
	}
}