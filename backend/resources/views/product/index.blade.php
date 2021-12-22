@extends('layouts.dashboard')

@section('content')
    <div class="container grid px-6 mx-auto">
        <div class="flex items-center justify-between mb-4 space-y-4 md:flex-row md:items-end md:space-x-4">
        <h2
            class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
        >
            Products
        </h2>
        <a class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" href="{{route('product.create')}}"> Add Product</a>
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
                <table class="w-full whitespace-no-wrap" id="productList">
                    <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                        <th class="px-4 py-3">Product Name</th>
                        <th class="px-4 py-3">Qty</th>
                        <th class="px-4 py-3">Unit</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">VAT Amount</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Actions</th>
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
            $('#productList').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{route('product.datatable-list')}}',
                columns: [
                    {data: 'product_name', name: 'product_name', searchable: false},
                    {data: 'qty', name: 'qty', searchable: true},
                    {data: 'unit', name: 'unit', searchable: true},
                    {data: 'price', name: 'price', searchable: true},
                    {data: 'vat_amt', name: 'vat_amt', searchable: true},
                    {data: 'date', name: 'date', searchable: true},
                    {data: 'action', name: 'action', searchable: false},
                ]
            });
        };

        $(document).ready(function () {
            productList();
        });
    </script>
@endsection
