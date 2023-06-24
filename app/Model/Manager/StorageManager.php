<?php

namespace App\Model\Manager;

use Doctrine\ORM\EntityManagerInterface;
use App\Model\Entity\Storage;


class StorageManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getStorageEntity($storage_id): Storage {
        return $this->entityManager->find(Storage::class, $storage_id);
    }

}