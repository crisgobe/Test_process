<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\User;
use App\UserType;
use App\UserStatus;
use App\UserImage;
use PDF;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->id() != 1) {
            return redirect('home')->with('message' , 'No tiene acceso');
        }

        $users       = User::get();
        $user_types  = UserType::where('id' , '>' , 1)->get();
        $user_status = UserStatus::get();

        // echo "<pre/>"; print_r($user_status); exit();

        return view('admin/users/list')
            ->with('users' , $users)
            ->with('user_types' , $user_types)
            ->with('user_status' , $user_status)
        ;
    }

    public function tableUsersList( Request $request )
    {
        $fiters = false;

        $data = $request->all();

        $columns = array(
            0 => 'name' ,
            1 => 'email'
        );

        // $db = new DB(config('app.manufacturerDB'));

        $users_query = User::query();

        if (!empty($request['columns'][0]['search']['value'])) {
            $filter         = $request['columns'][0]['search']['value'];
            $users_query = $users_query->where("name" , "LIKE" , "%$filter%");
            $fiters         = true;
        }

        if (!empty($request['columns'][1]['search']['value'])) {
            $filter         = $request['columns'][1]['search']['value'];
            $users_query = $users_query->where("email" , "LIKE" , "%$filter%");
            $fiters         = true;
        }

        if (!empty($request['columns'][2]['search']['value'])) {
            $filter         = $request['columns'][2]['search']['value'];
            $users_query = $users_query->where("user_types_id" , $filter);
            $fiters         = true;
        }

        if (!empty($request['columns'][3]['search']['value'])) {
            $filter         = $request['columns'][3]['search']['value'];
            $users_query = $users_query->where("status_id" , $filter);
            $fiters         = true;
        }

        $users_query = $users_query->orderBy(
            $columns[$request['order'][0]['column']] ,
            $request['order'][0]['dir']
        );

        $users = $users_query->get();

        $iTotalRecords  = count($users);
        $iDisplayLength = intval($request['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart  = intval($request['start']);
        $sEcho          = intval($request['draw']);

        $records         = array();
        $records["data"] = array();

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        for ($i = $iDisplayStart; $i < $end; $i++) {
            $records["data"][] = array(
                $users[$i]->name ,
                $users[$i]->email ,
                $users[$i]->userTypes->type ,
                $users[$i]->status->status ,
                '<a href="users/' . $users[$i]->id . '" class="btn green-sharp btn-outline btn-block btn-sm">
                    <i class="fa fa-search"></i> 
                    Detalles
                </a>'
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
        print_r('expressionssffdd');
        exit();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $check_email = User::where('email' , $data['email'])->get();

        if (count( $check_email ) > 0) {
            return response()->json([
                'type' => 1 ,
                'msg' => 'El usuario con correo electrónico "' . $data['email'] . '" ya existe.'
            ] , 301);
        }

        // echo "<pre/>"; print_r($data); exit();

        $data_user = array(
            'name'          => $data['name_user'] ,
            'email'         => $data['email'] ,
            'user_types_id' => $data['user_types_id'] ,
            'status_id'     => '1' ,
            'password'      => bcrypt($data['password'])
        );

        User::create( $data_user );

        return response()->json(['msg' => 'Usuario creado exitosamente!'] , 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        if (auth()->id() != $id && auth()->id() != 1) {
            return redirect('home')->with('message' , 'No tiene acceso');
        }

        $user       = User::find($id);
        $user_types = UserType::where('id' , '>' , 1)->get();

        $button_status = 'green';

        if ($user->status_id == 2) {
            $button_status = 'red';
        }

        return view('admin/users/profile')
            ->with('user' , $user)
            ->with('status_color' , $button_status)
            ->with('user_types' , $user_types)
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

    public function changeStatus( Request $request , $id )
    {
        $data    = $request->all();
        $user = User::find( $id );

        if ($user['status_id'] == $data['status_id']) {
            return redirect()
                ->back()
                ->with('message_standar' , 'No se realizaron cambios en el usuario.')
            ;
        }

        $user['status_id'] = $data['status_id'];

        $user->save();

        return redirect()
            ->back()
            ->with('message' , 'Usuario modificado exitosamente!')
        ;
    }

    public function changeImage( Request $request , $id )
    {
        $data = $request->file();
        $item = User::find($id);
        $file = $data['img_user'];
        $fileO = fopen($file,"r");
        $contents = fread($fileO,filesize($file));
        fclose($fileO);
        $image = new UserImage;

        $image->image = $contents;
        $image->save();

        $item->images_id = $image->id;

        $item->save();

        return redirect()
            ->back()
            ->with('message' , 'Usuario modificado exitosamente!')
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
        $data = $request->all();
        $user = User::find( $id );

        $email = User::where('email' , $data['email'])
            ->where('id' , '!=' , $id)
            ->first()
        ;

        if (count($email) > 0) {
            return response()->json([
                'type' => 1 ,
                'msg' => 'El correo electrónico "' . $data['email'] . '" ya pertenece a otro usuario.'
            ] , 301);
        }

        if ($data['password_p'] == '') {
            $check_user = User::where('email' , $data['email'])
                ->where('name' , $data['name'])
                ->where('user_types_id' , $data['user_types_id'])
                ->where('id' , $id)
                ->first()
            ;

            if (count($check_user) > 0) {
                return response()->json([
                    'type' => 2 ,
                    'msg' => 'No se realizaron cambios en el usuario.'
                ] , 301);
            }
        }

        $user['email']        = $data['email'];
        $user['name']         = $data['name'];
        $user['user_types_id'] = $data['user_types_id'];

        if ($data['password_p'] != '') {
            $user['password'] = bcrypt($data['password_p']);
        }

        $user->save();

        return response()->json(['msg' => 'Usuario modificado exitosamente!'] , 200);
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

    public function pdfAllUsers()
    {
        $users  = User::get();

        $pdf = PDF::loadView('pdfs.users.list' , [
            'users'  => $users
        ])->setPaper('a4');

        return $pdf->stream('users.pdf');
    }

    public function excelAllUsers()
    {
        Excel::create("Usuarios", function($excel)
        {
            $data = self::getData();

            $excel->getDefaultStyle()
                ->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
            ;

            $title = substr('Lista de Usuarios' , 0 , 30);

            $excel->sheet($title , function( $sheet ) use ( $data )
            {
                $sheet->mergeCells('A1:E1');
                $sheet->mergeCells('A2:E2');
                $sheet->mergeCells('A3:E3');
                $sheet->mergeCells('A4:E4');
                $sheet->mergeCells('A5:E5');

                $sheet->row(2 , ['TRACKING SYSTEM']);
                $sheet->row(3 , ['Listado de Usuarios']);
                $sheet->row(4 , ['Fecha: ' . date("d / m / Y")]);

                $sheet->cell('A6' , 'Nombre');
                $sheet->cell('B6' , 'Correo Electrónico');
                $sheet->cell('C6' , 'Cargo');
                $sheet->cell('D6' , 'Tipo de Usuario');
                $sheet->cell('E6' , 'Estado');

                $sheet->cell('A6:E6' , function($cells)
                {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($data , null , 'A7' , true , false);

                $sheet->cell('A2:E4' , function($cells)
                {
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
            });
            
        })->download("xlsx");
    }

    public static function getData()
    {
        $data = array();

        $users = User::get();

        foreach ($users as $index => $user) {
            $data[$index][0] = $user->name;
            $data[$index][1] = $user->email;
            $data[$index][2] = $user->position->description;
            $data[$index][3] = $user->area->description;
            $data[$index][4] = $user->status->status;
        }

        return $data;
    }
}
