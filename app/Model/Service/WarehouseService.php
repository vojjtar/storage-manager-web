<?php

declare(strict_types=1);

namespace App\Model\Service;

use DateTime;
use App\Model\Entity\Storage;
use App\Model\Entity\Warehouse;
use Doctrine\ORM\EntityManagerInterface;


class WarehouseService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function getAllWarehouses(): array {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('w')->from(Warehouse::class, 'w');        
        $warehouses = $queryBuilder->getQuery()->getResult();

        return $warehouses;
    }

    public function getSpecificWarehouse(int $id) {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('w')->from(Warehouse::class, 'w')->where('w.id = :id')->setParameter('id', $id);
        $warehouse = $queryBuilder->getQuery()->getOneOrNullResult();
        
        return $warehouse;
    }

    public function addWarehouse($data): void {
        $warehouse = new Warehouse();
        $warehouse->setName($data['name']);
        $warehouse->setLocation($data['location']);
        $warehouse->setEmail($data['email']);
        $warehouse->setCreated(new DateTime());
        
        $this->entityManager->persist($warehouse);
        $this->entityManager->flush();
    }

    public function editWarehouse($data): void {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->update(Warehouse::class, 'w')
                     ->set('w.name', ':name')
                     ->set('w.location', ':location')
                     ->set('w.email', ':email')
                     ->where('w.id = :id')
                     ->setParameter('id', $data['id'])
                     ->setParameter('name', $data['name'])
                     ->setParameter('location', $data['location'])
                     ->setParameter('email', $data['email']);

        $queryBuilder->getQuery()->execute();
    }

    public function deleteWarehouse($id): void {
        $warehouse = $this->entityManager->find(Warehouse::class, $id);

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->delete(Warehouse::class, 'w')
            ->where('w.id = :id')
            ->setParameter('id', $id);
        
        $queryBuilder->getQuery()->execute();

        $secondQueryBuilder = $this->entityManager->createQueryBuilder();
        $secondQueryBuilder->delete(Storage::class, 's')
            ->where('s.warehouse = :warehouse')
            ->setParameter('warehouse', $warehouse->getId());
        
        $secondQueryBuilder->getQuery()->execute();
        
    }
    
}
