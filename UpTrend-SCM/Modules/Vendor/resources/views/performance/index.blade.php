@extends('vendor::layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Supplier Performance Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($vendor_suppliers as $supplier)
        <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col">
            <div class="flex items-center mb-4">
                <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-2xl font-bold text-blue-600">
                    {{ substr($supplier->name, 0, 2) }}
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $supplier->name }}</h2>
                    <p class="text-gray-500 text-sm">{{ $supplier->category }}</p>
                </div>
            </div>
            <!-- Scorecards -->
            <div class="grid grid-cols-1 gap-2 mb-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">On-Time Delivery</span>
                    <span class="font-bold text-green-600">{{ $supplier->performance->on_time_delivery ?? 'N/A' }}%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Quality Issues</span>
                    <span class="font-bold text-red-600">{{ $supplier->performance->quality_issues ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Avg. Rating</span>
                    <span class="font-bold text-yellow-500">{{ $supplier->performance->average_rating ?? 'N/A' }}/5</span>
                </div>
            </div>
            <!-- Certifications -->
            <div class="mb-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Certifications</h3>
                <div class="flex flex-wrap gap-2">
                    @forelse($supplier->certifications as $cert)
                        <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">
                            {{ $cert->certification }}
                            @if($cert->expires_at)
                                <span class="ml-2 text-gray-500">(exp. {{ \Carbon\Carbon::parse($cert->expires_at)->format('Y-m-d') }})</span>
                            @endif
                        </span>
                    @empty
                        <span class="text-gray-400 text-xs">No certifications</span>
                    @endforelse
                </div>
            </div>
            <!-- Audit History -->
            <div class="mb-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Audit History</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs">
                        <thead>
                            <tr class="text-left text-gray-500">
                                <th class="pr-2">Date</th>
                                <th class="pr-2">Auditor</th>
                                <th class="pr-2">Rating</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supplier->audits as $audit)
                            <tr>
                                <td class="pr-2 py-1">{{ \Carbon\Carbon::parse($audit->audit_date)->format('Y-m-d') }}</td>
                                <td class="pr-2 py-1">{{ $audit->auditor }}</td>
                                <td class="pr-2 py-1">
                                    <span class="font-bold text-yellow-500">{{ $audit->rating ?? '-' }}/5</span>
                                </td>
                                <td class="py-1">{{ $audit->notes }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-gray-400 py-1">No audit history</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection 