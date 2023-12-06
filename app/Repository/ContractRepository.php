<?php

declare(strict_types=1);

namespace App\Repository;

use Nette\Database\Explorer;
use Nette\Database\Row;

final class ContractRepository
{
    public const TABLE = 'contract';

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
                    c.forInvoicing,
                    c.created_at,
                    GROUP_CONCAT(s.firstName, ' ' ,s.lastName) AS solvers
                FROM contract c
                         JOIN contract_solvers cs ON cs.contract_id = c.id
                         JOIN solver s ON cs.solver_id = s.id
                GROUP BY c.id, c.name, c.priceCZK, c.created_at;"
        )->fetchAll();
    }

    public function findOneById(int $contractId)
    {
        return $this->database
            ->table(self::TABLE)
            ->get($contractId);
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