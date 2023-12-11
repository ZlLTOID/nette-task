<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Factory\InvoiceFormFactory;
use App\Repository\ContractRepository;
use App\Repository\InvoiceRepository;
use App\Service\InvoiceFormHandler;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

final class ContractPresenter extends Presenter
{
    private ContractRepository $contractRepository;
    private InvoiceRepository $invoiceRepository;
    private InvoiceFormFactory $invoiceFormFactory;
    private InvoiceFormHandler $invoiceFormHandler;

    public function __construct(
        ContractRepository    $contractRepository,
        InvoiceRepository $invoiceRepository,
        InvoiceFormFactory $invoiceFormFactory,
        InvoiceFormHandler $invoiceFormHandler,
    )
    {
        $this->contractRepository = $contractRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->invoiceFormFactory = $invoiceFormFactory;
        $this->invoiceFormHandler = $invoiceFormHandler;
        parent::__construct();
    }

    protected function createComponentInvoiceForm(): Form
    {
        $form = $this->invoiceFormFactory->create();

        $contracts = $this->contractRepository->findAllForList();
        foreach ($contracts as  $key => $contract) {
            if ($contract->forInvoicing) {
                $form->addHidden('Contract_' . $key+1, $contract->id);
            }
        }

        $form->onSuccess[] = $this->formSucceeded(...);

        return $form;
    }

    public function formSucceeded(Form $form): void
    {
        $invoiceModel = $this->invoiceFormHandler->handle($form);

        // Tady bych ideálně vystřelil event, ale nenašel jsem jak to udělat be použití knihovny třetí strany
        $invoice = $this->invoiceRepository->createNewInvoice($invoiceModel);

        $this->redirect('Invoice:detail', [$invoice->id]);
    }

    public function handleMarkForInvoice(int $contractId): void
    {
        $this->contractRepository->updateSingleColumn(
            $contractId,
            'forInvoicing',
            true
        );
    }

    public function renderList(): void
    {
        $contracts = $this->contractRepository->findAllForList();

        $this->template->contracts = $contracts;
    }

    public function renderDetail(int $contractId): void
    {
        $contract = $this->contractRepository->findOneById($contractId);

        $this->template->contract = $contract;
    }
}