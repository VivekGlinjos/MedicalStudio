<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Welcome back, {{ auth()->user()->name }}!</h3>
                    <p>{{ __("You're logged in!") }}</p>
                </div>
            </div>

            @php
                $latestPayment = \App\Models\Payment::where('user_id', auth()->id())->where('status', 'success')->latest()->first();
            @endphp

            @if(auth()->user()->is_paid && $latestPayment)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                <div class="p-6 text-gray-900 flex justify-between items-center flex-wrap gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-blue-600 mb-1">Premium Subscription Active</h3>
                        <p class="text-sm text-gray-600">You have full access to premium features.</p>
                        <p class="text-sm text-gray-500 mt-2">Transaction ID: {{ $latestPayment->transaction_id ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <a href="{{ route('payment.invoice', $latestPayment->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Download Invoice
                        </a>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
