<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Exports\UsersExport;
class CargoController extends Controller
{
    public function index()
    {
        return view('cargo');
    }
    public function export()
    {
        return \Excel::download(new UsersExport, 'users.xlsx');
    }
    public function create(Request $request)
    {
        if($request->ajax())
        {
            $rules = array (
                'name' => 'required',
            );
            $validator = Validator::make ( $request->all(), $rules );
            if ($validator->fails ())
                return Response::json ( array (
                        'errors' => $validator->getMessageBag ()->toArray ()
                ) );
            else {
                \QrCode::size(100)->format('svg')->generate($request['name'],'../public/img/'. $request['name'] .'.svg');
                $data = new Cargo;
                $data->name = $request->name;
                $data->cargo_code = $request->cargo_code;
                $data->cargo_status = $request->cargo_status;
                $data->cargo_description = $request->cargo_description;
                $data->official_address = $request->official_address;
                $data->contact_person = $request->contact_person;
                $data->save();

                return response()->json ( $request );
            }
        }
    }

    public function show(Request $request)
    {
        $cargo_code = $request->cargo_code;
        $cargo = Cargo::where('cargo_code', $cargo_code)->pluck('cargo_status');

        return view('cargo_status', compact('cargo', 'cargo_code'));
    }

    public function edit(Request $request,Cargo $cargo)
    {

        \QrCode::size(100)->format('svg')->generate($request['name'],'../public/img/'. $request['name'] .'.svg');
        if($request->ajax())
        {
            $data =  Cargo::find($request->id);
            $data->name = $request->name;
            $data->cargo_code = $request->cargo_code;
            $data->cargo_status = $request->cargo_status;
            $data->cargo_description = $request->cargo_description;
            $data->official_address = $request->official_address;
            $data->contact_person = $request->contact_person;
            $data->save();

            return response()->json ( $request );
        }

    }

    public function destroy(Request $request, Cargo $cargo)
    {
        if($request->ajax())
        {
            Cargo::find ( $request->id )->delete ();
            return response ()->json ();
        }
    }
    public function view(Request $request){
        $cargo = $request->cargo;
        $details = DB::table('cargos')
                ->where('cargo_code',$request->cargo_code)->get();

        return view('cargo_status', compact('details','cargo'));
    }
    public function search(Request $request){

        if($request->ajax()) {

            $data = Cargo::where('name', 'LIKE', $request->name.'%')
                ->get();

            $output = '';

            if (count($data)>0) {

                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';

                foreach ($data as $row){

                    $output .= '<li class="list-group-item">'.$row->name.'</li>';
                }

                $output .= '</ul>';
            }
            else {

                $output .= '<li class="list-group-item">'.'No results'.'</li>';
            }

            return $output;
        }
    }
}
