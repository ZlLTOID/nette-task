<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\InvoiceModel;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use stdClass;

final class InvoiceRepository
{
    public const TABLE = 'invoice';

    private Explorer $database;
    private ContractRepository $contractRepository;

    public function __construct(
        Explorer           $database,
        ContractRepository $contractRepository
    )
    {
        $this->database = $database;
        $this->contractRepository = $contractRepository;
    }

    /** @return array<string, ActiveRow|array<string, ActiveRow>> */
    public function findOneById(int $invoiceId): array
    {
        $contracts = $this->database->table(ContractRepository::TABLE)
            ->where('invoiceId', $invoiceId)
            ->fetchAll();
        $invoice = $this->database
            ->table(self::TABLE)
            ->get($invoiceId);

        return [
            'invoice' => $invoice,
            'contracts' => $contracts,
        ];
    }

    public function createNewInvoice(InvoiceModel $invoiceModel): ActiveRow
    {
        $contractIds = [];
        foreach ($invoiceModel->contracts as $contract) {
            $contractIds[] = $contract;
        }

        $invoiceActiveRow = $this->database->table(self::TABLE)->insert([
            'email' => $invoiceModel->email,
            'firstName' => $invoiceModel->firstName,
            'lastName' => $invoiceModel->lastName,
            'phone' => $invoiceModel->phone,
        ]);

        $this->contractRepository->updateMultipleColumns(
            $contractIds,
            'forInvoicing',
            false);

        $this->contractRepository->updateMultipleColumns(
            $contractIds,
            'invoiceId',
            $invoiceActiveRow->id);

        return $invoiceActiveRow;
    }
}