<?php

namespace App\Http\Controllers\Modulos\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


 
use App\Models\Modulos\Parametrizacion\tbResponsable;
//use App\Models\Modulos\Parametrizacion­\tbIngresoInfo;
use App\Models\Modulos\Parametrizacion\tbIngresoInfo;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Models\Modulos\Parametrizacion\tb_consulta_dia;
use App\Models\Modulos\Parametrizacion\tb_consulta_mes;
use App\Models\Modulos\Parametrizacion\tb_estaciones;
use App\Models\Modulos\Parametrizacion\tb_gastos;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Modulos\Parametrizacion\tb_data_estacion;
use App\Models\Modulos\Parametrizacion\tb_registro_usuario_cabecera;
use App\Models\Modulos\Parametrizacion\tb_registro_usuario_detalle;
use App\Models\Modulos\Parametrizacion\tbUsuarioPerfil;
use Exception;
USE Carbon\Carbon;
use Mail;
use App\Mail\ReservaCallReceived;

use Illuminate\Support\Str;

class Dashboard extends Controller
{
    public function ConsultarDatosEstacionesIdentificacion($identificacion)
    {
        try {
 
                $sql = "select tb1.descripcion ".",count(tb.codigo) codigo"
                        ." FROM tb_data_estaciones tb"
                        ." INNER JOIN tb_estaciones tb1"
                        ." on tb.ruc = tb1.ruc"
                        ." where tb.establecimiento = tb1.establecimiento"
                        ." and  tb.identificacion = '".$identificacion."' "
                        ." group by tb1.descripcion order by tb1.descripcion asc";
                $fecha_reporte =  DB::select($sql);



                 // ->get();
                 $sql2 = "select  tb2.descripcion, tb1.ruc, count(tb.identificacion) as total_registro
                    from tb_registro_usuario_cabecera tb
                    inner join tb_data_estaciones tb1 
                    on tb.identificacion = tb1.identificacion
                    inner join tb_estaciones tb2
                    on tb1.ruc = tb2.ruc
                    where tb1.establecimiento = tb2.establecimiento"
                     ." and  tb.identificacion = '".$identificacion."' "
                    ." group by tb2.descripcion, tb1.ruc order by tb2.descripcion asc";

                    $fecha_reporte_totales_registro =  DB::select($sql2);

               
                     
            return response()->json([
                'TotalesEstaciones' => $fecha_reporte,
                'fecha_reporte_totales_registro' => $fecha_reporte_totales_registro,
                 
                // 'Vendedor' => $vendedor,

            ], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function ConsultarDatosEstaciones($fechadesde, $fechahasta)
    {
        try {

            $desde = date($fechadesde);
            $hasta = date($fechahasta);
            $mes = date("m", strtotime($fechadesde));
            $anio = date("Y", strtotime($fechadesde));
            
    
                # code...
                // $fecha_reporte= tb_data_estacion:: DatosEstacion()
                // ->whereBetween('created_at', [$desde, $hasta])
              
             
               
                // ->get();
                $sql = "SELECT tb1.descripcion ".",count(tb.codigo) codigo"
                        ." FROM tb_data_estaciones tb"
                        ." INNER JOIN tb_estaciones tb1"
                        ." on tb.ruc = tb1.ruc"
                        ." where tb.establecimiento = tb1.establecimiento"
                        ." and convert(tb.created_at,date) between '".$fechadesde."' and '".$fechahasta."' "
                        ." group by tb1.descripcion order by tb1.descripcion asc";
                $fecha_reporte =  DB::select($sql);



                 // ->get();
                 $sql2 = "select  tb2.descripcion, tb1.ruc, count(tb.identificacion) as total_registro
                    from tb_registro_usuario_cabecera tb
                    inner join tb_data_estaciones tb1 
                    on tb.identificacion = tb1.identificacion
                    inner join tb_estaciones tb2
                    on tb1.ruc = tb2.ruc
                    where tb1.establecimiento = tb2.establecimiento"
                     ." and convert(tb.created_at,date) between '".$fechadesde."' and '".$fechahasta."' "
                    ." group by tb2.descripcion, tb1.ruc order by tb2.descripcion asc";

                    $fecha_reporte_totales_registro =  DB::select($sql2);

               
                     
            return response()->json([
                'TotalesEstaciones' => $fecha_reporte,
                'fecha_reporte_totales_registro' => $fecha_reporte_totales_registro,
                 
                // 'Vendedor' => $vendedor,

            ], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function RecoveryCuenta()
    {
        try {
            $fechaActual = Carbon::now();
            
           // $resultado = tb_data_estacion::where("identificacion",$cedula)->first();
           $resultado_usuario = tb_registro_usuario_cabecera::where("identificacion",'0930066691')->first();

           $password = Str::random();

           
           if ($resultado_usuario != null) {
                   # code...
               $crear =  tb_registro_usuario_cabecera::UpdateOrCreate(
                   [
                       'id' => $resultado_usuario->id,
                   ],
                   [
                       'idIdentificacion' => $resultado_usuario->idIdentificacion,
                       'identificacion' => $resultado_usuario->identificacion,
                       'nombre' => $resultado_usuario->nombre,
                       'telefono' => $resultado_usuario->telefono,
                       'mail' => $resultado_usuario->mail,
                       'password' => $password,
                       'password_verificar' => $password,
                       'terminos_1' => $resultado_usuario->terminos_1,
                       'terminos_2' => $resultado_usuario->terminos_2,
                       'fecha_registro' =>  $fechaActual,
                       //'usuario_modificacion' => $user->id,
                   ]
   
               );

           $resultado_usuario_enviar = tb_registro_usuario_cabecera::where("identificacion",'0930066691')->first();
           $subject = "COPEDESA - RECUPERACION DE CUENTA";
           $for = "carlosrami1989@gmail.com";
          // $for = "tic@pizzalibregye.com";
           
           Mail::to($for)
           ->send(new ReservaCallReceived($resultado_usuario_enviar,$subject));

               return response()->json(['data' => $resultado_usuario->identificacion,
               'mensaje' =>"Contraseña enviada al correo con éxito",
           'verificacion' => true], 200); 
        }else{
           return response()->json(['mensaje' => "El numero de identificación ya esta registrado en nuestras bases",
       'verificacion' => false], 200);  
        }

            
        } catch (Exception $e) {
            return response()->json(['data' => $e], 200);
            //throw $th;
        }
    }
    public function ConsultarCedulaRecovery($cedula)
    {
        try {

            
           // $resultado = tb_data_estacion::where("identificacion",$cedula)->first();
            $resultado = tb_registro_usuario_cabecera::where("identificacion",$cedula)->first();
            if ($resultado != null) {

                return response()->json(['data' => $resultado,
                'mensaje' =>"Registro encontrado con éxito",
            'verificacion' => true], 200); 
            }else{
                return response()->json(['mensaje' => "El numero de identificación no esta registrado en nuestras bases",
                'verificacion' => false], 200);  
            }
           

            
        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function PostActualizarContrasena(Request $request)
    {

        try {
            //code.
         //   $user = Auth::user();
         $fechaActual = Carbon::now();
        
       
         
            # code...
            $resultado_usuario = tb_registro_usuario_cabecera::where("identificacion",$request->identificacion)->first();
 
            if ($resultado_usuario != null) {
                    # code...
                $crear =  tb_registro_usuario_cabecera::UpdateOrCreate(
                    [
                        'id' => $resultado_usuario->id,
                    ],
                    [
                        'idIdentificacion' => $resultado_usuario->idIdentificacion,
                        'identificacion' => $resultado_usuario->identificacion,
                        'nombre' => $resultado_usuario->nombre,
                        'telefono' => $resultado_usuario->telefono,
                        'mail' => $resultado_usuario->mail,
                        'password' => $request->Password,
                        'password_verificar' => $request->ConfirmPassword,
                        'terminos_1' => $resultado_usuario->terminos_1,
                        'terminos_2' => $resultado_usuario->terminos_2,
                        'fecha_registro' =>  $fechaActual,
                        //'usuario_modificacion' => $user->id,
                    ]
    
                );
                return response()->json(['data' => $resultado_usuario->identificacion,
                'mensaje' =>"Contraseña Actualizada con éxito",
            'verificacion' => true], 200); 
           
            


            
           
            

          //  $wasCreated = $crear->wasRecentlyCreated;
         }else{
            return response()->json(['mensaje' => "El numero de identificación ya esta registrado en nuestras bases",
        'verificacion' => false], 200);  
         }
             
           
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage(),'verificacion' => false], 500);
            //throw $th;
        }
    }
    public function PostActualizarUsuario(Request $request)
    {

        try {
            //code.
         //   $user = Auth::user();
         $fechaActual = Carbon::now();
        
       
         
            # code...
            $resultado_usuario = tb_registro_usuario_cabecera::where("identificacion",$request->identificacion)->first();
 
            if ($resultado_usuario != null) {
                    # code...
                $crear =  tb_registro_usuario_cabecera::UpdateOrCreate(
                    [
                        'id' => $resultado_usuario->id,
                    ],
                    [
                        'idIdentificacion' => $resultado_usuario->idIdentificacion,
                        'identificacion' => $resultado_usuario->identificacion,
                        'nombre' => $resultado_usuario->nombre,
                        'telefono' => $request->telefono,
                        'mail' => $request->mail,
                        'password' => $resultado_usuario->password,
                        'password_verificar' => $resultado_usuario->password_verificar,
                        'terminos_1' => $resultado_usuario->terminos_1,
                        'terminos_2' => $resultado_usuario->terminos_2,
                        'fecha_registro' =>  $fechaActual,
                        //'usuario_modificacion' => $user->id,
                    ]
    
                );
                return response()->json(['data' => $resultado_usuario->identificacion,
                'mensaje' =>"Registro Actualizado con éxito",
            'verificacion' => true], 200); 
           
            


            
           
            

          //  $wasCreated = $crear->wasRecentlyCreated;
         }else{
            return response()->json(['mensaje' => "El numero de identificación ya esta registrado en nuestras bases",
        'verificacion' => false], 200);  
         }
            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
          




           
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage(),'verificacion' => false], 500);
            //throw $th;
        }
    }
    public function InsertarCodigosCodigos (Request $request)
    {
        try {
            $fechaActual = Carbon::now();
            
           $resultado = tb_data_estacion::where("identificacion",$request->identificacion)->get();
           // $resultado = tb_data_estacion::where("identificacion",$request->identificacion)->where("password",$request->password)->first();
            if ($resultado !=null ) {

                foreach ($resultado as $key => $value) {
                    # code...
                    $crear =  tb_registro_usuario_detalle::UpdateOrCreate(
                        [
                            'id' =>  $value->id_api,
                        ],
                        [
                            'identificacion' => $value->identificacion,
                            'establecimiento' => $value->establecimiento,
                            'secuencial' => $value->secuencial,
                            'codigo' => $value->codigo,
                             'fecha_registro' => $fechaActual,
                           
                        ]
        
                    );
                }
                # code...
               
                return response()->json(['data' => $resultado,
                'mensaje' => "Datos grabados con éxito",
            'verificacion' => true], 200); 
            }else{
                return response()->json(['data' => "",
                'mensaje' => "No hay datos para validar",
                'verificacion' => false], 200); 
            }
            

            
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function ConsultarCodigos (Request $request)
    {
        try {

            
           $resultado = tb_data_estacion::where("identificacion",$request->identificacion)->get();
           // $resultado = tb_data_estacion::where("identificacion",$request->identificacion)->where("password",$request->password)->first();
            // if ($resultado !=null ) {

            //     # code...
            //     return response()->json(['data' => $resultado,
            //     'mensaje' => "Validacion de Datos Correcto",
            // 'verificacion' => true], 200); 
            // }else{
            //     return response()->json(['data' => "",
            //     'mensaje' => "No hay datos para validar",
            //     'verificacion' => false], 200); 
            // }
            

            return response()->json(['data' => $resultado,
                'mensaje' => "Validacion de Datos Correcto",
            'verificacion' => true], 200); 

            
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function ConsultarInicioSession(Request $request)
    {
        try {

            
           // $resultado = tb_data_estacion::where("identificacion",$cedula)->first();
            $resultado = tb_registro_usuario_cabecera::where("identificacion",$request->identificacion)->where("password",$request->password)->first();
            if ($resultado !=null ) {
                # code...
                return response()->json(['data' => $resultado,
                'mensaje' => "Registro realizado con éxito",
            'verificacion' => true], 200); 
            }else{
                return response()->json(['data' => "",
                'mensaje' => "Usuario/Contraseña Incorrectos",
                'verificacion' => false], 200); 
            }
            

            
        } catch (Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function PostValidarUsuario(Request $request)
    {

        try {
            //code.
         //   $user = Auth::user();
         $fechaActual = Carbon::now();
        
         $resultado = tb_data_estacion::where("identificacion",$request->identificacion)->first();
         if ($resultado != null) {
            # code...
            $resultado_usuario = tb_registro_usuario_cabecera::where("identificacion",$request->identificacion)->first();

            if ($resultado_usuario == null) {
                # code...
                $crear =  tb_registro_usuario_cabecera::UpdateOrCreate(
                    [
                        'id' => 0,
                    ],
                    [
                        'idIdentificacion' => $request->idIdentificacion,
                        'identificacion' => $request->identificacion,
                        'nombre' => $request->nombres,
                        'telefono' => $request->telefono,
                        'mail' => $request->mail,
                        'password' => $request->Password,
                        'password_verificar' => $request->ConfirmPassword,
                        'terminos_1' => $request->terminos,
                        'terminos_2' => $request->terminos,
                        'fecha_registro' =>  $fechaActual,
                        //'usuario_modificacion' => $user->id,
                    ]
    
                );
                return response()->json(['data' => "Registro realizado con éxito",
            'verificacion' => true], 200); 
           
            }else{
                return response()->json(['data' => "El numero de identificación ya esta registrado en nuestras bases",
            'verificacion' => false], 200);    
            }


            
           
            

          //  $wasCreated = $crear->wasRecentlyCreated;
         }else{
            return response()->json(['data' => "El numero de identificación ya esta registrado en nuestras bases",
        'verificacion' => false], 200);  
         }
            // $var = tbIngresoInfo::All();
            //return  response()->json(['data' =>$user], 200);
          




           
        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage(),'verificacion' => false], 500);
            //throw $th;
        }
    }

    public function ConsultarUsuarioBase($cedula)
    {
        try {

            
           // $resultado = tb_data_estacion::where("identificacion",$cedula)->first();
            $resultado = tb_data_estacion::where("identificacion",$cedula)->first();

           

            return response()->json(['data' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function ConsultarUsuario()
    {
        try {
            $user = Auth::user();


            return response()->json(['user' => $user], 200);

        } catch (Exception $e) {
            return response()->json(['msj' => $e->getMessage()], 500);
        }
    }
    public function User()
    {
        try {


            $resultado = User::All();


            return response()->json(['data' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    //
    public function IncipSession($id)
    {
        try {


            $resultado = User::where("id", $id)->get();


            return response()->json(['data' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }
    public function ConsultarInformacion()
    {
        try {


            $resultado = DB::select("call buscarDatos");


            return response()->json(['data' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ConsultarDatos()
    {

        try {
            $fecha = date('Y-m-d');
            $resultado = tbResponsable::all();

            $kilos_dia = tbIngresoInfo::whereDate('created_at', $fecha)->get();
            $kilos_total = tbIngresoInfo::all();





            return response()->json([
                'toal_registro' => $resultado->count(),
                'kilos_dia' => $kilos_dia->sum('peso'),
                'kilos_total' => $kilos_total->sum('peso')
            ], 200);
        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ConsultarCalender($id)
    {
        try {


            $resultado = User::where("id", $id)->get();


            return response()->json(['data' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ConsultarMes($estacion, $mes, $anio)
    {
        try {

            if ($mes == 99) {
                # code...
                $resultado = tb_consulta_mes::where("estacion", $estacion)
                    ->where("anio", 2024)
                    ->get()->groupBy('mes');
            } else {

                $resultado = tb_consulta_mes::where("estacion", $estacion)->
                    where("mes", $mes)->
                    where("anio", $anio)
                    ->get();
            }

            // $resultado =tb_consulta_mes::where("estacion",$estacion)->
            // where("mes",$mes)
            // ->get()->groupBy('mes');



            return response()->json(['Resp' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ConsultarDia($estacion)
    {
        try {



            $resultado = tb_consulta_dia::where("estacion", $estacion)->get()->groupBy('dia');


            return response()->json(['Resp' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ConsultarEstaciones()
    {
        try {



            $resultado = tb_estaciones::all();


            return response()->json(['Resp' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ConsultarGastosEDS($estacion, $mes, $anio)
    {
        try {

            if ($estacion == 0) {
                $resultado = tb_gastos::where("mes", $mes)
                    ->where("anio", $anio)
                    ->get();
            } else {
                $resultado = tb_gastos::where("id_estacion", $estacion)
                    ->where("mes", $mes)
                    ->where("anio", $anio)
                    ->get();
            }




            return response()->json(['Resp' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function ConsultarDiaPorEstacion($fecha)
    {
        try {

            $fecha_actual = date($fecha);
            //sumo 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "+ 1 days"));
            //resto 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "- 1 days"));

            # code...
            $resultado = tb_consulta_dia::selectRaw("dia,SUM(total) as total_dolares")
            ->selectRaw("SUM(galones) as galones")
            ->where('dia', '=', $fecha_actual)
            ->DatosEstacion()    
            ->groupBy('estacion','dia')
            ->orderby('total_dolares','desc')
            ->get();

            // $resultado =tb_consulta_mes::where("estacion",$estacion)->
            // where("mes",$mes)
            // ->get()->groupBy('mes');



            return response()->json(['Resp' => $resultado], 200);
        } catch (Exception $e) {
            return response()->json(['Resp' => $e->getMessage()], 500);
            //throw $th;
        }
    }

    public function createreporteExcel(Request $request){

        //return  response()->json(['data' =>$request->all()], 200);
        try {

            $fecha_actual = date( $request->fecha);
            //sumo 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "+ 1 days"));
            //resto 1 día
            //echo date("d-m-Y", strtotime($fecha_actual . "- 1 days"));

            # code...
            $resultado = tb_consulta_dia::selectRaw("dia,SUM(total) as total_dolares")
            ->selectRaw("SUM(galones) as galones")
            ->where('dia', '=', $fecha_actual)
            ->DatosEstacion()    
            ->groupBy('estacion','dia')
            ->orderby('total_dolares','desc')
            ->get();
 
    
            $fecha = date('y-m-d');
    
         
            $nameExcel = 'Reporte Por Estacion Efectivo-'.$fecha. '.xls';
           //return  response()->json(['data' =>$resultado], 200);
          
            return Excel::download(new UsersExport($resultado,'Reporte General de Desechos'), 
            $nameExcel, header("Content-Type: application/vnd.ms-excel;"));
    
        
    
           
     
        } catch (Exception $e) {
            return  response()->json(['data' => $e->getMessage()], 500);
            //throw $th;
        }
    }

}