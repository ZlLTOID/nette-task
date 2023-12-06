<?php

namespace App\Service;

class ExchangeRatesProvider
{
    public function getEURRate()
    {
        $url = 'https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt';
        $response = file_get_contents($url);
        $emuLine = explode("\n", $response)[7];
        $eurRate = explode('|', $emuLine)[4];
        $eurRate = str_replace(',', '.', $eurRate);

        return round(
            (float)$eurRate,
            2
        );

    }

    public function getUSDRate()
    {
        $url = 'https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt';
        $response = file_get_contents($url);
        $emuLine = explode("\n", $response)[31];
        $eurRate = explode('|', $emuLine)[4];
        $eurRate = str_replace(',', '.', $eurRate);

        return round(
            (float)$eurRate,
            2
        );

    }
}