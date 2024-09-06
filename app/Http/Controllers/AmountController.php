<?php

namespace App\Http\Controllers;

use App\Models\Amount;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AmountController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $amounts = Cache::remember('amounts', 60 * 60, function () {
            return  Amount::all();
        });
        return view('amounts.index', compact('amounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currencies = $this->currencyService->getAll();
        return view('amounts.create', compact('currencies'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $attributes =    $request->validate([
                'currency' => 'required|string',
                'amount' => 'required|numeric',
            ]);

        Amount::create($attributes);
        $this->ClearCache();
        return redirect()->route('amounts.index')->with('success', 'Amount added successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Amount $amount)
    {
        $currencies = $this->currencyService->getAll();
        return view('amounts.edit', compact('amount', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Amount $amount)
    {
        $attributes = $request->validate([
            'currency' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $amount->update($attributes);
        $this->ClearCache();
        return redirect()->route('amounts.index')->with('success', 'Amount updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Amount $amount)
    {
        $amount->delete();
        $this->ClearCache();
        return redirect()->route('amounts.index')->with('success', 'Amount deleted successfully.');
    }

    public function ClearCache()
    {
        Cache::forget('amounts');
        $amounts = Amount::all();
        Cache::forever('amounts', $amounts);
    }
}
