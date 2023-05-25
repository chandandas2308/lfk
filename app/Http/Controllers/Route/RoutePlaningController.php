<?php

namespace App\Http\Controllers\Route;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Driver;
use Illuminate\Http\Request;

class RoutePlaningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $drivers1 = Driver::leftJoin('deliveries', 'deliveries.delivery_man_user_id', '=','drivers.id')
                    ->leftJoin('notifications', 'notifications.consolidate_order_no','=','deliveries.order_no')
                    ->orderBy('drivers.id','desc')
                    ->groupBy('notifications.consolidate_order_no')
                    ->get(['drivers.*', 'deliveries.date', 'deliveries.delivery_address', 'notifications.delivery_date']);

                    // dd($drivers1);

        $drivers = Driver::orderBy('id','desc')->get();
                    
        $deliveries = Delivery::orderBy('id','desc')->where('delivery_status', 'Packing')->orWhere('delivery_status', 'Pending')->get();

        return view('superadmin.Delivery.route_planing.add', compact('drivers','deliveries','drivers1'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
