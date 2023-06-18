<?php

namespace App\Component\Form\Storage;

use App\Model\Entity\Storage;
use App\Component\Form\Storage\StorageForm;

interface StorageFormFactory
{
	public function create(?Storage $storage = null): StorageForm;
}