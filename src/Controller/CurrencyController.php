<?php

namespace App\Controller;

use App\Service\CurrencyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyController extends AbstractController
{
    /**
     * @var CurrencyService
     */
    protected $currencyService;

    /**
     * CurrencyController constructor.
     *
     * @param CurrencyService $currencyService
     */
    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * @Route("api/currencies/rate", name="currencies-rate")
     */
    public function rate()
    {
        $rate = $this->currencyService->getRate();

        return $this->json([
            'currency' => 'RUB',
            'rate' => $rate,
        ]);
    }
}
