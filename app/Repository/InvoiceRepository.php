<?php

declare(strict_types=1);

namespace App\Repository;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use stdClass;

final class InvoiceRepository
{
    public const TABLE = 'invoice';

    private Explorer $database;

    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }

    public function findOneById(int $invoiceId)
    {
        return $this->database
            ->table(self::TABLE)
            ->get($invoiceId);
    }

    public function createNewInvoice(stdClass $data): ActiveRow
    {
        return $this->database->table(self::TABLE)->insert([
            'email' => $data->email,
            'firstName' => $data->firstName,
            'lastName' => $data->lastName,
            'phone' => $data->phone,
        ]);
    }
}