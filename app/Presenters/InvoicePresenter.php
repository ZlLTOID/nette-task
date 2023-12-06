<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Repository\InvoiceRepository;
use Nette\Application\UI\Presenter;

final class InvoicePresenter extends Presenter
{
    private InvoiceRepository $invoiceRepository;

    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function renderDetail(int $invoiceId): void
    {
        $invoice = $this->invoiceRepository->findOneById($invoiceId);

        $this->template->invoice = $invoice;
    }
}