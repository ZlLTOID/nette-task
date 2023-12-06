<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Factory\InvoiceFormFactory;
use App\Repository\ContractRepository;
use App\Repository\InvoiceRepository;
use App\Service\ExchangeRatesProvider;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use stdClass;

final class ContractPresenter extends Presenter
{
    private ContractRepository $contractRepository;
    private InvoiceRepository $invoiceRepository;
    private ExchangeRatesProvider $exchangeRatesProvider;
    private InvoiceFormFactory $invoiceFormFactory;

    public function __construct(
        ContractRepository    $contractRepository,
        InvoiceRepository $invoiceRepository,
        ExchangeRatesProvider $exchangeRatesProvider,
        InvoiceFormFactory $invoiceFormFactory,
    )
    {
        $this->contractRepository = $contractRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->exchangeRatesProvider = $exchangeRatesProvider;
        parent::__construct();
        $this->invoiceFormFactory = $invoiceFormFactory;
    }

    private function getForeignPrice(
        float $czkPrice,
        float $foreignRate
    ): float
    {
        return round(
            $czkPrice / $foreignRate,
            2
        );
    }

    protected function createComponentInvoiceForm(): Form
    {
        $form = $this->invoiceFormFactory->create();

        $contracts = $this->contractRepository->findAllForList();
        foreach ($contracts as  $key => $contract) {
            if ($contract->forInvoicing) {
                $form->addHidden('Zakazka_' . $key+1, $contract->id);
            }
        }

        $form->onSuccess[] = $this->formSucceeded(...);

        return $form;
    }

    public function formSucceeded(stdClass $data): void
    {
        dump($data);
        die();
        $invoice = $this->invoiceRepository->createNewInvoice($data);

        $this->flashMessage('Faktura byla vytvořena');
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

        $eurRate = $this->exchangeRatesProvider->getEURRate();
        $usdRate = $this->exchangeRatesProvider->getUSDRate();

        $eurPrices = [];
        $usdPrices = [];
        foreach ($contracts as $contract) {
            $eurPrices[$contract->id] = $this->getForeignPrice($contract->priceCZK, $eurRate);
            $usdPrices[$contract->id] = $this->getForeignPrice($contract->priceCZK, $usdRate);
        }

        $this->template->eurPrices = $eurPrices;
        $this->template->usdPrices = $usdPrices;
        $this->template->contracts = $contracts;
    }

    public function renderDetail(int $contractId): void
    {
        $contract = $this->contractRepository->findOneById($contractId);

        $eurRate = $this->exchangeRatesProvider->getEURRate();
        $usdRate = $this->exchangeRatesProvider->getUSDRate();

        $eurPrice = $this->getForeignPrice($contract->priceCZK, $eurRate);
        $usdPrice = $this->getForeignPrice($contract->priceCZK, $usdRate);

        $this->template->eurPrice = $eurPrice;
        $this->template->usdPrice = $usdPrice;
        $this->template->contract = $contract;
    }
}