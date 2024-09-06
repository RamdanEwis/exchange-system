@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Currencies</h1>
        <a href="{{ route('currencies.create') }}" class="btn btn-primary mb-3">Add Currency</a>
        <table id="datatable" class="table table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>Currency</th>
                <th>Rate</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($currencies as $currency => $rate)
                <tr>
                    <td>{{ $currency }}</td>
                    <td>{{ $rate }}</td>
                    <td>
                        <a href="{{ route('currencies.edit', $currency) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('currencies.destroy', $currency) }}" method="POST" style="display:inline;">
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

