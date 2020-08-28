<?php

namespace App\Service;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CurrencyService
{
    /**
     * @var CacheInterface
     */
    protected $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function getRate()
    {
        return $this->cache->get('currency_rate', function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->getRateFromCBRF();
        });
    }

    protected function getRateFromCBRF()
    {
        $xml = simplexml_load_file('http://www.cbr.ru/scripts/XML_daily.asp');
        [$rate] = $xml->xpath('//ValCurs/Valute[contains(CharCode, "USD")]/Value');

        $rate = str_replace(',', '.', $rate);

        return (float) $rate;
    }
}
