<?php

declare(strict_types=1);

namespace App\Presenters;


use Nette;
use Nette\Application\UI\Presenter;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\Entity\Warehouse;
use Nette\Application\UI\Form;


class WarehousePresenter extends Presenter
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function renderDefault()
    {
        $this->template->warehouses = $this->getWarehouse('all');
    }

    public function createComponentWarehouseForm(): Form
    {
		$form = new Form;
		$form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('location', 'Location:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('email', 'Owner email:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addSubmit('send', 'Add')->setHtmlAttribute('class', 'btn btn-primary float-right');
		$form->onSuccess[] = [$this, 'addWarehouse'];
		return $form;
    }
    public function createComponentWarehouseEditForm(): Form
    {
		$form = new Form;
        $form->addHidden('id');
		$form->addText('name', 'Name:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('location', 'Location:')->setRequired()->setHtmlAttribute('class', 'form-control');
		$form->addText('email', 'Owner email:')->setRequired()->setHtmlAttribute('class', 'form-control');
        $form->addSubmit('delete', 'Delete')->setHtmlAttribute('class', 'btn btn-primary float-right')->onClick[] = [$this, 'deleteWarehouse'];
		$form->addSubmit('edit', 'Edit')->setHtmlAttribute('class', 'btn btn-primary')->onClick[] = [$this, 'editWarehouse'];
		return $form;
    }

	public function addWarehouse(Form $form, $data): void
	{
        $warehouse = new Warehouse();
        $warehouse->setName($data['name']);
        $warehouse->setLocation($data['location']);
        $warehouse->setEmail($data['email']);
        
        $this->entityManager->persist($warehouse);
        $this->entityManager->flush();

		$this->flashMessage('Storage added.');
		$this->redirect('this');
	}

    public function getWarehouse(string $specify): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('w')->from(Warehouse::class, 'w');        
        $warehouses = $queryBuilder->getQuery()->getResult();

        return $warehouses;
    }

    public function editWarehouse(Form $form, $data): void
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->update(Warehouse::class, 'w')->set('w.name', ':name')
                                                    ->set('w.location', ':location')
                                                    ->set('w.email', ':email')
                                                    ->where('w.id = :id')
                                                    ->setParameter('id', $data['id'])
                                                    ->setParameter('name', $data['name'])
                                                    ->setParameter('location', $data['location'])
                                                    ->setParameter('email', $data['email']);

        $queryBuilder->getQuery()->execute();
    }

    public function deleteWarehouse(Form $form, $data): void {

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->delete(Warehouse::class, 'w')
            ->where('w.id = :id')
            ->setParameter('id', $data['id']);

        $queryBuilder->getQuery()->execute();
    }

}