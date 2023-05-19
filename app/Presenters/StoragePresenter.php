<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Presenter;


final class StoragePresenter extends Presenter
{
    public function renderDefault()
    {
        $myVariable = 'Hello, Latte!';
        $this->template->myVariable = $myVariable;
    }
}