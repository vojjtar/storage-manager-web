<?php

declare(strict_types=1);

namespace App\Component\Form\Storage;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use App\Model\Entity\Storage;
use App\Model\Service\StorageService;
use App\Model\Service\WarehouseService;
use Mpdf\Mpdf;
use App\Util\InvoiceGenerator;


class StorageForm extends Control
{
    public function __construct(
        private Storage|null $storage,
        private StorageService $storageService,
        private WarehouseService $warehouseService,
        private InvoiceGenerator $invoiceGenerator,
    ) {
        $this->storage = $storage;
        $this->storageService = $storageService;
        $this->warehouseService = $warehouseService;
        $this->invoiceGenerator = $invoiceGenerator;
    }

    public function render(): void {
        if ($this->presenter->showMove) {
            $this->template->render(__DIR__ . '/Template/move.latte');
        } 
        if ($this->presenter->showAddTo) {
            $this->template->render(__DIR__ . '/Template/addTo.latte');
        } 
        if ($this->presenter->showSend) {
            $this->template->render(__DIR__ . '/Template/send.latte');
        }
        else {
            $this->template->render(__DIR__ . '/Template/default.latte');
        }
    }

    public function createComponentStorageForm(): Form
    {
		$form = new Form;
        $form->addHidden('id', '');
        $form->addHidden('warehouse_id', 10);
		$form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('description', 'Description:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('code', 'Code:')->setRequired()->setHtmlAttribute('class', 'form-control');
        $form->addInteger('qty', 'Quantity')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('price', 'Price ($USD):')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addSubmit('send', 'OK')->setHtmlAttribute('class', 'btn btn-primary float-right');

        if ($this->storage !== null) {
            $form->setDefaults([
                'id' => $this->storage->getId(),
                'warehouse_id' => $this->storage->getWarehouse()->getId(),
                'name' => $this->storage->getName(),
                'description' => $this->storage->getDescription(),
                'code' => $this->storage->getCode(),
                'qty' => $this->storage->getQty(),
                'price' => $this->storage->getPrice()
            ]);
        }

        $form->onSuccess[] = [$this, 'storageFormOnSuccess'];

		return $form;
    }

    public function createComponentAddToStorageForm(): Form {

        $form = new Form();

        $form->addHidden('id', '');
        $form->addInteger('qty', 'Quantity:')->setHtmlAttribute('class', 'form-control');
        $form->addSubmit('save', 'Save')->setHtmlAttribute('class', 'btn btn-primary')->getControlPrototype();

        if ($this->storage !== null) {
            $form->setDefaults([
                'id' => $this->storage->getId(),
            ]);
        }

        $form->onSuccess[] = [$this, 'addToStorage'];

        return $form;
    }

    public function addToStorage(Form $form, $data) {
        $item_id = (int)$data['id'];
        $amount = $data['qty'];

        $this->storageService->addToStorage($item_id, $amount);
        $this->presenter->flashMessage('Storage added.');
    }

    public function createComponentSendStorageForm() {
        $form = new Form();

        $form->addHidden('id', '');
        $form->addInteger('qty', 'Quantity:')->setHtmlAttribute('class', 'form-control');
        $form->addSubmit('save', 'Save')->setHtmlAttribute('class', 'btn btn-primary')->getControlPrototype();

        if ($this->storage !== null) {
            $form->setDefaults([
                'id' => $this->storage->getId(),
            ]);
        }

        $form->onSuccess[] = [$this, 'sendStorage'];

        return $form;
    }

    public function sendStorage(Form $form, $data) {
        $item_id = (int)$data['id'];
        $amount = $data['qty'];

        $this->storageService->sendStorage($item_id, $amount);

        $invoiceString = $this->invoiceGenerator->generateInvoice($item_id, $amount);
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($invoiceString);
        $mpdf->Output();

        $this->presenter->flashMessage('Storage sent.');
    }

    public function storageFormOnSuccess(Form $form, $data): void {
        $already_exists = $this->storageService->getStorageByCode($data['code']);

        if ($already_exists !== null && intval($data->id) != $already_exists->getId()) {
            $this->presenter->flashMessage('Product code already exists');
        }
        else {
            if ($data->id !== '') {
                $this->storageService->editStorage($data);
                $this->redirect('this');
            }
            else {
    
                $data->warehouse_id = $this->presenter->getParameter('id'); // getting warehouse_id parameter from the url, could also take it from the template
                $this->storageService->addStorage($data);
                $this->redirect('this');
            }
        }
        //$this->presenter->redirect('default'); // cant redirect without passing warehouse ID
    }

    public function createComponentMoveStorageForm(): Form
    {
        $form = new Form;
        $warehouses = $this->warehouseService->getAllWarehouses();

        $form->addInteger('qty', 'Quantity:')->setHtmlAttribute('class', 'form-control');

        // bdump($warehouses);

        $warehousesArray = [];
        foreach ($warehouses as $warehouse) {
            $warehousesArray[$warehouse->getId()] = $warehouse->getName();
        }

        $form->addRadioList('selected_warehouse_id', '', $warehousesArray);

        $form->addHidden('id', '');
        $form->addHidden('current_warehouse_id');

        $form->addSubmit('save', 'Save')->setHtmlAttribute('class', 'btn btn-primary')->getControlPrototype();


        if ($this->storage !== null) {
            $form->setDefaults([
                'id' => $this->storage->getId(),
                'current_warehouse_id' => $this->storage->getWarehouse()->getId(),
            ]);
        }
        $form->onSuccess[] = [$this, 'moveStorage'];

        return $form;
    }

    public function moveStorage(Form $form, $data) {
        $this->storageService->moveStorage($data);
        $this->presenter->flashMessage('Storage moved.');
    }
}