@extends('layouts.dashboard')

@section('content')
    <div class="container px-6 mx-auto grid">
        <h2
            class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
        >
            Order Edit
        </h2>
        <!-- CTA -->
        @if ($errors->any())
            <div
                class="alert alert-danger flex  p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif
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

    <!-- General elements -->
        <div
            class="px-4 py-3 mb-8 bg-whitex v rounded-lg shadow-md dark:bg-gray-800"
        >
            <form action="{{ route('order.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" value="{{$data->id}}">
                <div class="grid gap-6 mb-8 md:grid-cols-2">

                    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                        <label class="block mt-4 text-sm">
                            <span class="text-gray-700 dark:text-gray-400">  Status </span>
                            <select
                                name="status"
                                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            >
                                <option value="Pending" {{$data->status == 'Pending' ? 'selected' : ''}}>Pending</option>
                                <option value="Approved" {{$data->status == 'Approved' ? 'selected' : ''}}>Approved</option>
                                <option value="Delivered" {{$data->status == 'Delivered' ? 'selected' : ''}}>Delivered</option>
                                <option value="Rejected" {{$data->status == 'Rejected' ? 'selected' : ''}}>Rejected</option>
                            </select>
                        </label>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300 mt-4">
                                    Customer Info
                                </h4>
                                <ul class="list-none md:list-disc float-left text-gray-600 dark:text-gray-400">
                                    <li><b> Name : </b> {{$data->user->name}}</li>
                                    <li><b> Email : </b> {{$data->user->email}}</li>
                                    <li><b> Phone : </b> {{$data->user->phone}}</li>
                                    <li><b> Address : </b> {{$data->user->address}}</li>
                                  </ul>
                            </div>
                            <div>
                                <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300 mt-4">
                                    Order Info
                                </h4>
                                <ul class="list-none md:list-disc float-left text-gray-600 dark:text-gray-400">
                                    <li><b>Order No : </b> {{$data->order_no}}</li>
                                    <li><b>Shipping Address : </b> {{$data->shipping_address}}</li>
                                    <li><b>Order Status : </b> {{$data->status}}</li>
                                    <li><b>Total QTY : </b> {{$data->total_qty}}</li>
                                    <li><b>Total Amount : </b> {{$data->net_amount}}</li>
                                    <li><b>Shipping Method : </b> {{$data->shipping_method}}</li>
                                 </ul>
                            </div>
                        </div>
                    </div>
                    <div class="min-w-0 p-4 text-white bg-white rounded-lg shadow-xs">
                        <h4 class="mb-4 font-semibold text-gray-600">
                            Product Info
                        </h4>
                        @foreach($data->orderDetails as $orderDetails)
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <ul class="list-none md:list-disc float-left text-gray-600">
                                    <li style="line-height: 38px;"><b>Product Name : </b> {{$orderDetails->product->product_name}}</li>
                                    <li style="line-height: 38px;"><b>Product Description : </b> {{$orderDetails->product->description}}</li>
                                    <li style="line-height: 38px;"><b>Product QTY : </b> {{$orderDetails->product->qty}}</li>
                                    <li style="line-height: 38px;"><b>Product Unit : </b> {{$orderDetails->product->unit}}</li>
                                    <li style="line-height: 38px;"><b>Product Price : </b> {{$orderDetails->product->price}}</li>
                                    <li style="line-height: 38px;"><b>Product VAT Amount : </b> {{$orderDetails->product->vat_amt}}</li>
                                </ul>
                            </div>
                            <div>
                                <img class="float-right" src="{{ asset('products/thumbnails/'.$orderDetails->product->image) }}" alt=""
                                     title="{{$orderDetails->product->product_name}}"/>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-right  float-right">
                        <button
                            type="submit"
                            class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                        >
                            Update Order
                        </button>
                    </div>
                </div>
                <div class="grid gap-6 mb-8 md:grid-cols-1 mt-6">
                    <div class="min-w-0 p-4 text-gray-600 bg-white rounded-lg shadow-xs">
                         <h4 class="mb-4 font-semibold text-gray-600">
                             Order History
                         </h4>
                    <ul class="timeline">
                        @php $i = 0; @endphp
                        @foreach($history as $orderHis)
                            @php $i++; @endphp
                            <li>
                                <div class="{{$i % 2 == 0 ? 'direction-l' : 'direction-r'}}">
                                    <div class="flag-wrapper">
                                        <span class="flag">{{$orderHis->status}}</span>
                                        <span class="time-wrapper"><span class="time">{{date('d M, Y h:i a', strtotime($orderHis->created_at))}}</span></span>
                                    </div>
                                    <div class="desc">{{$orderHis->description}}</div>
                                </div>
                            </li>
                        @endforeach 

                    </ul>

                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
