@extends('layouts.app')

@section('title', 'Donation Status | ABVHPS')
@section('meta_description', 'Official transaction and donation status statement for contributions made to Akhanda Bharatha Viswa Hindu Parirakshana Samiti.')

@section('content')
<div class="bg-gray-50 min-h-screen py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
    <div class="max-w-xl w-full bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        
        <!-- Header Banner with Status Icon -->
        @php
            $status = strtolower($donation->payment_status ?? 'pending');
            $isPaid = $status === 'paid';
            $isPending = in_array($status, ['pending', 'processing']);
            $isFailed = in_array($status, ['failed', 'cancelled', 'expired']);
            $gatewayLabel = match(strtolower($donation->payment_gateway ?? 'manual')) {
                'cashfree' => 'Cashfree Payments',
                'razorpay' => 'Razorpay Payments',
                default => 'Manual'
            };
        @endphp

        <div class="p-8 text-center @if($isPaid) bg-gradient-to-b from-emerald-50 to-white @elseif($isPending) bg-gradient-to-b from-amber-50 to-white @else bg-gradient-to-b from-red-50 to-white @endif border-b border-gray-100">
            <div class="w-20 h-20 rounded-full mx-auto flex items-center justify-center shadow-lg mb-4 @if($isPaid) bg-emerald-500 text-white @elseif($isPending) bg-amber-500 text-white @else bg-red-500 text-white @endif animate-bounce-short">
                @if($isPaid)
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                @elseif($isPending)
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @else
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                @endif
            </div>

            <span class="inline-block text-[11px] font-black uppercase tracking-widest px-3.5 py-1 rounded-full mb-2 @if($isPaid) bg-emerald-100 text-emerald-800 border border-emerald-200 @elseif($isPending) bg-amber-100 text-amber-800 border border-amber-200 @else bg-red-100 text-red-800 border border-red-200 @endif">
                {{ $isPaid ? 'Payment Successful' : ($isPending ? 'Payment Processing' : 'Payment Failed') }}
            </span>

            <h1 class="text-2xl font-black text-gray-900 uppercase tracking-tight">
                @if($isPaid)
                    Dhanyavadagalu / Thank You!
                @elseif($isPending)
                    Verifying Your Contribution
                @else
                    Transaction Incomplete
                @endif
            </h1>

            <p class="text-xs sm:text-sm text-gray-600 mt-2 font-medium max-w-md mx-auto leading-relaxed">
                @if($isPaid)
                    Your sacred contribution towards Sanatana Dharma and ABVHPS community causes has been received with deep gratitude.
                @elseif($isPending)
                    We are verifying the payment confirmation from the gateway. Please refresh this page after a few moments.
                @else
                    The transaction could not be completed or was cancelled. You may safely retry your contribution below.
                @endif
            </p>
        </div>

        <!-- Transaction Details Card -->
        <div class="p-6 sm:p-8 space-y-4">
            <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200/80 space-y-3">
                <div class="flex justify-between items-center pb-3 border-b border-gray-200/60 text-xs">
                    <span class="text-gray-500 font-bold uppercase tracking-wider text-[10px]">Devotee Name</span>
                    <span class="font-extrabold text-gray-900 uppercase">{{ $donation->name }}</span>
                </div>

                <div class="flex justify-between items-center pb-3 border-b border-gray-200/60 text-xs">
                    <span class="text-gray-500 font-bold uppercase tracking-wider text-[10px]">Contribution Amount</span>
                    <span class="font-black text-emerald-700 text-base font-mono">₹{{ number_format((float)$donation->amount, 2) }}</span>
                </div>

                @if($donation->receipt_number)
                <div class="flex justify-between items-center pb-3 border-b border-gray-200/60 text-xs">
                    <span class="text-gray-500 font-bold uppercase tracking-wider text-[10px]">Receipt Number</span>
                    <span class="font-mono font-bold text-brandOrange">{{ $donation->receipt_number }}</span>
                </div>
                @endif

                @if($donation->campaign)
                <div class="flex justify-between items-center pb-3 border-b border-gray-200/60 text-xs">
                    <span class="text-gray-500 font-bold uppercase tracking-wider text-[10px]">Dedicated Cause</span>
                    <span class="font-bold text-gray-800 text-right max-w-[200px] truncate uppercase">{{ $donation->campaign->title }}</span>
                </div>
                @endif

                <div class="flex justify-between items-center pb-3 border-b border-gray-200/60 text-xs">
                    <span class="text-gray-500 font-bold uppercase tracking-wider text-[10px]">Payment Channel</span>
                    <span class="font-bold text-gray-800">{{ $gatewayLabel }}</span>
                </div>

                @if($donation->gateway_payment_id || $donation->gateway_order_id)
                <div class="flex justify-between items-center pb-3 border-b border-gray-200/60 text-xs">
                    <span class="text-gray-500 font-bold uppercase tracking-wider text-[10px]">Transaction Reference</span>
                    <span class="font-mono text-[11px] text-gray-600 truncate max-w-[220px]">{{ $donation->gateway_payment_id ?? $donation->gateway_order_id }}</span>
                </div>
                @endif

                <div class="flex justify-between items-center text-xs pt-1">
                    <span class="text-gray-500 font-bold uppercase tracking-wider text-[10px]">Timestamp (IST)</span>
                    <span class="font-mono text-gray-700 font-semibold">
                        {{ $donation->paid_at ? \Carbon\Carbon::parse($donation->paid_at)->timezone('Asia/Kolkata')->format('d-M-Y H:i:s') : \Carbon\Carbon::parse($donation->created_at)->timezone('Asia/Kolkata')->format('d-M-Y H:i:s') }} IST
                    </span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3 pt-2">
                @if($isPaid)
                    <a href="{{ route('donations.receipt', $donation->id) }}" target="_blank" class="w-full bg-brandOrange hover:bg-orange-600 text-white font-black py-3 px-6 rounded-2xl flex items-center justify-center gap-2 shadow-lg shadow-orange-500/20 text-xs uppercase tracking-wider transition transform hover:scale-[1.01] min-h-[48px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>Download Official 80G Receipt</span>
                    </a>
                @elseif($isPending)
                    <button onclick="window.location.reload()" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-black py-3 px-6 rounded-2xl flex items-center justify-center gap-2 shadow-lg text-xs uppercase tracking-wider transition min-h-[48px]">
                        <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        <span>Check Status Again</span>
                    </button>
                @else
                    <a href="{{ route('donations.grid') }}#donate_form_section" class="w-full bg-brandOrange hover:bg-orange-600 text-white font-black py-3 px-6 rounded-2xl flex items-center justify-center gap-2 shadow-lg shadow-orange-500/20 text-xs uppercase tracking-wider transition min-h-[48px]">
                        <span>Try Contributing Again</span>
                    </a>
                @endif

                <a href="{{ route('donations.grid') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-brandGray font-bold py-3 px-6 rounded-2xl flex items-center justify-center text-xs uppercase tracking-wider transition min-h-[44px]">
                    Back to All Causes
                </a>
            </div>

            <!-- Tax 80G & Legal Notice -->
            <div class="text-center pt-4 border-t border-gray-100">
                <p class="text-[10px] text-gray-500 font-semibold leading-relaxed">
                    🕉️ Akhanda Bharatha Viswa Hindu Parirakshana Samiti is a registered charitable organisation. Contributions are eligible for tax benefits under Section 80G where applicable.
                </p>
            </div>

        </div>

    </div>
</div>
@endsection
