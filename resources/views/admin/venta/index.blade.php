@extends('layouts.admin-pro')
@section('content')
@role('administrador')
@include('flash::message')
<!-- muestra mensaje que se a modificado o creado exitosamente-->
<!--include('alerts.success')-->



           <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor"><i class="mdi mdi-cash-multiple font-red"></i>
                  <span class="caption-subject font-red sbold uppercase">Generar Nueva Venta</span></h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{!! URL::to('/panel') !!}">Home</a></li>
                            <li class="breadcrumb-item active "><a href="{!! URL::to('/listar-ventas-pendientes') !!}">Ventas</a></li>
                            <li class="breadcrumb-item active "><a href="#">Nueva Venta</a></li>
                        </ol>
                    </div>
                </div>



@include('alerts.request')
@include('alerts.success')



<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-header bg-info">
            <h4 class="m-b-0 text-white">Nueva Venta

      

          </h4>


        </div>
        <div class="card-body">
        

        
        
{!!Form::open(array('url'=>'nueva-venta-store','method'=>'POST','autocomplete'=>'off'))!!}
        {{Form::token()}}
            @include('admin.venta.forms.venta')
        {!!Form::close()!!}



          </div>
        </div>
     </div>
  </div>


@include('admin.venta.modal.modal-descuento')




@section('mis-scripts')
<script>
 $(document).ready(function(){

     ver();

    $('#bt_add').click(function(){
      agregar();
    });

    $(".select2").select2();


  });





  var cont=0;
  total=0;
  subtotal=[];
  $("#guardar").hide();
  $("#pidarticulo").change(mostrarValores);
  $("#tipo_comprobante").change(marcarImpuesto);


  function mostrarValores()
  {
    datosArticulo=document.getElementById('pidarticulo').value.split('_');
    $("#pprecio_venta").val(datosArticulo[2]);
    $("#pstock").val(datosArticulo[1]);    
  }


  function marcarImpuesto()
  {
    tipo_comprobante=$("#tipo_comprobante option:selected").text();
    if (tipo_comprobante=='Factura')
    {
        $("#impuesto").prop("checked", true); 
    }
    else
    {
        $("#impuesto").prop("checked", false);
    }
  }




function ver()
  {

        var tablaDatos = $("#datos");
        $("#datos").empty();

        $.get('nueva-venta-show', function(data){
            $("#total").html("$" + data[0].toFixed(1));
            $("#total_venta").val(data[0].toFixed(1));
            evaluar(data[0].toFixed(1));

              
    $(data).each(function(key,value){
        tablaDatos.append("<tr><td><img src='"+String(data[2][key].imagen1)+"' alt='' style='height:50px'></td><td>"+data[2][key].descripcion+"</td><td>"+data[2][key].precioventa+"</td><td><input type='number' min='1' max='100' value='"+data[2][key].quantity+"' id='product_"+data[2][key].id+"'><a href='#' class='btn btn-warning' data-href='' data-id ='"+data[2][key].id+"' onclick='ActualizarItem("+data[2][key].id+");'><i class='fa fa-refresh'></i></a></td><td><input type='number' min='1' max='100' value='"+data[2][key].quantity+"' id='product_"+data[2][key].id+"'></td><td><button onclick='DeleteItem("+data[2][key].id+");'  class='btn btn-danger' type='button' ><i class='fa fa-remove'></i></button></td><td>"+'$'+data[2][key].precioventa*data[2][key].quantity+"</td></tr>");
      });

    
            });

        
  }




  function agregar()
  {
    datosArticulo=document.getElementById('pidarticulo').value.split('_');

    idarticulo=datosArticulo[0];
    articulo=$("#pidarticulo option:selected").text();
    cantidad=$("#pcantidad").val();

    descuento=$("#pdescuento").val();
    precio_venta=$("#pprecio_venta").val();
    stock=$("#pstock").val();



    if (parseInt(cantidad) <= 0  ){
          swal ( "Oops" ,  "Ingrese una cantidad a Vender" ,  "error" )
        }

    if (parseInt(precio_venta) == 0  ){
          swal ( "Oops" ,  "Ingrese un Precio de venta" ,  "error" )
        }


    if (idarticulo!="" && cantidad!="" && cantidad>0  && precio_venta!=""){

        if (parseInt(stock)>=parseInt(cantidad)){
          
        subtotal[cont]=(cantidad*precio_venta-descuento);
        total=total+subtotal[cont];


      var tablaDatos = $("#datos");
        $("#datos").empty();


        $.get('nueva-venta-add-item/'+ idarticulo , function(data){
            $("#total").html("$" + data[0].toFixed(1));
            $("#total_venta").val(data[0].toFixed(1));
            evaluar(data[0].toFixed(1));
              
    $(data).each(function(key,value){
        tablaDatos.append("<tr><td><img src='"+String(data[2][key].imagen1)+"' alt='' style='height:50px'></td><td>"+data[2][key].descripcion+"</td><td>"+data[2][key].precioventa+"</td><td><input type='number' min='1' max='100' value='"+data[2][key].quantity+"' id='product_"+data[2][key].id+"'><a href='#' class='btn btn-warning' data-href='' data-id ='"+data[2][key].id+"' onclick='ActualizarItem("+data[2][key].id+");'><i class='fa fa-refresh'></i></a></td><td><input type='number' min='1' max='100' value='"+data[2][key].quantity+"' id='product_"+data[2][key].id+"'></td><td><button onclick='DeleteItem("+data[2][key].id+");'  class='btn btn-danger' type='button' ><i class='fa fa-remove'></i></button></td><td>"+'$'+data[2][key].precioventa*data[2][key].quantity+"</td></tr>");
      });
            });


        limpiar();
        evaluar();


        }else{
          swal ( "Oops" ,  "La cantidad a vender supera el stock" ,  "error" )
        }

    }
  }





function ActualizarItem(id) {


    var id = id ;
    var cantidad = parseInt($("#product_"+id).val());

    

  if (cantidad!="" && cantidad>0 ){

    var tablaDatos = $("#datos");
    $("#datos").empty();
    
    //hace referencia a la ruta , y le mandos los parametros
  $.get('nueva-venta-actualizar-item/'+ id + '/' + cantidad, function(data){
    $("#total").html("$" + data[0].toFixed(1));
    $("#total_venta").val(data[0].toFixed(1));
    evaluar(data[0].toFixed(1));

    $(data).each(function(key,value){
        tablaDatos.append("<tr><td><img src='"+String(data[2][key].imagen1)+"' alt='' style='height:50px'></td><td>"+data[2][key].descripcion+"</td><td>"+data[2][key].precioventa+"</td><td><input type='number' min='1' max='100' value='"+data[2][key].quantity+"' id='product_"+data[2][key].id+"'><a href='#' class='btn btn-warning' data-href='' data-id ='"+data[2][key].id+"' onclick='ActualizarItem("+data[2][key].id+");'><i class='fa fa-refresh'></i></a></td><td><input type='number' min='1' max='100' value='"+data[2][key].quantity+"' id='product_"+data[2][key].id+"'></td><td><button onclick='DeleteItem("+data[2][key].id+");'  class='btn btn-danger' type='button' ><i class='fa fa-remove'></i></button></td><td>"+'$'+data[2][key].precioventa*data[2][key].quantity+"</td></tr>");
      });
    });
    }else{
         swal ( "Oops" ,  "Ingrese una cantidad a Vender" ,  "error" )
    }

}





function DeleteItem(id) {

    var id = id ;

     var tablaDatos = $("#datos");
    $("#datos").empty();

    //hace referencia a la ruta , y le mandos los parametros
    $.get('nueva-venta-delete-item/'+ id , function(data){
       $("#total").html("$" + data[0].toFixed(1));
       $("#total_venta").val(data[0].toFixed(1));
      evaluar(data[0].toFixed(1));
  //me lo muesta en el input que tenga id mostrar
$(data[2]).each(function(key,value){
          tablaDatos.append("<tr><td><img src='"+String(data[2][key].imagen1)+"' alt='' style='height:50px'></td><td>"+data[2][key].descripcion+"</td><td>"+data[2][key].precioventa+"</td><td><input type='number' min='1' max='100' value='"+data[2][key].quantity+"' id='product_"+data[2][key].id+"'><a href='#' class='btn btn-warning' data-href='' data-id ='"+data[2][key].id+"' onclick='ActualizarItem("+data[2][key].id+");'><i class='fa fa-refresh'></i></a></td><td><input type='number' min='1' max='100' value='"+data[2][key].quantity+"' id='product_"+data[2][key].id+"'></td><td><button onclick='DeleteItem("+data[2][key].id+");'  class='btn btn-danger' type='button' ><i class='fa fa-remove'></i></button></td><td>"+'$'+data[2][key].precioventa*data[2][key].quantity+"</td></tr>");
      });
  
});
}







  function limpiar(){
    $("#pcantidad").val("");
    $("#pdescuento").val("0");
   // $("#pprecio_venta").val("");
  }



  function totales()
  {
        $("#total").html("$" + total.toFixed(1));
        $("#total_venta").val(total.toFixed(1));
        
        //Calcumos el impuesto
        if ($("#impuesto").is(":checked"))
        {
            por_impuesto=18;
        }
        else
        {
            por_impuesto=0;   
        }
        total_impuesto=total*por_impuesto/100;
        total_pagar=total+total_impuesto;
        $("#total_impuesto").html("$" + total_impuesto.toFixed(1));
        $("#total_pagar").html("$" + total_pagar.toFixed(1));
        
  }


  function evaluar(total)
  { 

    if (total>0)
    {
      $("#guardar").show();
    }
    else
    {
      $("#guardar").hide(); 
    }
   }



/*---------------------------------DESCUENTO-----------------------------*/

$( '.porcentage_descuento' ).bind( 'click', function(){
      if( ! $( this ).hasClass( 'active' ) ) {
        if( $( '.efectivo_descuento' ).hasClass( 'active' ) ) {
          $( '.efectivo_descuento' ).removeClass( 'active' );
        }

        $( this ).addClass( 'active' );

        // Proceed a quick check on the percentage value
        $( '[name="descuento_value"]' ).focus();


        $( '.descuento_tipo' ).html( ': <Span class = \"label label-primary\"> porcentaje </ span>' );
      }
    });

    $( '.efectivo_descuento' ).bind( 'click', function(){
      if( ! $( this ).hasClass( 'active' ) ) {
        if( $( '.porcentage_descuento' ).hasClass( 'active' ) ) {
          $( '.porcentage_descuento' ).removeClass( 'active' );
        }

        $( this ).addClass( 'active' );

        $( '[name="descuento_value"]' ).focus();
        $( '[name="descuento_value"]' ).blur();


        $( '.descuento_tipo' ).html( ': <Span class = \"label label-info\"> precio fijo </ span>' );
      }
    });



    $('#confirmar_porcentage').click(function(){
     descuento =  $("#descuento_valor").val();
     console.log(descuento);
    });


/*---------------------------------DESCUENTO-----------------------------*/
</script>
@stop



@endrole
@endsection
