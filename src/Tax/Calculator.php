<?php

namespace App\Tax;

use Psr\Log\LoggerInterface;

class Calculator
{
    private $logger;
    private $marge;

    public function __construct(LoggerInterface $logger, float $marge)
    {
        $this->logger = $logger;
        $this->marge = $marge;
    }

    public function calculTTC(float $prixht): float
    {
        $this->logger->info('Une demande de prix TTC a été effectuée ');
        return $prixht * 1.2;
    }
}