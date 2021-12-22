<?php
namespace App\Interfaces;

use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;

interface OrderInterface
{
    /**
     * @param null $id
     * @return Order[]|\Illuminate\Database\Eloquent\Collection
     */
    public function placeOrder($data = []);
    public function placeOrderDtl($data = [],$id = null);
    public function orderHistory($id = null,$data = []);
    public function findOrder($id = null);
    public function findUserOrder($id = null);
    public function filterOrder($request = null);
    /**
     * @param null $id
     * @return Delivery[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findDelivery($id = null);
    public function moveToDelivery($param=[]);
}
