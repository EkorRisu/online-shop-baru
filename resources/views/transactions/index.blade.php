@extends('layouts.app')
@section('content')

    <!-- Tombol Download PDF -->
    <button onclick="downloadPDF()" class="bg-green-600 text-white px-3 py-2 rounded mb-4 hover:bg-green-700">
        Download PDF
    </button>

    <!-- Daftar transaksi -->
    <h1 class="text-2xl font-bold mb-4">Transactions</h1>
    <table id="transactionTable" class="w-full border-collapse bg-white shadow-md rounded">
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
                            <form method="POST" action="{{ route('admin.transactions.update', $transaction) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <select name="status" class="border rounded p-1">
                                    <option value="accepted" {{ $transaction->status === 'accepted' ? 'selected' : '' }}>Accepted
                                    </option>
                                    <option value="rejected" {{ $transaction->status === 'rejected' ? 'selected' : '' }}>Rejected
                                    </option>
                                </select>
                                <button type="submit"
                                    class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700">Update</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- jsPDF dan autoTable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>

    <script>
      function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const table = document.getElementById("transactionTable");
            const headers = [];
            const rows = [];

            // Ambil header, kecuali "Action"
            table.querySelectorAll("thead th").forEach((th, i) => {
                if (th.innerText.trim().toLowerCase() !== 'action') {
                    headers.push(th.innerText.trim());
                }
            });

            // Ambil isi tabel, kecuali kolom "Action"
            table.querySelectorAll("tbody tr").forEach(tr => {
                const row = [];
                tr.querySelectorAll("td").forEach((td, i) => {
                    // Hanya ambil kolom sebelum "Action"
                    if (i < headers.length) {
                        row.push(td.innerText.trim());
                    }
                });
                rows.push(row);
            });

            doc.setFontSize(14);
            doc.text("Transactions Report", 14, 15);

            doc.autoTable({
                startY: 20,
                head: [headers],
                body: rows,
                theme: 'grid',
                styles: { fontSize: 10 }
            });

            doc.save("transactions.pdf");
        }

    </script>
@endsection
