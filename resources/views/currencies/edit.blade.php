@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Currency</h1>

        <form method="POST" action="{{ route('currencies.update', $currency) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="currency">Currency Code:</label>
                <input type="text" class="form-control @error('currency') is-invalid @enderror" name="currency" value="{{ $currency }}" readonly>
                @error('currency')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="rate">Exchange Rate:</label>
                <input type="number" step="0.01" class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{ $rate }}" required>
                @error('rate')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Currency</button>
            <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
