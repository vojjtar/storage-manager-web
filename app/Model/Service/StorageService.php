<?php

declare(strict_types=1);

namespace App\Model\Service;

use App\Model\Entity\StorageHistory;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\Entity\Storage;
use App\Model\Entity\Warehouse;
use DateTime;


class StorageService
{
    private EntityManagerInterface $entityManager;
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public function getStorageSpecific($id_item) {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('s')->from(Storage::class, 's')->where('s.id = :id')->setParameter('id', $id_item);        
        $storage = $queryBuilder->getQuery()->getOneOrNullResult();
        return $storage;
    }

    public function getStorageByCode($code_item) {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('s')->from(Storage::class, 's')->where('s.code = :code')->setParameter('code', $code_item);        
        $storage = $queryBuilder->getQuery()->getOneOrNullResult();
        return $storage;
    }

    public function getStorage($id) {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('s')->from(Storage::class, 's')->where('s.warehouse = :id')->setParameter('id', $id);        
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
        // exception pridat
        $warehouse = $this->entityManager->find(Warehouse::class, $data->warehouse_id);
        
        $storage_item = new Storage();
        $storage_item->setName($data['name']);
        $storage_item->setDescription($data['description']);
        $storage_item->setCode(intval($data['code']));
        $storage_item->setQty(intval($data['qty']));
        $storage_item->setPrice(floatval($data['price']));
        $storage_item->setWarehouse($warehouse);

        $this->entityManager->persist($storage_item);
        $this->entityManager->flush();
    }

    public function addToStorage($item_id, $amount): void {
        $storageItem = $this->entityManager->find(Storage::class, $item_id);

        if ($storageItem) {
            $currentQuantity = $storageItem->getQty();
            $storageItem->setQty((int)($currentQuantity + $amount));

            $this->entityManager->persist($storageItem);
            $this->entityManager->flush();
        }
    }

    public function sendStorage($item_id, $amount) {
        $storageItem = $this->entityManager->find(Storage::class, $item_id);

        if ($storageItem) {
            $currentQuantity = $storageItem->getQty();
            $storageItem->setQty((int)($currentQuantity - $amount));

            $this->entityManager->persist($storageItem);
            $this->entityManager->flush();
        }
    }

    public function editStorage($data): void {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->update(Storage::class, 's')
                     ->set('s.name', ':name')
                     ->set('s.description', ':description')
                     ->set('s.code', ':code')
                     ->set('s.qty', ':qty')
                     ->set('s.price', ':price')
                     ->where('s.id = :id')
                     ->setParameter('name', $data['name'])
                     ->setParameter('description', $data['description'])
                     ->setParameter('code', $data['code'])
                     ->setParameter('qty', $data['qty'])
                     ->setParameter('price', $data['price'])
                     ->setParameter('id', $data['id']);

        $queryBuilder->getQuery()->execute();
    }

    public function moveStorage($data): void
    {
        $itemId = (int)$data['id'];
        $quantityToMove = (int)$data['qty'];
        $targetWarehouseId = (int)$data['selected_warehouse_id'];
        $currentWarehouseId = (int)$data['current_warehouse_id'];


        $itemToMove = $this->entityManager->find(Storage::class, $itemId);
        $targetWarehouse = $this->entityManager->find(Warehouse::class, $targetWarehouseId);

    
        if ($itemToMove) {

            $currentQuantity = $itemToMove->getQty();

            if ($currentQuantity >= $quantityToMove) {

                $itemToMove->setQty((int)($currentQuantity - $quantityToMove));
    
                $itemInTargetWarehouse = $this->checkStorageExists($itemToMove->getCode(), $targetWarehouse);

                if ($itemInTargetWarehouse === null) {
                    $itemInTargetWarehouse = new Storage();
                    $itemInTargetWarehouse->setQty($quantityToMove);
                }
                else {
                    $itemInTargetWarehouse->setQty((int)($itemInTargetWarehouse->getQty() + $quantityToMove));
                }

                $itemInTargetWarehouse->setName($itemToMove->getName());
                $itemInTargetWarehouse->setCode($itemToMove->getCode());
                $itemInTargetWarehouse->setPrice($itemToMove->getPrice());
                $itemInTargetWarehouse->setDescription($itemToMove->getDescription());
                $itemInTargetWarehouse->setWarehouse($targetWarehouse);
    
                // Persist the changes
                $this->entityManager->persist($itemToMove);
                $this->entityManager->persist($itemInTargetWarehouse);
    


                // Create a movement history record
                $movement = new StorageHistory();
                $movement->setTimestamp(new DateTime());
                $movement->setStorage($itemToMove);
                $movement->setFromWarehouse($itemToMove->getWarehouse());
                $movement->setToWarehouse($targetWarehouse);
                // $movement->setQuantityMoved($quantityToMove);
    
                $this->entityManager->persist($movement);
                $this->entityManager->flush();
            } else {
                // $this->get
            }
        }
    }

    public function checkStorageExists(int $code, Warehouse $warehouse) {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('s')->from(Storage::class, 's')->where('s.code = :code AND s.warehouse = :warehouse')
                     ->setParameters([
                            'code'      => $code,
                            'warehouse' => $warehouse,
                        ]);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    // public function moveStorage($data): void {

    //     $item_id = $data['id'];

    //     foreach ($data as $key => $value) {
    //         if ($value === null) {
    //             $data->offsetUnset($key);
    //         }
    //     }

    //     $data = array_keys((array) $data);
    //     $warehouse_to = $data[0];


    //     $storage = $this->entityManager->find(Storage::class, $item_id);
    //     $warehouse_to = $this->entityManager->find(Warehouse::class, $warehouse_to);

    //     $queryBuilder = $this->entityManager->createQueryBuilder();

    //     $queryBuilder->update(Storage::class, 's')
    //         ->set('s.warehouse', ':warehouse')
    //         ->where('s.id = :item_id')
    //         ->setParameter('warehouse', $warehouse_to)
    //         ->setParameter('item_id', $item_id);
    
    //     $queryBuilder->getQuery()->execute();
        
    //     $movement = new StorageHistory();
    //     $movement->setTimestamp(new DateTime());
    //     $movement->setStorage($storage);
    //     $movement->setFromWarehouse($storage->getWarehouse());
    //     $movement->setToWarehouse($warehouse_to);
        
    //     $this->entityManager->persist($movement);
    //     $this->entityManager->flush();
    // }

    public function deleteStorage($itemId): void {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->delete(Storage::class, 's')
            ->where('s.id = :id')
            ->setParameter('id', $itemId);

        $queryBuilder->getQuery()->execute();
    }
}