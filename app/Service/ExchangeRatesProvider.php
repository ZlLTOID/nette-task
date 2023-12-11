<?php

namespace App\Service;

class ExchangeRatesProvider
{
    public function getEURPrice(float $czkPrice)
    {
        $url = 'https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt';
        $response = file_get_contents($url);
        $emuLine = explode("\n", $response)[7];
        $eurRate = explode('|', $emuLine)[4];
        $eurRate = str_replace(',', '.', $eurRate);

        return $this->getForeignPrice(
            $czkPrice,
            round(
                (float)$eurRate,
                2
            )
        );
    }

    public function getUSDPrice(float $czkPrice)
    {
        $url = 'https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt';
        $response = file_get_contents($url);
        $emuLine = explode("\n", $response)[31];
        $usdRate = explode('|', $emuLine)[4];
        $usdRate = str_replace(',', '.', $usdRate);

        return $this->getForeignPrice(
            $czkPrice,
            round(
                (float)$usdRate,
                2
            )
        );
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
}