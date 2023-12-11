<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\InvoiceModel;
use Nette\Forms\Form;

final class InvoiceFormHandler
{
    public function handle(Form $form): InvoiceModel
    {
        $invoiceModel = new InvoiceModel();
        $data = $form->getValues();

        $invoiceModel->email = $data->email;
        $invoiceModel->firstName = $data->firstName;
        $invoiceModel->lastName = $data->lastName;
        $invoiceModel->phone = $data->phone;

        foreach ($data as $key => $value) {
            if (strpos($key, 'Contract_') !== false) {
                $invoiceModel->contracts[] = $value;
            }
        }

        return $invoiceModel;
    }
}