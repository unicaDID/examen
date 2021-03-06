<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\empleado;
use App\detalleEmpleado;
class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados= empleado::with('detalleEmpleado')->get();
        return response()->json($empleados);
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
		try{
			DB::beginTransaction();
				$empleado = new empleado;
				$empleado->nombre = $request ->nombre;
				$empleado->apellido_paterno = $request ->apellido_paterno;
				$empleado->apellido_materno = $request ->apellido_materno;
				$empleado->save();
				$detalleEmpleado=new detalleEmpleado;
				$detalleEmpleado->empleado_id = $empleado->empleado_id;
				$detalleEmpleado->fecha_nacimiento = $request->fecha_nacimiento;
				$detalleEmpleado->ingresos_anuales = $request->ingresos_anuales;
				$detalleEmpleado->save();
		 
				
			DB::commit();
			//return Response::json($response);
			//return $empleado;
			return 'exito';
		}catch(\Exception $e){       
			//DB::rollback();
			$response = array(
					'status' => 'successs',
					'msg' => $e->getMessage(),
				);
			//return 'falla';
			return $e->getMessage();
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return empleado::where('empleado_id',$id)->with('detalleEmpleado')->get();
		$empleado=empleado::with('detalleEmpleado')->where('empleado_id',$id)->get();
        return response()->json($empleado);
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
