@extends('layouts.dashboard')

@section('content')
    <div class="container grid px-6 mx-auto">
        <div class="flex items-center justify-between mb-4 space-y-4 md:flex-row md:items-end md:space-x-4">
            <h2
                class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
                Delivery
            </h2>
        </div>
        @if ($message = Session::get('success'))
            <a
                class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
                href="#"
            >
                <p>{{ $message }}</p>
            </a>
        @endif
        @if ($message = Session::get('error'))
            <a
                class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-red-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
                href="#"
            >
                <p>{{ $message }}</p>
            </a>
    @endif
    <!-- With actions -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap" id="orderList">
                    <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                        <th class="px-4 py-3">Order Number</th>
                        <th class="px-4 py-3">Customer Name</th>
                        <th class="px-4 py-3">Total Qty</th>
                        <th class="px-4 py-3">Total Amount</th>
                        <th class="px-4 py-3">Total VAT</th>
                        <th class="px-4 py-3">Net Amount</th> 
                        <th class="px-4 py-3">Date</th> 
                    </tr>
                    </thead>
                    <tbody
                        class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                    >

                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function productList() {
            $('#orderList').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('delivery.datatable-list')}}',
                columns: [ 
                    {data: 'oder_number', name: 'oder_number', searchable: false},
                    {data: 'user_name', name: 'user_name', searchable: true},
                    {data: 'total_qty', name: 'total_qty', searchable: true},
                    {data: 'total_amount', name: 'total_amount', searchable: true},
                    {data: 'total_vat', name: 'total_vat', searchable: true}, 
                    {data: 'net_amount', name: 'net_amount', searchable: true},
                    {data: 'date', name: 'date', searchable: true}, 
                ]
            });
        };

        $(document).ready(function () {
            productList();
        });
    </script>
@endsection
