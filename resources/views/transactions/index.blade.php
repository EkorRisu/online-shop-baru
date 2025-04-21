@extends('layouts.app')
@section('content')
    <!-- Daftar transaksi -->
    <h1 class="text-2xl font-bold mb-4">Transactions</h1>
    <table class="w-full border-collapse bg-white shadow-md rounded">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Product</th>
                <th class="border p-2">Quantity</th>
                <th class="border p-2">Total Price</th>
                <th class="border p-2">Status</th>
                @if(auth()->user()->isAdmin())
                    <th class="border p-2">User</th>
                    <th class="border p-2">Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td class="border p-2">{{ $transaction->product->name }}</td>
                    <td class="border p-2">{{ $transaction->quantity }}</td>
                    <td class="border p-2">Rp {{ number_format($transaction->total_price, 2) }}</td>
                    <td class="border p-2">{{ ucfirst($transaction->status) }}</td>
                    @if(auth()->user()->isAdmin())
                        <td class="border p-2">{{ $transaction->user->name }}</td>
                        <td class="border p-2">
                            <!-- Form untuk mengubah status transaksi -->
                            <form method="POST" action="{{ route('admin.transactions.update', $transaction) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <select name="status" class="border rounded p-1">
                                    <option value="accepted" {{ $transaction->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $transaction->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700">Update</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
