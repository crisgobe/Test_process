<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use DB;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $algo = \App\Libraries\Base::getOrdersQty();

        // echo "<pre/>"; print_r($algo); exit();

        $orders        = Order::get();
        $actives       = Order::where('status_id' , '<' , 3)->get();
        $canceled      = Order::where('status_id' , 3)->get();
        $finished      = Order::where('status_id' , 4)->get();
        $date_quantity = $this->getDataChart();
        $quantity_fin  = $this->getDataChartFinished();

        // echo "<pre/>"; print_r($canceled); exit();

        return view('home')
            ->with('orders' , $orders)
            ->with('actives' , $actives)
            ->with('canceled' , $canceled)
            ->with('finished' , $finished)
            ->with('date_quantity' , $date_quantity)
            ->with('quantity_fin' , $quantity_fin)
        ;
    }

    public function getDataChart()
    {
        $date_qty = Order::from(
            DB::raw("(
                SELECT
                    date_format(created_at , '%m/%Y') as format_f
                FROM orders) as suma")
            )
            ->select(DB::raw("count(format_f) as quantity") , "format_f")
            ->groupBy("format_f")
            ->get()
        ;

        return $date_qty;
    }

    public function getDataChartFinished()
    {
        $date_qty = Order::from(
            DB::raw("(
                SELECT
                    date_format(created_at , '%m/%Y') as format_f
                FROM orders
                WHERE status_id = 4) as suma")
            )
            ->select(DB::raw("count(format_f) as quantity") , "format_f")
            ->groupBy("format_f")
            ->get()
        ;

        return $date_qty;
    }
}
