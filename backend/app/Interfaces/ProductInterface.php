<?php
namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Http\Request;

interface ProductInterface
{
    /**
     * @param null $id
     * @return Product[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findProduct($id = null);
    public function searchProduct($request = []);
    public function filterProduct($request = []);
}
