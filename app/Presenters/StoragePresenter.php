<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Component\Form\Storage\StorageForm;
use Nette;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;
use App\Model\Service\StorageService;
use App\Component\Form\Storage\StorageFormFactory;
use App\Model\Service\WarehouseService;


final class StoragePresenter extends Presenter
{
    private StorageService $storageService;
    private StorageFormFactory $storageFormFactory;
    private WarehouseService $warehouseService;
    public int|null $id_item = null;

    public function __construct(
        StorageService      $storageService,
        StorageFormFactory  $storageFormFactory,
        WarehouseService $warehouseService
    ) {
        $this->storageService     = $storageService;
        $this->storageFormFactory = $storageFormFactory;
        $this->warehouseService   = $warehouseService;
    }

    public function renderDefault($id): void
    {
        $this->template->setParameters($this->storageService->getStorage($id));
        $this->template->id_item = $this->id_item;
    }

    public function createComponentStorageForm(): StorageForm
    {
        $storage = null;
        
        if ($this->id_item !== null) {
            $storage = $this->storageService->getStorageSpecific($this->id_item);
        }

        return $this->storageFormFactory->create($storage);
    }
    
    public function createComponentMoveStorageForm(): Form
    {
        $form = new Form;
        $warehouses = $this->warehouseService->getAllWarehouses();

        foreach ($warehouses as $warehouse) {
            $form->addButton(strval($warehouse->getId()), $warehouse->getName())->setHtmlAttribute('class', 'btn btn-primary')
                                                                                ->getControlPrototype()->type('submit');
        }
        $form->addHidden('id', $this->id_item);

        $form->onSuccess[] = [$this, 'moveStorage'];

        return $form;
    }

    public function moveStorage(Form $form, $data) {
        $this->storageService->moveStorage($data);
        $this->flashMessage('Storage moved.');
    }

    public function handleDeleteStorage($itemId): void
    {
        $this->storageService->deleteStorage($itemId);
		$this->flashMessage('Storage deleted.');
    }

    public function handleShow($id_item) {
        if ($this->isAjax()) {
            $this->template->id_item = intval($id_item);
            $this->id_item = intval($id_item);
            $this->redrawControl('storageFormSnippet');
        }
    }

    public function handleShowMove($id_item) {
        if ($this->isAjax()) {
            $this->template->id_item = intval($id_item);
            $this->id_item = intval($id_item);
            $this->redrawControl('storageFormMoveSnippet');
        }
    }

}