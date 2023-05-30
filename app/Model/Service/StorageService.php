<?php

declare(strict_types=1);

namespace App\Model\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Model\Entity\Storage;
use App\Model\Entity\Warehouse;


class StorageService
{
    private EntityManagerInterface $entityManager;
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function getStorageSpecific() {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('w')->from(Warehouse::class, 'w');        
        $warehouses = $queryBuilder->getQuery()->getResult();
        return $warehouses;
    }

    public function getStorage($id) {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('s')->from(Storage::class, 's')->where('s.warehouse_id = :id')->setParameter('id', $id);        
        $storage = $queryBuilder->getQuery()->getResult();
        $queryBuilder->resetDQLParts();
        $queryBuilder->select('w')->from(Warehouse::class, 'w')->where('w.id = :id')->setParameter('id', $id);
        $warehouse = $queryBuilder->getQuery()->getResult();
        return [
            'storage' => $storage,
            'warehouse' => $warehouse[0]
        ];
    }

    public function addStorage($data): void {
        $storage_item = new Storage();
        $storage_item->setName($data['name']);
        $storage_item->setDescription($data['description']);
        $storage_item->setCode(intval($data['code']));
        $storage_item->setPrice(floatval($data['price']));
        $storage_item->setWarehouseId(intval($data['id']));
        
        $this->entityManager->persist($storage_item);
        $this->entityManager->flush();
    }

    public function editStorage($data): void {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->update(Storage::class, 's')
                     ->set('s.name', ':name')
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
    }

    public function moveStorage($data): void {
        $item_id = $data['id'];

        foreach ($data as $key => $value) {
            if ($value === null) {
                $data->offsetUnset($key);
            }
        }

        $data = array_keys((array) $data);

        $warehouse_to = $data[0];

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->update(Storage::class, 's')->set('s.warehouse_id', ':warehouse_id')->where('s.id = :item_id')
                                                  ->setParameter('warehouse_id', $warehouse_to)
                                                  ->setParameter('item_id', $item_id);
        
        $queryBuilder->getQuery()->execute();
    }

    public function deleteStorage($itemId): void {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->delete(Storage::class, 's')
            ->where('s.id = :id')
            ->setParameter('id', $itemId);

        $queryBuilder->getQuery()->execute();
    }
}