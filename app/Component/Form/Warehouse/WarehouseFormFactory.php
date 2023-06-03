<?php

namespace App\Component\Form\Warehouse;

use App\Model\Entity\Warehouse;
use App\Component\Form\Warehouse\WarehouseForm;

interface WarehouseFormFactory
{
	public function create(?Warehouse $warehouse = null): WarehouseForm;
}