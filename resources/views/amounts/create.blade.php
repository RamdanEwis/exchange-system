@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Add Amount</h1>

        <form method="POST" action="{{ route('amounts.store') }}">
            @csrf

            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" placeholder="Enter amount" required>
                @error('amount')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="currency">Currency:</label>
                <select name="currency" class="form-control @error('currency') is-invalid @enderror" required>
                    @foreach($currencies as $currency => $rate)
                        <option value="{{ $currency }}">{{ $currency }}</option>
                    @endforeach
                </select>
                @error('currency')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Add Amount</button>
            <a href="{{ route('amounts.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
