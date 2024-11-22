@extends('layouts.superadmin')

@section('title', 'Lost Item Logs')
@section('header', 'Lost Item Logs')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Lost Item Logs</h2>
        <button id="downloadPdf" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
            Download PDF
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <table id="lostItemLogsTable" class="w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="px-4 py-3 text-left">Item Type</th>
                    <th class="px-4 py-3 text-left">Description</th>
                    <th class="px-4 py-3 text-left">Date Lost</th>
                    <th class="px-4 py-3 text-left">Location</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Reported By</th>
                    <th class="px-4 py-3 text-left">Reported At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lostItemLogs as $item)
                <tr class="border-b border-gray-200">
                    <td class="px-4 py-3">{{ $item->item_type }}</td>
                    <td class="px-4 py-3">{{ $item->description }}</td>
                    <td class="px-4 py-3">{{ $item->date_lost->format('F j, Y') }}</td>
                    <td class="px-4 py-3">{{ $item->location }}</td>
                    <td class="px-4 py-3">
                        <span class="{{ $item->status == 'found' ? 'text-green-600' : 'text-red-600' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $item->user->name }}</td>
                    <td class="px-4 py-3">{{ $item->created_at->format('F j, Y H:i:s') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
<script>
document.getElementById('downloadPdf').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('landscape');
    
    // Add title
    doc.setFontSize(18);
    doc.text('Lost Item Logs', 14, 20);
    
    // Create table data
    const tableData = Array.from(document.querySelectorAll('#lostItemLogsTable tbody tr'))
        .map(row => {
            const cells = row.querySelectorAll('td');
            return [
                cells[0].textContent.trim(),
                cells[1].textContent.trim(),
                cells[2].textContent.trim(),
                cells[3].textContent.trim(),
                cells[4].textContent.trim(),
                cells[5].textContent.trim(),
                cells[6].textContent.trim()
            ];
        });

    // Generate table
    doc.autoTable({
        startY: 30,
        head: [['Item Type', 'Description', 'Date Lost', 'Location', 'Status', 'Reported By', 'Reported At']],
        body: tableData,
        theme: 'striped',
        styles: { fontSize: 10 },
        headStyles: { fillColor: [41, 128, 185], textColor: 255 }
    });

    // Save the PDF
    doc.save('lost_item_logs.pdf');
});
</script>
@endpush