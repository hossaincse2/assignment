<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalUser = User::count();
        $totalProduct = Product::count();
        $totalOrder = Order::count();
        $totalOrderBalance = Order::sum('net_amount');

        return view('home',[
            'totalUser' => $totalUser,
            'totalProduct' => $totalProduct,
            'totalOrderBalance' => $totalOrderBalance,
            'totalOrder' => $totalOrder
        ]);
    }
}
