<?php

declare(strict_types=1);

namespace App\Model\Service;

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
        $warehouse = new Warehouse();  # TODO also add date of creation
        $warehouse->setName($data['name']);
        $warehouse->setLocation($data['location']);
        $warehouse->setEmail($data['email']);
        
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
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->delete(Warehouse::class, 'w')
            ->where('w.id = :id')
            ->setParameter('id', $id);

        $queryBuilder->getQuery()->execute();
        
        $queryBuilder->delete(Storage::class, 's')
            ->where('s.warehouse_id = :id')
            ->setParameter('id', $id);

        $queryBuilder->getQuery()->execute();
    }
    
}
