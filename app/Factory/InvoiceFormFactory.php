<?php

declare(strict_types=1);

namespace App\Factory;


use Nette\Application\UI\Form;

final class InvoiceFormFactory
{
    public function create(): Form
    {
        $form = new Form;

        $form->addEmail('email', 'Email:')
            ->setRequired();

        $form->addText('firstName', 'Křestní jméno:')
            ->setRequired();

        $form->addText('lastName', 'Příjmení:')
            ->setRequired();

        $form->addText('phone', 'Telefon:')
            ->setRequired();

        $form->addSubmit('send', 'Vytvořit fakturu');

        return $form;
    }
}