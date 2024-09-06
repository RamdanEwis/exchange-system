<?php

namespace App\Http\Controllers;

use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class CurrencyController extends Controller
{
    protected $configPath;

    public function __construct()
    {
        // Set the config path to the exchange_rates.php file
        $this->configPath = config_path('exchange_rates.php');
    }

    public function index()
    {
        $currencies = $this->getAllCurrencies();
        return view('currencies.index', compact('currencies'));
    }

    protected function getAllCurrencies()
    {
        // Use cache to store the currencies for 60 minutes
        return Cache::remember('currencies', 60, function () {
            return config('exchange_rates');
        });
    }


    public function create()
    {
        return view('currencies.create');
    }

    public function store(Request $request)
    {
        // Validate the request inputs
        $attributes = $request->validate([
            'currency' => 'required|string',
            'rate' => 'required|numeric',
        ]);

        // Add the new currency
        $this->saveCurrency($attributes['currency'], $attributes['rate']);

        // Redirect back to the index with a success message
        return redirect()->route('currencies.index')->with('success', 'Currency added successfully.');
    }


    public function edit($currency)
    {
        $rate = $this->getCurrency($currency);
        return view('currencies.edit', compact('currency', 'rate'));
    }


    public function update(Request $request, $currency)
    {
        // Validate the request inputs
        $attributes =$request->validate([
            'rate' => 'required|numeric',
        ]);

        // Save the updated currency
        $this->saveCurrency($currency, $attributes['rate']);

        // Redirect back to the index with a success message
        return redirect()->route('currencies.index')->with('success', 'Currency updated successfully.');
    }

    public function destroy($currency)
    {
        $this->deleteCurrency($currency);

        // Redirect back to the index with a success message
        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully.');
    }
    protected function saveCurrency($currency, $rate)
    {
        $currencies = $this->getAllCurrencies();
        $currencies[$currency] = $rate;

        $this->updateConfigAndCache($currencies);
    }

    protected function deleteCurrency($currency)
    {
        $currencies = $this->getAllCurrencies();
        if (isset($currencies[$currency])) {
            unset($currencies[$currency]);
          //  $this->updateConfigFile($currencies);
            $this->updateConfigAndCache($currencies);

        }
    }
    protected function getCurrency($currency)
    {
        $currencies = $this->getAllCurrencies();
        return $currencies[$currency] ?? null;
    }

    protected function updateConfigAndCache(array $currencies)
    {
        $content = "<?php\n\nreturn " . var_export($currencies, true) . ";\n";
        File::put($this->configPath, $content);
        Cache::forever('currencies', $currencies);
    }
}
