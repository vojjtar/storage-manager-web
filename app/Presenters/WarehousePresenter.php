<?php

declare(strict_types=1);

namespace App\Presenters;


use Nette;
use Nette\Application\UI\Presenter;
use Doctrine\ORM\EntityManagerInterface;
use App\Model\Entity\Warehouse;


class WarehousePresenter extends Presenter
{
    private $wareHouse;
    private $warehouses;

    public function __construct(Warehouse $wareHouse) {
        parent::startup();
        $this->wareHouse = $wareHouse;
    }

    public function renderDefault()
    {
        $data = $this->wareHouse->getName();
        $this->template->wareHouse = $data;
    }
}