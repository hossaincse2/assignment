@extends('layouts.dashboard')

@section('content')
    <div class="container px-6 mx-auto grid">
        <h2
            class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
        >
            {{$title}}
        </h2>
        <!-- CTA -->
        @if ($errors->any())
            <div class="alert alert-danger flex  p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif

        <!-- General elements -->
        <div
            class="px-4 py-3 mb-8 bg-whitex v rounded-lg shadow-md dark:bg-gray-800"
        >
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{$data->id}}" name="product_id"/>
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Product Name</span>
                    <input
                        value="{{old('product_name',$data->product_name)}}"
                        name="product_name"
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        placeholder="Enter Product Name"
                    />
                </label>
                <label class="block text-sm mt-4">
                    <span class="text-gray-700 dark:text-gray-400">Description</span>
                    <textarea
                        name="description"
                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        rows="3"
                        placeholder="Enter description"
                    >{{old('description',$data->description)}}</textarea>
                </label>



            <label class="block text-sm mt-4">
                <span class="text-gray-700 dark:text-gray-400">Qty</span>
                <input
                    value="{{old('qty',$data->qty)}}"
                    name="qty"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="1"
                />
            </label>
            <label class="block text-sm mt-4">
                <span class="text-gray-700 dark:text-gray-400">Unit</span>
                <input
                    value="{{old('unit',$data->unit)}}"
                    name="unit"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Kg"
                />
            </label>
            <label class="block text-sm mt-4">
                <span class="text-gray-700 dark:text-gray-400">Price</span>
                <input
                    value="{{old('price',$data->price)}}"
                    name="price"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="100.00"
                />
            </label>
            <label class="block text-sm mt-4">
                <span class="text-gray-700 dark:text-gray-400">Vat Amount</span>
                <input
                    value="{{old('vat_amt',$data->vat_amt)}}"
                    name="vat_amt"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="10.00"
                />
            </label>
            <label class="block text-sm mt-4">
                <span class="text-gray-700 dark:text-gray-400">Image</span>
                <input
                    name="image"
                    type="file"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                 />
                @if ($data->image)
                    <input type="hidden" value="{{$data->image}}" name="old_image"/>
                    <img src="{{ asset('products/thumbnails/'.$data->image) }}" alt="" title="{{$data->product_name}}" />
                @endif
            </label>

            <div class="mt-4">
                <button
                    type="submit"
                    class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                >
                    Submit
                </button>
            </div>
            </form>
        </div>
    </div>
@endsection
