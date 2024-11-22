@extends('layouts.superadmin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">PC Room Session Logs</h2>
        <button id="downloadPdf" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
            Download PDF
        </button>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <h3 class="text-xl font-semibold mb-4">Completed Sessions</h3>
            <div class="overflow-x-auto">
                <table id="sessionLogsTable" class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($completedSessions as $session)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $session->user ? $session->user->name : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $session->user ? $session->user->email : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $session->start_time ? $session->start_time->format('Y-m-d H:i:s') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $session->end_time ? $session->end_time->format('Y-m-d H:i:s') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($session->start_time && $session->end_time)
                                    {{ $session->start_time->diffForHumans($session->end_time, true) }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $session->purpose ?? 'N/A' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No completed sessions found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
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
    doc.text('PC Room Session Logs', 14, 20);
    
    // Create table data
    const tableData = Array.from(document.querySelectorAll('#sessionLogsTable tbody tr'))
        .filter(row => row.querySelector('td:first-child').textContent !== 'No completed sessions found')
        .map(row => {
            const cells = row.querySelectorAll('td');
            return [
                cells[0].textContent.trim(),
                cells[1].textContent.trim(),
                cells[2].textContent.trim(),
                cells[3].textContent.trim(),
                cells[4].textContent.trim(),
                cells[5].textContent.trim()
            ];
        });

    // Generate table
    doc.autoTable({
        startY: 30,
        head: [['User', 'Email', 'Start Time', 'End Time', 'Duration', 'Purpose']],
        body: tableData,
        theme: 'striped',
        styles: { fontSize: 10 },
        headStyles: { fillColor: [41, 128, 185], textColor: 255 }
    });

    // Save the PDF
    doc.save('session_logs.pdf');
});
</script>
@endpush