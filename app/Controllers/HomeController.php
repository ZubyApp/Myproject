<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\App;
use App\Container;
use App\Services\InvoiceService;
use App\View;

class HomeController
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    public function index(): View
    {
        $this->invoiceService->process([], 25);

        return View::make('index');
    }

    public function saveFile()
    {
        $filePath = \STORAGE_PATH . '/' . $_FILES['transactions']['name'];
        $filePath1 = \STORAGE_PATH . '/' . $_FILES['transactions1']['name'];

        \move_uploaded_file($_FILES['transactions']['tmp_name'], $filePath);
        \move_uploaded_file($_FILES['transactions1']['tmp_name'], $filePath1);

        \header("Location: /");
        exit;
    }
}