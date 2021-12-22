<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\ProductResource;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    protected $productRepo;
    public function __construct(ProductInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepo->findProduct();
        return response()->json(['status'=>true,'products' => $products]);
    }

    public function search(Request $request)
    {
        $products = $this->productRepo->searchProduct($request);
        return response()->json(['status'=>true,'products' => $products]);;
    }

    public function filter(Request $request)
    {
        $products = $this->productRepo->filterProduct($request);
        return response()->json(['status'=>true,'products' => $products]);;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $product = $this->productRepo->findProduct($request->get('product_id'));
        return response()->json(['status'=>true,'product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
