<?php
namespace Soft\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Notifications\notify;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Soft\Http\Requests;

use Soft\Notifications\VentaCreated;


use Soft\Producto;
use Soft\Venta;
use Soft\Transaction;
use Soft\User;
use Soft\Mercadopago;
use Soft\Pago;
use Soft\AccesoWeb;
use Soft\AccesoEmail;
use Soft\Servicio;
use Soft\Punto;

use Notification;
use DataTables;
use Debugbar;
use Alert;
use Session;
use Redirect;
use Storage;
use DB;
use Image;
use Auth;
use Flash;
use Toastr;
use Carbon\Carbon;
use Exception;
use MP;
use Input;
use Hash;
use View;




class VentaController extends AdminBaseController
{

    public function __construct()
    {
        /*si no existe mi session cart , esntonces la creo con put y creo
        un array para almacenar los items*/
        if(!\Session::has('ventas')) \Session::put('ventas', array());
        if(!\Session::has('newventas')) \Session::put('newventas', array());
        //para cliente ya no es un array ya que almaceno 1 solo objeto
        if(!\Session::has('cliente')) \Session::put('cliente');

        parent::__construct();
    }



/*------------------------------PANEL ADMIN--------------------------------------*/

//----------------------------------Generar Nueva Venta------------------------//
      public function CartCount(){
        /*obtengo mi variable de session cart que cree y la almaceno en $cart */
        $cart = \Session::get('ventas');
        //cuenta los item que hay en la session
        $cartcount =  count($cart);

        return $cartcount;
    }

   
    public function show(Request $request)
    {
        if ($request->ajax()) {
        /*obtengo mi variable de session cart que cree y la almaceno en $cart */
        $cart = \Session::get('ventas');
        //llama a la funcion CartTotal
        $cartcount = $this->CartCount();
        //llama a la funcion total
        $total = $this->total();
        return response([$total,$cartcount,$cart]);
          }

        
    }


    //agregar item
    public function add(Request $request,$id)
    {
      
       //si es una peticion ajax
        if ($request->ajax()) {
            
        $itemadd  = producto::find($id);
        $cart = \Session::get('ventas');
        $itemadd->quantity = 1;

        $cart[] = $itemadd;
        \Session::put('ventas', $cart);

         /*obtengo mi variable de session cart que cree y la almaceno en $cart */
        $cart = \Session::get('ventas');
        //llama a la funcion CartTotal
        $cartcount = $this->CartCount();
      //llama a la funcion total
        $total = $this->total();

            return response([$total,$cartcount,$cart]);
        }

     }

     // Delete item y client
    public function delete(Request $request,$id)
    {
       

      
      //si es una peticion ajax
        if ($request->ajax()) {
            
        $item  = producto::find($id);
        $cart = \Session::get('ventas');
        $newcart = [];


        //reccorro todos los items del carrito
        //key es la posicion del array
        $i=0;
        foreach ($cart as $key => $car) {
          
          //si el id del producto es igual al id que mandamos que me borre ese prodcuto del carrito
       if ($car->id == $id) {
         unset($cart[$key]);
       }else{
         //los paso a una nueva session para que queden acomodados y no tire error en el JS
        $newcart[$i] = $cart[$key];
       $i = $i + 1;
       }
     }
        

        \Session::put('ventas', $newcart);



         /*obtengo mi variable de session cart que cree y la almaceno en $cart */
        $newarray = \Session::get('ventas');
        //llama a la funcion CartTotal
        $cartcount = $this->CartCount();
      //llama a la funcion total
        $total = $this->total();

            return response([$total,$cartcount,$newarray]);
        }


    }


     // Update item
    public function update(Request $request,$id, $cantidad)
    {
       

       if ($request->ajax()) {
        $item  = producto::find($id);
        $cart = \Session::get('ventas');
        foreach ($cart as $key => $car) {
          if ($car->id == $id) {
            $cart[$key]->quantity = $cantidad;
          }       
        }
       
        \Session::put('ventas', $cart);

       /*obtengo mi variable de session cart que cree y la almaceno en $cart */
        $cart = \Session::get('ventas');
        //llama a la funcion CartTotal
        $cartcount = $this->CartCount();
      //llama a la funcion total
        $total = $this->total();
       
       return response([$total,$cartcount,$cart]);
       }
    }


    //limpiar carrito y cliente
     public function trash()
    {
        \Session::forget('ventas');
        \Session::forget('cliente');
        
        return Redirect::back();
    }


    //total del carrito
    private function total()
    {
        $cart = \Session::get('ventas');
        $total = 0;
        foreach($cart as $item){
            $total += $item->precioventa * $item->quantity;
        }
        return $total;
    }

    public function NuevaVenta(Request $Request ){
  
        $productos = producto::all();
        $users = User::all();
        return view('admin.venta.index', compact('productos','users'));

    }


public function NuevaVentaStore(Request $Request ){
    
       $user = User::find($Request['iduser']);

        //traigo el tipo de pago y si es efectivo que se guarde como pagado en otro caso 
        //que se guarde como pendiente
        $tipo_pago=$Request['tipo_pago'];
        if ($tipo_pago == "Efectivo") 
        {
            $tipo_pago = "pagado";
        }else{  
            $tipo_pago="pendiente";            
        }

        //genero una venta que estara relacinada con los productos en las transacciones
        $venta = new Venta();
        $venta->user_id       = $user->id;
        $venta->pago_tipo     = $Request['tipo_pago'];
        $venta->pagoefectivo     = $Request['efectivo'];
        $venta->pagotargeta     = $Request['targeta'];
        $venta->total         = $Request['total_venta'];
        $venta->realizada = "local";
        //$venta->comentario  =
        $venta->status = $tipo_pago;
        $venta->save();



        //traigo todos los productos de la session  del usuario 
        $cart = \Session::get('ventas');
        //los recorro
        foreach ($cart as $item) {
            //crea una nueva transaccion
            $transaction  = new Transaction();
            //alamacena la transaccion
            $transaction->venta_id    = $venta->id;
            $transaction->producto_id  = $item->id;
            $transaction->user        = $user->email;
            $transaction->cantidad    = $item->quantity;
            $transaction->total_price = $item->precioventa * $item->quantity;
            //guardo la transaccion
            $transaction->save();

            //descontar stock en la tabla producto
            $producto = producto::find($item->id);
            $producto->stockactual = $producto->stockactual - $item->quantity;
            $producto->save();
        }   




       
        Alert::success('Mensaje existoso', 'Venta Creada Con Exito');
         return Redirect::to('listar-ventas');

    }



//----------------------------------Generar Nueva Venta------------------------//








//----------------------------------Listar Ventas------------------------//
  public function listarVentas(request $request){


         $ventas=venta::paginate(50);
         $transactions = transaction::all();

         /*buscador*/
        $fechai=$request->input('fecha_inicio');
        $fechaf=$request->input('fecha_final');
        if (!empty($fechai) and !empty($fechaf)) {
            //entonces me busque de usu_nombre a el nombre que le pasamos atraves de $usu_nombre
            $ventas = venta::where('created_at', '>=' , $fechai)->where('created_at', '<=', $fechaf)->paginate(50);
        }
        /*buscador*/

         $link = "listar ventas";


   
        return view('admin.venta.listar.index',compact('link','ventas','transactions'));
    }


     public function listarVentasDatatable(Request $request)
    {       

      //en el with se manda la relacion que esta en el modelo , como quiero obtener las categorias , no tengo que hacer refemcia a la tabla en la DB , si no que tengo que hacer referencia a la funcion que esta en el modelo , en nuestro caso categorias para las categoiras de los post
    $list= Venta::with('user')->get();
       return datatables()->of($list)->toJson();
    }
//----------------------------------Listar Ventas------------------------//









//----------------------------------Cambiar Status------------------------//
    public function cambiarStatusVenta(Request $Request , $id){
        //el descuento del stock lo realiza cuando finaliza la compra
        $transactions = Transaction::where('venta_id','=',$id)->get();
        $venta=venta::find($id);
        //$cliente=Cliente::find($venta->cliente_id);
        $user = User::find($venta->user_id);
        $punto = Punto::first();


          //si la accion es pagado  y se encuentra en estado cancelado que se sumen los puntos y descuente el stock
        if( $Request['pago'] == "pagado"  and  $venta->status == "cancelado" ){
         foreach ($transactions as $transaction) {
           //volve  stock en la tabla producto
            $producto = producto::find($transaction->producto_id);
            $producto->stockactual = $producto->stockactual - $transaction->cantidad;
            $producto->save(); 
            //cambiamos el estado de la venta
            $venta->status=$Request['pago'];
            $venta->save();}

            //sumar puntos
            if($user != null){
            $user->puntos= ($user->puntos + (($punto->porcentaje*$venta->total)/100));
            $user->save();}
        }





         //si la accion es pagado  y se encuentra en estado pendiente que se sumen los puntos 
        if( $Request['pago'] == "pagado"  and  $venta->status == "pendiente" ){
         foreach ($transactions as $transaction) {
            //cambiamos el estado de la venta
            $venta->status=$Request['pago'];
            $venta->save();}

            //sumar puntos
            if($user != null){
            $user->puntos= ($user->puntos + (($punto->porcentaje*$venta->total)/100));
            $user->save();}
        }
       
        




        //si la accion es cancelado  y se encuentra en estado pagado que  resten  los puntos y restaure el stock
        if( $Request['pago'] == "cancelado"  and  $venta->status == "pagado" ){
         foreach ($transactions as $transaction) {
           //volve  stock en la tabla producto
            $producto = producto::find($transaction->producto_id);
            $producto->stockactual = $producto->stockactual + $transaction->cantidad;
            $producto->save(); 
            //cambiamos el estado de la venta
            $venta->status=$Request['pago'];
            $venta->save();}

            //descontar puntos
            if($user != null){
            $user->puntos= ($user->puntos - (($punto->porcentaje*$venta->total)/100));
            $user->save();}
        }




        //si la accion es cancelado  y se encuentra en estado pendiente que  no sume nada y se recuepre el stock
        if( $Request['pago'] == "cancelado"  and  $venta->status == "pendiente" ){
          //si la venta se realizo atraves de los puntos que se restaure los puntos tambien
          if ($venta->pago_tipo == "puntos") {
            foreach ($transactions as $transaction) {
               $producto = producto::find($transaction->producto_id);
                //restauramos lo puntos
                $user->puntos= ($user->puntos + $producto->puntos );
                $user->save();

                //volve  stock en la tabla producto
                $producto->stockactual = $producto->stockactual + $transaction->cantidad;
                $producto->save(); 
              }

                //cambiamos el estado de la venta
                $venta->status=$Request['pago'];
                $venta->save();


           }else{
            foreach ($transactions as $transaction) {
            //volve  stock en la tabla producto
            $producto = producto::find($transaction->producto_id);
            $producto->stockactual = $producto->stockactual + $transaction->cantidad;
            $producto->save(); 
           
              }
              //cambiamos el estado de la venta
            $venta->status=$Request['pago'];
            $venta->save();
           }
         
        }






        //si la accion es pendiente  y se encuentra en estado pagado que  resten  los puntos 
        if( $Request['pago'] == "pendiente"  and  $venta->status == "pagado" ){
         foreach ($transactions as $transaction) {
            //cambiamos el estado de la venta
            $venta->status=$Request['pago'];
            $venta->save();}

            //descontar puntos
            if($user != null){
            $user->puntos= ($user->puntos - (($punto->porcentaje*$venta->total)/100));
            $user->save();}
        }






        //si la accion es pendiente  y se encuentra en estado cancelado que  no sume nada y se descuente el stock
        if( $Request['pago'] == "pendiente"  and  $venta->status == "cancelado" ){
         foreach ($transactions as $transaction) {
            //volve  stock en la tabla producto
            $producto = producto::find($transaction->producto_id);
            $producto->stockactual = $producto->stockactual - $transaction->cantidad;
            $producto->save();
            //cambiamos el estado de la venta
            $venta->status=$Request['pago'];
            $venta->save();}
        }





        return Redirect::back();

    }

   
//----------------------------------Cambiar Status------------------------//












   



//----------------------------------enviamos la factura por correo------------------------//
    public function EnviarFacturaEmail(Request $Request,$idventa ){
  
            
        $id = $idventa;
        $transactions = transaction::all();
        $data = $ventas=venta::all();
        $date = date('Y-m-d');
        $vistaurl="admin.venta.venta-detalle-pdf";
        $logo = DB::table('logos')->first();
        $view =  \View::make($vistaurl, compact('data','logo', 'date', 'transactions','id'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

       


   try{
         $vent = Venta::find($id);
         $asunto = "Gracias por su Compra en sharkestudio - Factura de la compra";
         $user = User::find($vent->user_id);
         

        \Illuminate\Support\Facades\Mail::send('emails.invoice',['user'=>$user,'asunto'=>$asunto,] , function($message) use ($user,$asunto,$pdf)
       {
           //remitente
           $message->from('ventas@sharkestudio.com','sharkestudio','administrador');
         
           //asunto
           $message->subject($asunto);
 
           //receptor
           $message->to($user->email, $user->nombre);

           //enviamos el pdf
           $message->attachData($pdf->output(), "factura.pdf");

 
       });

          //en caso de una exepcion
    }catch(\Swift_TransportException $e){
             flash('no se pudo enviar la factura al correo devido a problemas con la conexion.')->error();
        }


        Alert::success('Mensaje existoso', 'Factura Enviada Con Exito');
        return Redirect::back();

    }
//----------------------------------enviamos la factura por correo------------------------//








//----------------------------------Generamos el PDF------------------------//
    public function detalleVentaPdf($tipo,$id){
        $vistaurl="admin.venta.venta-detalle-pdf";
        $ventas=venta::find($id);
        $transactions = transaction::all();
         $logo = DB::table('logos')->first();
     return $this->crearPDF($logo,$ventas, $transactions , $vistaurl,$tipo,$id);
     
    }

    public function crearPDF($logo,$ventas, $transactions , $vistaurl,$tipo ,$id){
        
        $date = date('Y-m-d');
        $view =  View::make($vistaurl, compact('ventas','logo', 'date', 'transactions','id'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);


        
       if($tipo==1){return $pdf->stream('reporte');}
       if($tipo==2){return $pdf->download('reporte.pdf'); }
     
    }
//----------------------------------Generamos el PDF------------------------//




/*------------------------------PANEL ADMIN--------------------------------------*/




































/*------------------------------PANEL USUARIO--------------------------------------*/
 public function PagarFactura(request $request,$id){

    $link = "Realizar el Pago";   
    $venta = Venta::find($id);
    $transactions = Transaction::where('venta_id','=',$venta->id)->get();
    $total = (int)$venta->total;
    //agregamos el porcentaje
  
    $nombre = Auth::user()->nombre;
    $apellido = Auth::user()->apellido;
    $email = Auth::user()->email;
    $mercadopago = Mercadopago::first();

     $mp = new MP("$mercadopago->public_key", "$mercadopago->private_key");


        
 //si elejimos mercado pago
 

    if (empty($mercadopago)) {
      flash('No se puede realizar compras por MercadoPago por este momento , revise las (Key).')->error(); 
      return Redirect::back();
    }else{ 

     $mp = new MP("$mercadopago->public_key", "$mercadopago->private_key");

       
   $preference_data = array(
    "items" => array(
        array(
            "id" => $venta->id,
            "title" => "servicio web SharkEstudio Factura N".$venta->id,
            "currency_id" => "AR",
            "picture_url" =>"http://sharkestudio.com/storage/shark.png",
            "description" => "",
            "category_id" => "Category",
            "quantity" => 1,
            "unit_price" => $total
        )

    ),




    "payer" => array(
        "name" => $nombre,
        "surname" => $nombre,
        "email" => $email,
        "date_created" => "2014-07-28T09:50:37.521-04:00",
        "phone" => array(
            "area_code" => "11",
            "number" => "4444-4444"
        ),
        "identification" => array(
            "type" => "DNI",
            "number" => "12345678"
        ),
        "address" => array(
            "street_name" => "Street",
            "street_number" => 123,
            "zip_code" => "1430"
        )
    ),


  
    "back_urls" => array(
        "success" => "http://sharkestudio.com",
        "failure" => "http://sharkestudio.com",
        "pending" => "http://sharkestudio.com"
    ),


    "auto_return" => "approved",

   

    "payment_methods" => array(

        
        "installments" => 24,
        "default_payment_method_id" => null,
        "default_installments" => null,
    ),



    "shipments" => array(
        "receiver_address" => array(
            "zip_code" => "1430",
            "street_number"=> 123,
            "street_name"=> "Street",
            "floor"=> 4,
            "apartment"=> "C"
        )
    ),


    "notification_url" => "https://www.your-site.com/ipn",
    "external_reference" => $venta->id,
    "expires" => false,
    "expiration_date_from" => null,
    "expiration_date_to" => null
    );

    $preference = $mp->create_preference($preference_data);

         }   


        return view('admin.venta.pagar', compact('preference','link'));
    }


/*------------------------------PANEL USUARIO--------------------------------------*/



}