<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Interfaces\OrderInterface;
use App\Models\Delivery;
use App\Models\Order;

class DeliveryCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delivery:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OrderInterface  $OrderInterface)
    {
        parent::__construct();
         $this->orderInterface=$OrderInterface;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $deliveries=Delivery::pluck('order_id')->all();
        $orders=Order::where('status','Delivered')
            ->whereNotIn('id',$deliveries)
            ->get();

        $this->orderInterface->moveToDelivery($orders);

        $this->info('Successfully moved order to delivery table.');
    }
}
