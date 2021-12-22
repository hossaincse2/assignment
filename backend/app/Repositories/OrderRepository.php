<?php
namespace App\Repositories;

use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderHistory;
use App\Models\Delivery;
use DB;
use Illuminate\Support\Facades\Auth;

class OrderRepository implements OrderInterface
{
    public function placeOrder($request=[])
    {
        //Request is valid, create new order

        $order_summary=array();
        $items=$request->all();
        $order_summary['total_amount']=$items['price']*$items['qty'];
        $order_summary['total_vat']=$items['vat_amount']*$items['qty'];
        $order_summary['net_amount']=$order_summary['total_amount']+$order_summary['total_vat'];

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_no' => 'HO'.date('Ymd') . str_pad(mt_rand(1, 99999), 3, '0', STR_PAD_LEFT),
            'total_amount' => $order_summary['total_amount'],
            'total_qty' => $items['qty'],
            'total_vat' => $order_summary['total_vat'],
            'net_amount' => $order_summary['net_amount'],
            'shipping_address' => $items['shipping_address'],
            'contact_no' => $items['contact_no'],
            'shipping_method' => 'COD',
            'created_by' => Auth::id()
        ]);

        return $order;
    }
    public function placeOrderDtl($request=[],$id = null )
    {
        //Request is valid, create new order

        $order_summary=array();
        $items=$request->all();
        $order_summary['total_amount']=$items['price']*$items['qty'];
        $order_summary['total_vat']=$items['vat_amount']*$items['qty'];

        $order_dtl= OrderDetail::create([
            'order_id' => $id,
            'product_id' => $items['product_id'],
            'price' => $items['price'],
            'qty' =>$items['qty'],
            'total_vat' => $order_summary['total_vat'],
            'total_amount' => $order_summary['total_amount'],
            'created_by' => Auth::id(),
        ]);
        return $order_dtl;
    }
    public function orderHistory($id = null,$data = [])
    {
        //Request is valid, create new order
        $order = new Order();
        $order->exists = true;
        $order->id = $id;
        $order->status = $data['status'];
        $order->save();

        $order_history= OrderHistory::create([
            'order_id' => $id,
            'description' => $data['description'],
            'status' => $data['status'],
            'created_by' => Auth::id(),
        ]);
        return $order_history;
    }
    public function findOrder($id = null)
    {
        if($id) {
            return Order::where('id', $id)->first();
        }

        return Order::all();
    }
    public function findUserOrder($id = null)
    {
        if($id) {
            return Order::where('id', $id)->first();
        }

        return Order::where('user_id',Auth::id())->get();
    }
    public function findDelivery($id = null)
    {
        if($id) {
            return Delivery::where('id', $id)->first();
        }

        return Delivery::all();
    }

    public function filterOrder($request = [])
    {
        $status = $request->get('status');
        if($status == 'Pending') {
            $product =  Order::where('status','Pending')->where('user_id',Auth::id())->get();
        }else if ($status == 'Delivered') {
            $product =  Order::where('status','Delivered')->where('user_id',Auth::id())->get();
        }else if ($status == 'Approved') {
            $product =  Order::where('status','Approved')->where('user_id',Auth::id())->get();
        }else if ($status == 'Rejected') {
            $product =  Order::where('status','Rejected')->where('user_id',Auth::id())->get();
        }else{
            return Order::where('user_id',Auth::id())->get();
        }

        return $product;
    }

    public function moveToDelivery($data=[])
    {

        $delivery='';

        foreach ($data as $key => $val) {
            $delivery = Delivery::create([
                'user_id' => $val->user_id,
                'order_id' => $val->id,
                'oder_number' =>  $val->order_no,
                'total_amount' => $val->total_amount,
                'total_qty' => $val->total_qty,
                'total_vat' => $val->total_vat,
                'net_amount' => $val->net_amount,
                'created_by' => $val->created_by
            ]);
        }

        return $delivery;

    }
}
