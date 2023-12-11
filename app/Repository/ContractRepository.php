<?php

declare(strict_types=1);

namespace App\Repository;

use Nette\Database\Explorer;
use Nette\Database\Row;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

final class ContractRepository
{
    public const TABLE = 'contract';
    public const ID = 'id';
    public const NAME = 'name';
    public const PRICE_CZK = 'priceCZK';
    public const PRICE_EUR = 'priceEUR';
    public const PRICE_USD = 'priceUSD';
    public const FOR_INVOICING = 'forInvoicing';
    public const INVOICE_ID = 'invoiceId';
    public const CREATED_AT = 'createdAt';

    private Explorer $database;

    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }

    /** @return array<string, Row> */
    public function findAllForList(): array
    {
        return $this->database->query(
            "SELECT
                    c.id,
                    c.name,
                    c.priceCZK,
                    c.priceEUR,
                    c.priceUSD,
                    c.forInvoicing,
                    c.createdAt,
                    GROUP_CONCAT(s.firstName, ' ' ,s.lastName) AS solvers
                FROM contract c
                         JOIN contract_solvers cs ON cs.contractId = c.id
                         JOIN solver s ON cs.solverId = s.id
                GROUP BY c.id, c.name, c.priceCZK, c.createdAt;"
        )->fetchAll();
    }

    public function findAllForCommand(): array
    {
        return $this->database
            ->table(self::TABLE)
            ->select(self::ID)
            ->select(self::PRICE_CZK)
        ->fetchAll();
    }

    public function findOneById(int $contractId): ActiveRow|null
    {
        return $this->database
            ->table(self::TABLE)
            ->get($contractId);
    }

    /** @param array<int, int> $contractIds */
    public function updateMultipleColumns(
        array $contractIds,
        string $column,
        mixed $value
    ): void
    {
        $this->database
            ->table(self::TABLE)
            ->where(
                self::ID,
                $contractIds
            )
            ->update([
                $column => $value
            ]);
    }

    public function updateSingleColumn(
        int $contractId,
        string $column,
        mixed $value
    ): void
    {
        $contract = $this->database
            ->table(self::TABLE)
            ->get($contractId);

        $contract
            ->update([
                $column => $value
            ]);
    }
}