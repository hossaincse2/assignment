<?php
namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use DB;

class ProductRepository implements ProductInterface
{
    public function findProduct($id = null)
    {
        if($id) {
            return Product::where('id', $id)->first();
        }

        return Product::all();
    }
    public function searchProduct($request = [])
    {
        $product = [];
        if($search_key = $request->get('search_key')) {
            $term = strtolower($search_key);
            $product =  Product::whereRaw('lower(product_name) like (?)',["%{$term}%"])->get();
        }

        return $product;
    }
    public function filterProduct($request = [])
    {
        if($request->get('order_by') == 'lowest_price') {
            $product =  Product::orderBy('price','ASC')->get();
        }else{
            $product =  Product::orderBy('price','DESC')->get();
        }

        return $product;
    }
}
