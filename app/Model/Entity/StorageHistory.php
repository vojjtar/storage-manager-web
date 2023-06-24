<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'storage_history')]
#[ORM\Entity]
class StorageHistory
{
    #[ORM\Column(type: 'integer'), ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $timestamp;

    #[ORM\ManyToOne(targetEntity: 'Storage')]
    #[ORM\JoinColumn(name: 'storage_id', referencedColumnName: 'id')]
    private $storage;

    #[ORM\ManyToOne(targetEntity: 'Warehouse')]
    #[ORM\JoinColumn(name: 'from_warehouse_id', referencedColumnName: 'id')]
    private $fromWarehouse;

    #[ORM\ManyToOne(targetEntity: 'Warehouse')]
    #[ORM\JoinColumn(name: 'to_warehouse_id', referencedColumnName: 'id')]
    private $toWarehouse;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function getStorage()
    {
        return $this->storage;
    }
    public function setStorage($storage)
    {
        $this->storage = $storage;
    }

    public function getFromWarehouse()
    {
        return $this->fromWarehouse;
    }
    public function setFromWarehouse($fromWarehouse)
    {
        $this->fromWarehouse = $fromWarehouse;
    }

    public function getToWarehouse()
    {
        return $this->toWarehouse;
    }
    public function setToWarehouse($toWarehouse)
    {
        $this->toWarehouse = $toWarehouse;
    }
}