@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Amounts</h1>
        <a href="{{ route('amounts.create') }}" class="btn btn-primary mb-3">Add Amount</a>
        <table id="datatable" class="table table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>Amount</th>
                <th>Currency</th>
                <th>Converted Value</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($amounts as $amount)
                <tr>
                    <td>{{ $amount->amount }}</td>
                    <td>{{ $amount->currency }}</td>
                    <td>{{ $amount->amount * config('exchange_rates.' . $amount->currency) }}</td>
                    <td>
                        <a href="{{ route('amounts.edit', $amount->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('amounts.destroy', $amount->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

