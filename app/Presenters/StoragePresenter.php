<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;
use App\Model\Service\StorageService;
use App\Form\StorageFormFactory;


final class StoragePresenter extends Presenter
{
    private StorageService $storageService;
    private StorageFormFactory $storageFormFactory;

    public function __construct(
        StorageService $storageService,
        StorageFormFactory $storageFormFactory
    )
    {
        $this->storageService = $storageService;
        $this->storageFormFactory = $storageFormFactory;
    }

    public function renderDefault($id)
    {
        $this->template->setParameters($this->storageService->getStorage($id));
    }

    public function createComponentStorageForm(): Form
    {
        $form = $this->storageFormFactory->createComponentStorageForm($this->getParameter('id'));
        $form->onSuccess[] = [$this, 'addStorage'];
        return $form;
    }

    public function createComponentEditStorageForm(): Form
    {
        $form = $this->storageFormFactory->createComponentEditStorageForm($this->getParameter('id'));
        $form->onSuccess[] = [$this, 'editStorage'];
		return $form;
    }

    public function createComponentMoveStorageForm(): Form
    {
        $form = $this->storageFormFactory->createComponentMoveStorageForm(
            $this->storageService->getStorageSpecific()
        );

        $form->onSuccess[] = [$this, 'moveStorage'];
        return $form;
    }

    public function addStorage(Form $form, $data): void
    {
        $this->storageService->addStorage($data);
		$this->flashMessage('Storage added.');
    }

    public function editStorage(Form $form, $data): void
    {
        $this->storageService->editStorage($data);
        $this->flashMessage('Storage edited');
    }

    public function moveStorage(Form $form, $data): void
    {
        $this->storageService->moveStorage($data);
        $this->flashMessage('Storage moved.');
    }

    public function handleDeleteStorage($itemId): void
    {
        $this->storageService->deleteStorage($itemId);
		$this->flashMessage('Storage deleted.');
    }

}