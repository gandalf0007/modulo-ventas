@extends('layouts.metronic')
@section('content')
<!-- muestra mensaje que se a modificado o creado exitosamente-->
<!--include('alerts.success')-->


 <div class="row">
    <div class="col-md-12">
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">

<i class="fa fa-file-text font-red"></i>
<span class="caption-subject font-red sbold uppercase">Servicios de la Venta (#{{$venta->id}})</span>
@include('alerts.request')
@include('alerts.success')

    <div><br>
    </div>

 <div class="box-body">
  <ul class="nav nav-tabs">
    <li class="active"><a href="{{ url('listar-venta') }}">Servicios</a></li>
  </ul>
</div>   

<!--buscador-->
{!!Form::open(['url'=>'listar-venta', 'method'=>'GET' , 'class'=>'navbar-form navbar-left' , 'role'=>'Search'])!!}
<div class="form-group">


<i class="fa fa-calendar"></i>
{!!Form::label('Fecha Inicial')!!}
{!!Form::text('fecha_inicio',null,['class'=>'form-control','id'=>'datepicker','placeholder'=>'Fecha de Inicio'])!!}

<i class="fa fa-calendar"></i>
{!!Form::label('Fecha Final')!!}
{!!Form::text('fecha_final',null,['class'=>'form-control','id'=>'datepicker2','placeholder'=>'Fecha de Fin'])!!}

 <button type="submit" class="glyphicon glyphicon-search btn btn-success"> BUSCAR </button>
</div>
{!!Form::close()!!}
 <!--endbuscador-->


     </div><!--end caption-->



    <div class="actions">
       <div class="btn-group btn-group-devided" >

        <!--aqui van los botones-->
      
       </div>
   </div>


        </div><!--portlet-title-->
    <div class="portlet-body">
        <div class="table-scrollable">
<div class="table-responsive">
  <table id="example2" class="table table-bordered table-hover">
  <thead>
      <tr>
    <th>Imagen</th>
    <th>Codigo</td>
    <th>Descripcion</th>
    <th>Cantidad</th>
    <th>Estado</th>
      </tr>
    </thead>
    <!--solo muestro las transacciones con el id de sa venta-->
   
    @foreach($transactions as $transaction)

    <tbody>
   <td> <img src="{{ $transaction->producto->imagen1 }}" height="50" width="50"> </td>
   <td>{{ $transaction->producto->codigo }}</td>
   <td>{{ $transaction->producto->descripcion }}</td>
   <td>{{ $transaction->cantidad }}</td>

  <td>
     @if ($transaction -> status == "Activado")
      <a href="#status-{{ $transaction->id }}" data-toggle="modal" ><span class="label label-success">{{ $transaction -> status}}</span></a>

      @elseif ($transaction -> status == "Desactivado")
      <a href="#status-{{ $transaction->id }}" data-toggle="modal" ><span class="label label-warning">{{ $transaction -> status}}</span></a>
      @endif
  </td>

  </tbody>
  
  @endforeach
  </table>

                    </div>
                </div>
            </div>
            <!-- END SAMPLE TABLE PORTLET-->
        </div>
    </div>

<!--para renderizar la paginacion-->
 {!!$transactions->render() !!}


@include('admin.venta.modal.modal-status-transaccion')



@section('scriptdatepicker')
<!-- bootstrap datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<script>
  $(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true  
    });
     $('#datepicker2').datepicker({
      autoclose: true
    });
  });
</script>
@stop

@endsection
