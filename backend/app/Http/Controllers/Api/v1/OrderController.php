<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\OrderRequest;
use App\Interfaces\NotificationInterface;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    protected $orderInterface;
    protected $notificationRefo;
    public function __construct(OrderInterface $orderInterface, NotificationInterface $notificationRefo)
    {
        $this->middleware(['auth:sanctum'])->only('create', 'index');
        $this->orderInterface = $orderInterface;
        $this->notificationRefo = $notificationRefo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderInterface->findUserOrder();
        return response()->json(['orders' => $orders]);
    }

    public function filter(Request $request)
    {
        $orders = $this->orderInterface->filterOrder($request);
        return response()->json(['orders' => $orders]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(OrderRequest $request)
    {

        //Request is valid, create new order
        $order= $this->orderInterface->placeOrder($request);

        //Create Notification

        $notification_data=array();
        $notification_data['notification_to_user_id']=1;
        $notification_data['notification_body']="A order has been placed order num# ".$order->order_no;

        $orderData = [
            'status' => $request->get('status'),
            'description' => 'Order place by customer'
        ];
        if($order){
            $order_dtl= $this->orderInterface->placeOrderDtl($request,$order->id);
            $order_history= $this->orderInterface->orderHistory($order->id,$orderData);
            $admin_notification= $this->notificationRefo->createNotification($notification_data,'WEB');
         }
        //Order created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $order
        ], Response::HTTP_OK);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
