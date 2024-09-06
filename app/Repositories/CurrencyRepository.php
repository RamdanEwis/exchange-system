<?php

namespace App\Repositories;

use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    protected $configPath;

    public function __construct()
    {
        $this->configPath = config_path('exchange_rates.php');
    }

    public function getAll()
    {
        return Cache::remember('currencies', 60, function () {
            return config('exchange_rates');
        });
    }

    public function saveCurrency($currency, $rate)
    {
        $currencies = $this->getAll();
        $currencies[$currency] = $rate;

        $this->updateConfigFile($currencies);
    }

    public function deleteCurrency($currency)
    {
        $currencies = $this->getAll();
        if (isset($currencies[$currency])) {
            unset($currencies[$currency]);
            $this->updateConfigFile($currencies);
        }
    }

    public function getCurrency($currency)
    {
        $currencies = $this->getAll();
        return $currencies[$currency] ?? null;
    }

    protected function updateConfigFile(array $currencies)
    {
        $content = "<?php\n\nreturn " . var_export($currencies, true) . ";\n";
        File::put($this->configPath, $content);


        Cache::forget('currencies');


        app()->make('config')->set('exchange_rates', $currencies);
    }
}
