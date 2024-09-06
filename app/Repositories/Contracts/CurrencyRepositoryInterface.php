<?php

namespace App\Repositories\Contracts;

interface CurrencyRepositoryInterface
{
    /**
     * Get all currencies.
     *
     * @return array
     */
    public function getAll();

    /**
     * Add or update a currency.
     *
     * @param string $currency
     * @param float $rate
     */
    public function saveCurrency($currency, $rate);

    /**
     * Delete a currency.
     *
     * @param string $currency
     */
    public function deleteCurrency($currency);

    /**
     * Get a single currency rate.
     *
     * @param string $currency
     * @return float|null
     */
    public function getCurrency($currency);
}
