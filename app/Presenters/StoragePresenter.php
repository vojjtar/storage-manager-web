<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Component\Form\Storage\StorageForm;
use Nette;
use Mpdf\Mpdf;
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

    public bool|null $showMove = false;

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
        $this->template->movementsData = [];
    }

    public function createComponentStorageForm(): StorageForm
    {
        $storage = null;
        
        if ($this->id_item !== null) {
            $storage = $this->storageService->getStorageSpecific($this->id_item);
        }

        return $this->storageFormFactory->create($storage);
    }
    
    public function createComponentMoveStorageForm(): StorageForm
    {
        $storage = null;
        
        if ($this->id_item !== null) {
            $storage = $this->storageService->getStorageSpecific($this->id_item);
        }

        return $this->storageFormFactory->create($storage);
    }

    public function handleDeleteStorage($itemId): void
    {
        $this->storageService->deleteStorage($itemId);
		$this->flashMessage('Storage deleted.');
    }

    // public function handleShow(array $params) {
    //     if ($this->isAjax()) {
    //         $this->template->id_item = intval($params['id']);
    //         $this->id_item = intval($params['id']);

    //         if ($params['action'] == 'default') {
    //             $this->showMove = false;
    //             $this->redrawControl('storageFormSnippet');
    //         }
    //         else if ($params['action'] == 'move') {
    //             $this->showMove = true;
    //             $this->redrawControl('storageFormMoveSnippet');
    //         }

    //     }
    // }

    public function handleShow($id_item) {
        if ($this->isAjax()) {
            $this->template->id_item = intval($id_item);
            $this->id_item = intval($id_item);
            $this->showMove = false;
            $this->redrawControl('storageFormSnippet');
        }
    }

    public function handleShowMove($id_item) {
        if ($this->isAjax()) {
            $this->template->id_item = intval($id_item);
            $this->id_item = intval($id_item);
            $this->showMove = true;
            $this->redrawControl('storageFormMoveSnippet');
        }
    }

    public function handleShowHistory($id_item) {
        $storage = $this->storageService->getStorageSpecific($id_item);
        if ($this->isAjax()) {
            if ($storage !== null) {
                $movements = $storage->getMovements();
                $this->template->movements = $movements;
                $this->redrawControl('movementHistory');   
            }
        }
    }

    // public function actionDefault()
    // {
    //     // // Create an instance of mPDF
    //     // $mpdf = new Mpdf();

    //     // // Your content for the PDF
    //     // $html = '<h1>Hello, mPDF!</h1>';

    //     // // Add content to the PDF
    //     // $mpdf->WriteHTML($html);

    //     // // Optional: Set PDF properties like title, author, etc.
    //     // $mpdf->SetTitle('My PDF');
    //     // $mpdf->SetAuthor('Your Name');

    //     // // Output the PDF to the browser
    //     // $mpdf->Output('my_pdf.pdf', 'D');
    // }
}