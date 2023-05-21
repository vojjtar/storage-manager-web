<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Presenter;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\Entity\Storage;
use App\Model\Entity\Warehouse;
use Nette\Application\UI\Form;


final class StoragePresenter extends Presenter
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function renderDefault($id)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('s')->from(Storage::class, 's')->where('s.warehouse_id = :id')->setParameter('id', $id);        
        $storage = $queryBuilder->getQuery()->getResult();
        $queryBuilder->resetDQLParts();
        $queryBuilder->select('w')->from(Warehouse::class, 'w')->where('w.id = :id')->setParameter('id', $id);
        $warehouse = $queryBuilder->getQuery()->getResult();
        
        $this->template->setParameters([
            'storage' => $storage,
            'warehouse' => $warehouse[0]
        ]);
    }

    public function createComponentStorageForm(): Form
    {
		$form = new Form;
        
        $form->addHidden('id', $this->getParameter('id'));
		$form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('description', 'Description:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('code', 'Code:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('price', 'Price ($USD):')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addSubmit('send', 'Add')->setHtmlAttribute('class', 'btn btn-primary float-right');
		$form->onSuccess[] = [$this, 'addStorage'];
		return $form;
    }

    public function createComponentEditStorageForm(): Form
    {
		$form = new Form;
        
        $form->addHidden('id', $this->getParameter('id'));
        $form->addHidden('warehouse_id');
        // $form->addText('id2', 'id:')->setDefaultValue($this->getParameter('id'));
		$form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('description', 'Description:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('code', 'Code:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('price', 'Price ($USD):')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addSubmit('send', 'Edit')->setHtmlAttribute('class', 'btn btn-primary float-right');
		$form->onSuccess[] = [$this, 'editStorage'];
		return $form;
    }

    public function createComponentMoveStorageForm(): Form
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('w')->from(Warehouse::class, 'w');        
        $warehouses = $queryBuilder->getQuery()->getResult();

        $form = new Form;

        foreach ($warehouses as $warehouse) {
            $form->addButton(strval($warehouse->getId()), $warehouse->getName())->getControlPrototype()->type('submit');;
        }

        $form->addHidden('warehouse_id', $this->getParameter('id'));
        $form->addHidden('id');

        //$form->addSelect('id', 'Choose storage:', $warehouses);

		//$form->addSubmit('send', 'Move')->setHtmlAttribute('class', 'btn btn-primary float-right');

        //$form->addCheckboxList
		$form->onSuccess[] = [$this, 'moveStorage'];

        return $form;
    }

    public function addStorage(Form $form, $data): void
    {
        $storage_item = new Storage();
        $storage_item->setName($data['name']);
        $storage_item->setDescription($data['description']);
        $storage_item->setCode(intval($data['code']));
        $storage_item->setPrice(floatval($data['price']));
        $storage_item->setWarehouseId(intval($data['id']));
        
        $this->entityManager->persist($storage_item);
        $this->entityManager->flush();

		$this->flashMessage('Storage added.');
		$this->redirect('this');
    }

    public function handleDeleteStorage($itemId): void
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->delete(Storage::class, 's')
            ->where('s.id = :id')
            ->setParameter('id', $itemId);

        $queryBuilder->getQuery()->execute();

        $this->redirect('this');
    }

    public function editStorage(Form $form, $data): void
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->update(Storage::class, 's')->set('s.name', ':name')
                                                    ->set('s.description', ':description')
                                                    ->set('s.code', ':code')
                                                    ->set('s.price', ':price')
                                                    ->where('s.id = :id')
                                                    ->setParameter('name', $data['name'])
                                                    ->setParameter('description', $data['description'])
                                                    ->setParameter('code', $data['code'])
                                                    ->setParameter('price', $data['price'])
                                                    ->setParameter('id', $data['id']);

        $queryBuilder->getQuery()->execute();

        $this->redirect('this');
    }

    public function moveStorage(Form $form, $data): void
    {
        foreach ($data as $item) {
            if ($item != null) {
                var_dump($item);
            }


        }
        die();
    }
}