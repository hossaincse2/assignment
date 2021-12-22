<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderInterface;
use App\Models\Deliverie;
use Illuminate\Http\Request;

class DeliverieController extends Controller
{
    protected $orderInterface;
    public function __construct(OrderInterface $orderInterface)
    {
        $this->orderInterface = $orderInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('delivery.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deliverie  $deliverie
     * @return \Illuminate\Http\Response
     */
    public function show(Deliverie $deliverie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deliverie  $deliverie
     * @return \Illuminate\Http\Response
     */
    public function edit(Deliverie $deliverie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deliverie  $deliverie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deliverie $deliverie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deliverie  $deliverie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deliverie $deliverie)
    {
        //
    }
    public function datatableList(Request $request)
    {
        $queryResult = $this->orderInterface->findDelivery();
        return datatables()->of($queryResult)
            ->addColumn('date', function($query) {
                return date('d-m-Y',strtotime($query->created_at));
            })
            ->addColumn('user_name', function($query) {
                return isset($query->user) ? $query->user->user_name : '';
            })
            ->addColumn('email', function($query) {
                return isset($query->user) ? $query->user->email : '';
            })
            ->addColumn('phone', function($query) {
                return isset($query->user) ? $query->user->phone : '';
            })
            ->addColumn('action', function($query) {

            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }

}
