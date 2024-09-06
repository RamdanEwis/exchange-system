@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Add Currency</h1>

        <form method="POST" action="{{ route('currencies.store') }}">
            @csrf

            <div class="form-group">
                <label for="currency">Currency Code:</label>
                <input type="text" class="form-control @error('currency') is-invalid @enderror" name="currency" value="{{ old('currency') }}" placeholder="Enter currency code (e.g. USD)" required>
                @error('currency')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="rate">Exchange Rate:</label>
                <input type="number" step="0.01" class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{ old('rate') }}" placeholder="Enter exchange rate" required>
                @error('rate')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Add Currency</button>
            <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
