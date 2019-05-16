<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Order;
use App\OrderStatus;
use App\Phase;
use App\Customer;
use App\Product;
use App\OrderProduct;
use App\Step;
use App\OrderStep;
use App\CustomerType;
use App\City;
use App\Department;
use App\File;
use App\OrderFile;
use Storage;
use PDF;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders       = Order::get();
        $order_status = OrderStatus::where('id' , '<' , 3)->get();
        $steps = Step::get();
        $cities = City::get();

        return view('admin/orders/list')
            ->with('orders' , $orders)
            ->with('order_status' , $order_status)
            ->with('steps' , $steps)
            ->with('cities' , $cities)
        ;
    }

    public function listAll()
    {
        $orders       = Order::get();
        $order_status = OrderStatus::where('id' , '<' , 3)->get();
        $steps = Step::get();
        $cities = City::get();

        return view('admin/orders/list_all')
            ->with('orders' , $orders)
            ->with('order_status' , $order_status)
            ->with('steps' , $steps)
            ->with('cities' , $cities)
        ;
    }

    public function tableOrdersList( Request $request )
    {
        $fiters = false;

        $data = $request->all();

        $columns = array(
            0 => 'number' ,
            1 => '' ,
            2 => '' ,
            3 => 'date_order' ,
            4 => 'days'
        );

        $orders_query = Order::getListquery();
        // echo $orders_query->toSql(); exit();

        // $orders_query = Order::with(['orderStep.step' , 'orderStep.status' , 'customer' , 'status']);

        if (!empty($request['columns'][0]['search']['value'])) {
            $filter         = $request['columns'][0]['search']['value'];
            $orders_query = $orders_query->where("o.number" , "like" , "%$filter%");
            $fiters         = true;
        }

        if (!empty($request['columns'][1]['search']['value'])) {
            $filter         = $request['columns'][1]['search']['value'];
            $orders_query = $orders_query->where("c.id" , $filter);
            $fiters         = true;
        }

        if (!empty($request['columns'][2]['search']['value'])) {
            $filter         = $request['columns'][2]['search']['value'];
            $orders_query = $orders_query->where("o.status_id" , $filter);
            $fiters         = true;
        }

        if (!empty($request['columns'][3]['search']['value'])) {
            $filter         = $request['columns'][3]['search']['value'];
            $orders_query = $orders_query->where("o.status_id" , $filter);
            $fiters         = true;
        }

        if (!empty($request['columns'][4]['search']['value'])) {
            $filter         = $request['columns'][4]['search']['value'];
            $orders_query = $orders_query->where(DB::raw('timestampdiff(DAY , o.created_at , curdate())') , "like" , "%$filter%");
            $fiters         = true;
        }

        $orders_query = $orders_query->orderBy(
            $columns[$request['order'][0]['column']] ,
            $request['order'][0]['dir']
        );

        $orders = $orders_query->where('o.status_id' , '<' , 3)->get();

        $iTotalRecords  = count($orders);
        $iDisplayLength = intval($request['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart  = intval($request['start']);
        $sEcho          = intval($request['draw']);

        $records         = array();
        $records["data"] = array();

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        for ($i = $iDisplayStart; $i < $end; $i++) {
            $step = '';

            if (isset($orders[$i]->orderStep->step)) {
                $step = $orders[$i]->orderStep->step->step;
            }

            $date_create = new \DateTime( $orders[$i]->date_order );
            $date_update = new \DateTime( $orders[$i]->date_order_step );

            $label    = 'primary';
            $qty_days = $orders[$i]->days;

            if ($qty_days == 2) {
                $label = 'warning';
            }
            else if ($qty_days >= 3) {
                $label = 'danger';
            }

            $records["data"][] = array(
                $orders[$i]->order_number ,
                $orders[$i]->city ,
                $orders[$i]->order_status ,
                '<span class="label label-' . $label . '">' . $date_create->format( "d/M/Y" ) . '</span><br>' . $date_create->format( "h:i a" ) ,
                '<span class="label label-' . $label . '">' . $qty_days . '</span>' ,
                '<a href="orders/' . $orders[$i]->id . '?source=1" class="btn green-sharp btn-outline btn-block btn-sm">
                    <i class="fa fa-search"></i> 
                    Ver
                </a>'
            );
        }

        $records["draw"]            = $sEcho;
        $records["recordsTotal"]    = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;

        return response()->json($records , 200);
    }

    public function tableOrdersListAll( Request $request )
    {
        $fiters = false;

        $data = $request->all();

        $columns = array(
            0 => 'number' ,
            1 => '' ,
            2 => '' ,
            3 => 'date_order' ,
            4 => 'days'
        );

        $orders_query = Order::getListquery();

        // $orders_query = Order::with(['orderStep.step' , 'orderStep.status' , 'customer' , 'status']);

        if (!empty($request['columns'][0]['search']['value'])) {
            $filter         = $request['columns'][0]['search']['value'];
            $orders_query = $orders_query->where("o.number" , "like" , "%$filter%");
            $fiters         = true;
        }

        if (!empty($request['columns'][1]['search']['value'])) {
            $filter         = $request['columns'][1]['search']['value'];
            $orders_query = $orders_query->where("c.id" , $filter);
            $fiters         = true;
        }

        if (!empty($request['columns'][2]['search']['value'])) {
            $filter         = $request['columns'][2]['search']['value'];
            $orders_query = $orders_query->where("o.status_id" , $filter);
            $fiters         = true;
        }

        if (!empty($request['columns'][3]['search']['value'])) {
            $filter         = $request['columns'][3]['search']['value'];
            $orders_query = $orders_query->where("o.status_id" , $filter);
            $fiters         = true;
        }

        if (!empty($request['columns'][4]['search']['value'])) {
            $filter         = $request['columns'][4]['search']['value'];
            $orders_query = $orders_query->where(DB::raw('timestampdiff(DAY , o.created_at , curdate())') , "like" , "%$filter%");
            $fiters         = true;
        }

        $orders_query = $orders_query->orderBy(
            $columns[$request['order'][0]['column']] ,
            $request['order'][0]['dir']
        );

        $orders = $orders_query->get();

        $iTotalRecords  = count($orders);
        $iDisplayLength = intval($request['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart  = intval($request['start']);
        $sEcho          = intval($request['draw']);

        $records         = array();
        $records["data"] = array();

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        for ($i = $iDisplayStart; $i < $end; $i++) {
            $step = '';

            if (isset($orders[$i]->orderStep->step)) {
                $step = $orders[$i]->orderStep->step->step;
            }

            $date_create = new \DateTime( $orders[$i]->date_order );
            $date_update = new \DateTime( $orders[$i]->date_order_step );

            $label    = 'primary';
            $qty_days = $orders[$i]->final_day;

            if ($qty_days == 2) {
                $label = 'warning';
            }
            else if ($qty_days >= 3) {
                $label = 'danger';
            }

            $records["data"][] = array(
                $orders[$i]->order_number ,
                $orders[$i]->city ,
                $orders[$i]->order_status ,
                '<span class="label label-' . $label . '">' . $date_create->format( "d/M/Y" ) . '</span><br>' . $date_create->format( "h:i a" ) ,
                '<span class="label label-' . $label . '">' . $qty_days . '</span>' ,
                '<a href="' . $orders[$i]->id . '?source=2" class="btn green-sharp btn-outline btn-block btn-sm">
                    <i class="fa fa-search"></i> 
                    Ver
                </a>'
            );
        }

        $records["draw"]            = $sEcho;
        $records["recordsTotal"]    = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;

        return response()->json($records , 200);
    }

    public function tableProductsList( Request $request )
    {
        $fiters = false;

        $data = $request->all();

        $columns = array(
            0 => 'code' ,
            1 => 'description' ,
            2 => 'price'
        );

        // $db = new DB(config('app.manufacturerDB'));

        $products_query = Product::query();

        if (!empty($request['columns'][0]['search']['value'])) {
            $filter         = $request['columns'][0]['search']['value'];
            $products_query = $products_query->where("code" , "LIKE" , "%$filter%");
            $fiters         = true;
        }

        if (!empty($request['columns'][1]['search']['value'])) {
            $filter         = $request['columns'][1]['search']['value'];
            $products_query = $products_query->where("description" , "LIKE" , "%$filter%");
            $fiters         = true;
        }

        if (!empty($request['columns'][2]['search']['value'])) {
            $filter         = $request['columns'][2]['search']['value'];
            $products_query = $products_query->where("price" , "LIKE" , "%$filter%");
            $fiters         = true;
        }

        $products_query = $products_query->orderBy(
            $columns[$request['order'][0]['column']] ,
            $request['order'][0]['dir']
        );

        $products = $products_query->where('status_id' , 1)->get();

        $iTotalRecords  = count($products);
        $iDisplayLength = intval($request['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart  = intval($request['start']);
        $sEcho          = intval($request['draw']);

        $records         = array();
        $records["data"] = array();

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        for ($i = $iDisplayStart; $i < $end; $i++) {
            $string_onclick = $products[$i]->id . '|' . $products[$i]->description . '|' . $products[$i]->price;
            $records["data"][] = array(
                '<button class="btn-link select_product_id" onclick="selectProductId(\'' . $string_onclick . '\')" name="' . $products[$i]->id . '|' . $products[$i]->description . '|' . $products[$i]->price . '">
                    ' . $products[$i]->code . '
                </button>' ,
                $products[$i]->description ,
                '$ ' . number_format($products[$i]->price)
            );
        }

        $records["draw"]            = $sEcho;
        $records["recordsTotal"]    = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;

        return response()->json($records , 200);
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

    public function createOrder( Request $request )
    {
        $data = $request->all();
        $order_number = '1000000001';

        $ultimate_order = Order::get()->last();

        if ($ultimate_order != '') {
            $order_number = $ultimate_order->number + 1;
        }

        $data_order = array(
            'number' => $order_number ,
            'status_id' => 1 ,
            'cities_id' => $data['city']
        );

        // echo "<pre/>"; print_r($data_order); exit();

        $order = Order::create( $data_order );

        $data_order_step = array(
            'orders_id' => $order->id ,
            'steps_id'  => 1 ,
            'comment'   => $data['comment'] ,
            'users_id'  => auth()->id() ,
            'status_id' => 1 ,
            'actual'    => 1 ,
            'next'      => 2
        );

        // echo "<pre/>"; print_r($data_order_step); exit();

        $order_step = OrderStep::create($data_order_step);

        return response()->json(['Order create successfully'] , 200);


        echo "<pre/>"; print_r($order); exit();
    }

    public function newOrder()
    {
        $cities       = City::get();
        $departments  = Department::get();
        $order_number = '1000000001';

        $ultimate_order = Order::get()->last();

        if ($ultimate_order != '') {
            $order_number = $ultimate_order->number + 1;
        }

        // echo "<pre/>"; print_r($order_number); exit();

        return view('admin/orders/new')
            ->with('cities' , $cities)
            ->with('departments' , $departments)
            ->with('order_number' , $order_number)
        ;
    }

    public function getCities( Request $request )
    {
        $data   = $request->all();
        $cities = City::where('departments_id' , $data['departments_id'])->get();

        return response()->json(['cities' => $cities] , 200);
    }

    public function orderPreview( Request $request )
    {
        $data = $request->all();

        if (!isset($data['products'])) {
            return response()->json([
                'Error' => 'No ha seleccionado productos'
            ] , 200);
        }

        $products_id;
        $products_selected;

        foreach ($data['products'] as $product_id) {
            $products_id[] = $product_id[0];
        }

        $customer = Customer::find( $data['customer'] );
        $products = Product::whereIn('id' , $products_id)->get();
        $total = 0;

        foreach ($data['products'] as $product_id) {
            $product_actual = $products->where('id' , $product_id[0]);

            foreach ($product_actual as $actual) {
                $products_selected[] = array(
                    'code' => $actual->code ,
                    'description' => $actual->description ,
                    'price_total' => ($actual->price * $product_id[1]) ,
                    'quantity' => $product_id[1] ,
                    'price' => $actual->price
                );

                $total += ($actual->price * $product_id[1]);
            }
        }

        return response()->json([
            'confirmation_products' => $products_selected ,
            'confirmation_customer' => $customer ,
            'total_order' => $total
        ] , 200);

        echo "<pre/>"; print_r($products_selected); exit();
    }

    public function orderCreateSuccess()
    {
        return redirect('orders')
            ->with('message' , 'Pedido creado exitosamente')
        ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        $source    = request()->input('source');
        $steps_all = Step::get();
        $order     = Order::find( $id );
        $steps     = OrderStep::where('orders_id' , $id)->get();
        $last_step = $steps->last();

        $show     = 'no';
        $finalize = 'no';
        $calendar = 'no';
        $file     = 'no';
        $approved = 'no';

        if (auth()->user()->user_types_id == 3 && $last_step->steps_id == 1) {
            $show = 'yes'; //Asignación de fechas
            $calendar = 'yes';
        }
        else if (auth()->user()->user_types_id == 2 && $last_step->steps_id == 2) {
            $show = 'yes'; // Subir documento
            $file = 'yes';
        }
        else if (auth()->user()->user_types_id == 3 && $last_step->steps_id == 3) {
            $show = 'yes'; // Aprobar
        }
        else if (auth()->user()->user_types_id == 2 && $last_step->steps_id == 4) {
            $show = 'yes'; // Finalizar
            $finalize = 'yes';
        }
        else if (auth()->user()->areas_id == 4 && $last_step->steps_id == 5) {
            $show = 'yes'; // Creación de factura
        }
        else if (auth()->user()->areas_id == 6 && $last_step->steps_id == 6) {
            $show = 'yes'; // Agregar guía
        }
        else if (auth()->user()->areas_id == 7 && $last_step->steps_id == 7) {
            $show     = 'yes'; // Recepción de factura y finalizado de tracking
            $finalize = 'yes';
        }

        $url_back = '../orders';

        if ($source == 2) {
            $url_back = '../orders/all';
        }
        // $steps = $step_query->get();

        // echo "<pre/>"; print_r($last_step->next); exit();

        if ($order->status_id == 3) {
            $show = 'no';
        }

        $download = '';

        $file_to_download = OrderFile::where('orders_id' , $order->id)->first();

        if (count($file_to_download) > 0) {
            $file_down = File::find($file_to_download->files_id);
            $download = $file_down->file_route;
        }

        return view('admin/orders/detail')
            ->with('order' , $order)
            ->with('steps' , $steps)
            ->with('last_step' , $last_step)
            ->with('show' , $show)
            ->with('finalize' , $finalize)
            ->with('url_back' , $url_back)
            ->with('steps_all' , $steps_all)
            ->with('calendar' , $calendar)
            ->with('file' , $file)
            ->with('download' , $download)
        ;
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

    public function changePhaseOrder( Request $request )
    {
        $data = $request->all();
        $step = $data['phase_step'];

        if ($data['status_step'] == 2) {
            $step = $step + 1;
        }

        // echo "<pre/>"; print_r($data); exit();

        if ($data['phase_step'] == 1) {
            Order::where('id' , $data['orders_id'] )->update(['date_range' => $data['date_range']]);
        }
        else if ($data['phase_step'] == 2) {
            $file = $request->file('file_process');

            $file_route = time() . '_' . $file->getClientOriginalName();

            Storage::disk('process_files')->put($file_route , file_get_contents($file->getRealPath()));

            $file = File::create(['file_route' => $file_route]);

            OrderFile::create([
                'orders_id' => $data['orders_id'] ,
                'files_id'  => $file->id
            ]);
        }
        else if ($data['phase_step'] == 3 && $data['status_step'] == 2) {
            Order::where('id' , $data['orders_id'] )->update(['approved' => 1]);
        }

        // echo "<pre/>"; print_r($data); exit();

        $data_order_step = array(
            'orders_id'  => $data['orders_id'] ,
            'steps_id'   => $step ,
            'comment'    => $data['comments'] ,
            'users_id'   => auth()->id() ,
            'status_id'  => $data['status_step'] ,
            'actual'     => 1 ,
            'next'       => $step + 1
        );

        // echo "<pre/>"; print_r($data_order_step); exit();
        OrderStep::where('orders_id' , $data['orders_id'])
            ->where('actual' , 1)
            ->update(['actual' => 0])
        ;

        $order_step = OrderStep::create($data_order_step);

        if ($data['status_step'] == 2) {
            Order::find( $data['orders_id'] )->update(['status_id' => 1]);
        }

        if ($data['status_step'] == 3) {
            Order::find( $data['orders_id'] )->update(['status_id' => 2]);
        }

        if ($data['status_step'] == 4) {
            Order::find( $data['orders_id'] )->update(['status_id' => 3]);
        }

        if ($data['phase_step'] == 4) {
            Order::find( $data['orders_id'] )->update(['status_id' => 4]);
        }

        return redirect('orders')
            ->with('message' , 'Pedido modificado exitosamente')
        ;
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

    public function pdfAllOrders( $source )
    {
        if ($source == 2) {
            $orders = Order::with(['orderStep.step' , 'customer' , 'status'])->get();
        }
        else {
            $orders = Order::with(['orderStep.step' , 'customer' , 'status'])->where('status_id' , '<' , 3)->get();
        }
        // $users  = User::get();
        // $products = InvoiceProduct::where( 'invoices_id' , $id )->get();
        // return view('pdfs/users/list')->with('users' , $users);

        $pdf = PDF::loadView('pdfs.orders.list_all' , [
            'orders'  => $orders
        ])->setPaper('a4');

        // echo "<pre/>"; print_r($pdf); exit();

        return $pdf->stream('orders.pdf');
    }

    public function printOrderPreview( $data )
    {
        $arr = json_decode($data);

        if (!isset($arr->products)) {
            return response()->json([
                'Error' => 'No ha seleccionado productos'
            ] , 200);
        }

        $products_id;
        $products_selected;

        foreach ($arr->products as $product_id) {
            $products_id[] = $product_id[0];
        }

        $customer = Customer::find( $arr->customer );
        $products = Product::whereIn('id' , $products_id)->get();
        $total = 0;

        foreach ($arr->products as $product_id) {
            $product_actual = $products->where('id' , $product_id[0]);

            foreach ($product_actual as $actual) {
                $products_selected[] = array(
                    'code'        => $actual->code ,
                    'description' => $actual->description ,
                    'price_total' => ($actual->price * $product_id[1]) ,
                    'quantity'    => $product_id[1] ,
                    'price'       => $actual->price
                );

                $total += ($actual->price * $product_id[1]);
            }
        }

        $pdf = PDF::loadView('pdfs.orders.preview' , [
            'products' => $products_selected ,
            'customer' => $customer ,
            'total'    => $total
        ])->setPaper('a4');

        return $pdf->stream('order_preview.pdf');

        echo "<pre/>"; print_r($total); exit();
    }

    public function printOrder( $id )
    {
        $order_products = OrderProduct::where('orders_id' , $id)->get();
        $order = Order::find( $id );

        $order_products_id  = array();
        $order_products_qty = array();

        foreach ($order_products as $key => $product) {
            $order_products_id[$key][0] = $product->products_id;
            $order_products_id[$key][1] = $product->quantity;
        }

        $products_id;
        $products_selected;

        foreach ($order_products as $product) {
            $products_id[] = $product->products_id;
        }

        $customer = Customer::find( $order->customers_id );
        $products = Product::whereIn('id' , $products_id)->get();
        $total = 0;

        foreach ($order_products_id as $product_id) {
            $product_actual = $products->where('id' , $product_id[0]);

            foreach ($product_actual as $actual) {
                $products_selected[] = array(
                    'code'        => $actual->code ,
                    'description' => $actual->description ,
                    'price_total' => ($actual->price * $product_id[1]) ,
                    'quantity'    => $product_id[1] ,
                    'price'       => $actual->price
                );

                $total += ($actual->price * $product_id[1]);
            }
        }

        $pdf = PDF::loadView('pdfs.orders.preview' , [
            'products' => $products_selected ,
            'customer' => $customer ,
            'total'    => $total ,
            'date'     => $order->created_at
        ])->setPaper('a4');

        return $pdf->stream('order_preview.pdf');

        echo "<pre/>"; print_r($product_id); exit();
    }

    public function excelAllOrders( $source )
    {
        Excel::create("Pedidos", function($excel) use ( $source )
        {
            $data = self::getData( $source );

            $excel->getDefaultStyle()
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ;

            if ($source == 1) {
                $title = substr('Listado de Pedidos Activos' , 0 , 30);
            }
            else if ($source == 2) {
                $title = substr('Listado de todos los Pedidos' , 0 , 30);
            }

            $excel->sheet($title , function( $sheet ) use ( $data , $source )
            {
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');
                $sheet->mergeCells('A3:G3');
                $sheet->mergeCells('A4:G4');
                $sheet->mergeCells('A5:G5');

                $sheet->row(2 , ['TRACKING SYSTEM']);

                if ($source == 1) {
                    $sheet->row(3 , ['Listado de Pedidos Activos']);
                }
                else if ($source == 2) {
                    $sheet->row(3 , ['Listado de todos los Pedidos']);
                }
                
                $sheet->row(4 , ['Fecha: ' . date("d / m / Y")]);

                $sheet->cell('A6' , 'Número');
                $sheet->cell('B6' , 'Cliente');
                $sheet->cell('C6' , 'Fase');
                $sheet->cell('D6' , 'Etapa');
                $sheet->cell('E6' , 'Estado');
                $sheet->cell('F6' , 'Creación');
                $sheet->cell('G6' , 'Días');

                $sheet->cell('A6:G6' , function($cells)
                {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($data , null , 'A7' , true , false);

                $sheet->cell('A2:G4' , function($cells)
                {
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
            });
            
        })->download("xlsx");
    }

    public static function getData( $source )
    {
        $data = array();

        $orders = Order::getListquery();
        
        if ($source == 1) {
            $orders = $orders->where('o.status_id' , '<' , 3)->get();
        }
        else if ($source == 2) {
            $orders = $orders->get();
        }

        foreach ($orders as $index => $order) {
            $step = '';

            if (isset($order->orderStep->step)) {
                $step = $order->orderStep->step->step;
            }

            $date_create = new \DateTime( $order->date_order );
            $date_update = new \DateTime( $order->date_order_step );

            if ($source == 1) {
                $qty_days = $order->days;
            }
            else if ($source == 2) {
                $qty_days = $order->final_day;
            }
            
            $data[$index][0] = $order->order_number;
            $data[$index][1] = $order->customer_name;
            $data[$index][2] = $step;
            $data[$index][3] = $date_update->format( "d/M/Y" );
            $data[$index][4] = $order->order_status;
            $data[$index][5] = $date_create->format( "d/M/Y" );
            $data[$index][6] = $qty_days;
        }

        return $data;
    }
}
