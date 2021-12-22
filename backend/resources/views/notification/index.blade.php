@extends('layouts.dashboard')

@section('content')
    <div class="container grid px-6 mx-auto">
        <div class="flex items-center justify-between mb-4 space-y-4 md:flex-row md:items-end md:space-x-4">
            <h2
                class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
                Notifications
            </h2>
        </div>

    <!-- With actions -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                @foreach($notifications as $notification)
                        <div class="flex items-center bg-blue-600 text-white text-sm font-bold px-4 py-3" role="alert">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                            <p>{{$notification->notification_body}}</p>
                        </div>
                 @endforeach
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
                    {data: 'order_number', name: 'order_number', searchable: false},
                    {data: 'user_name', name: 'user_name', searchable: false},
                    {data: 'total_amt', name: 'total_amt', searchable: true},
                    {data: 'total_qty', name: 'total_qty', searchable: true},
                    {data: 'total_vat', name: 'total_vat', searchable: true},
                    {data: 'net_amt', name: 'net_amt', searchable: true},
                    {data: 'status', name: 'status', searchable: true},
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
