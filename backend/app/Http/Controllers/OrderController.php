<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\Product;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderInterface;
    protected $notificationRepository;
    public function __construct(OrderInterface $orderInterface, NotificationRepository $notificationRepository)
    {
        $this->orderInterface = $orderInterface;
        $this->notificationRepository = $notificationRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('order.index');
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
        //Validate data
        $data = $request->only('shipping_address','contact_no','shipping_method');
        $validator = Validator::make($data, [
            'shipping_address' => 'required|string',
            'contact_no' => 'required|string',
            'shipping_method' => 'required|string',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new order
        $order= $this->orderInterface->placeOrder($request);

        //Create Notification

        $notification_data=array();
        $notification_data['notification_to_user_id']=1;
        $notification_data['notification_body']="A order has been placed order num# ".$order->order_no;

        if($order){
            $order_dtl= $this->orderInterface->placeOrderDtl($request,$order->id);
            $order_history= $this->orderInterface->orderHistory($order->id);
            $admin_notification= $this->notificationRepository->createNotification($notification_data,'WEB');
        }
        //Order created, return success response
        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $order
        ], Response::HTTP_OK);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Order::find($id);
        $history = OrderHistory::where('order_id',$id)->get();

        return view('order.edit',['data' => $data,'history'=>$history]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = [
            'status' => $request->get('status'),
            'description' => 'Order updated by '. Auth::user()->user_name
        ];
        $resData = $this->orderInterface->orderHistory($id = $request->get('order_id'),$data);
        if (filled($resData)) {
            return redirect()->route('order.edit',$request->get('order_id'))
                ->with('success','Order Updated successfully.');
        }
        return redirect()->route('order.list')
            ->with('error','Order Updated Not successfully.');
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
    public function datatableList(Request $request)
    {
        $queryResult = $this->orderInterface->findOrder();
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
                return '<div class="flex items-center space-x-4 text-sm">
                                <a
                                    href="'. route('order.edit', $query->id) .'"
                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                    aria-label="Edit"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        aria-hidden="true"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                        ></path>
                                    </svg>
                                </a>
                            </div>';
            })
            ->escapeColumns([])
            ->addIndexColumn()
            ->make(true);
    }

}
