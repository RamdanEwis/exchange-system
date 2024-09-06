<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class CurrencyService
{
    protected $configPath;

    public function __construct()
    {
        $this->configPath = config_path('exchange_rates.php');
    }

    public function getAll()
    {
        app()->make('config')->set('exchange_rates', require $this->configPath);

        return config('exchange_rates');
    }

    public function addCurrency($currency, $rate)
    {
        $currencies = $this->getAll();
        $currencies[$currency] = $rate;
        $this->saveConfig($currencies);
    }

    public function updateCurrency($currency, $rate)
    {
        $currencies = $this->getAll();
        if (isset($currencies[$currency])) {
            $currencies[$currency] = $rate;
            $this->saveConfig($currencies);
        }
    }

    public function deleteCurrency($currency)
    {
        $currencies = $this->getAll();
        if (isset($currencies[$currency])) {
            unset($currencies[$currency]);
            $this->saveConfig($currencies);
        }
    }

    protected function saveConfig($currencies)
    {
        $content = "<?php\n\nreturn " . var_export($currencies, true) . ";\n";
        File::put($this->configPath, $content);
    }

    public function getCurrency($currency)
    {
        $currencies = $this->getAll();
        return $currencies[$currency] ?? null;
    }
}
