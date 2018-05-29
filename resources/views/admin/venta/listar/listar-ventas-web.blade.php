@extends('layouts.admin-pro')
@section('content')
<!-- muestra mensaje que se a modificado o creado exitosamente-->
<!--include('alerts.success')-->


           <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor"><i class="mdi mdi-cash-100 font-red"></i>
                  <span class="caption-subject font-red sbold uppercase">Seccion de Venas</span></h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{!! URL::to('/panel') !!}">Home</a></li>
                            <li class="breadcrumb-item active "><a href="#">Ventas Web</a></li>
                        </ol>
                    </div>
                </div>





                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

@include('alerts.request')
@include('alerts.success')




        <h4 class="card-title"></h4>
  
  <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"> <a class="nav-link "  href="{{ url('listar-ventas') }}" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Ventas</span></a> </li>
          
          <li class="nav-item"> <a class="nav-link active"  href="{{ url('listar-ventas-web') }}" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Ventas Web</span></a> </li>
      </ul>


<br><br>

  <!--buscador-->
{!!Form::open(['url'=>'listar-venta', 'method'=>'GET' , 'class'=>' form-group  navbar-form' , 'role'=>'Search'])!!}


<div class="row ">

<div class=" col-md-3 m-t-20">
<div class="input-group">
    <span class="input-group-addon" id="basic-addon3"><i class="fa fa-calendar"></i></span>
      <input type="text" name="fecha_inicio" class="form-control mydatepicker" id="datepicker" aria-describedby="basic-addon3" placeholder="Fecha de Inicio">
  </div>
   </div>

   <div class=" col-md-3 m-t-20">
<div class="input-group">
    <span class="input-group-addon" id="basic-addon3"><i class="fa fa-calendar"></i></span>
      <input type="text" name="fecha_final" class="form-control mydatepicker" id="datepicker2"  placeholder="Fecha de Fin">
  </div>
   </div>

   <div class=" col-md-3 m-t-20">
      <button type="submit" class=" btn btn-success "> BUSCAR </button>
   </div>

  </div>
{!!Form::close()!!}
 <!--endbuscador-->



 <div class="table-responsive m-t-40">
                                    <table id="mydatatable" class="table table-hover full-inverse-table hover-table" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>mostrar</th>
                                                <th>usuario</th>
                                                <th>pago</th>
                                                <th>total</th>
                                                <th>status</th> 
                                                <th>fecha</th> 
                                                <th>operaciones</th> 
                                                <th>pagar</th> 
                                            </tr>
                                        </thead>
                                       
                                          <tbody>
                                         </tbody>
                                        
                                    </table>
                                </div>




                            </div>
                        </div>
                    </div>
                </div>






    @include('admin.venta.modal.modal-status')
    @include('admin.venta.modal.modal-detalle-venta')


@section('datepicker')
<!-- bootstrap datepicker -->
 {!!Html::script('admin/adminpro/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')!!} 

<script>
   jQuery('.mydatepicker, #datepicker').datepicker();
   jQuery('.mydatepicker, #datepicker2').datepicker();
</script>

@stop



@section('mis-scripts')

<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>


<script>
  function activartabla() {
    $('#mydatatable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        pagingType: "full_numbers",
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        
         ajax: 'listar-ventas-web-datatable',
        columns: [

            //ID
            { data: 'id', name: 'id' },

            //mostrar detalle
            { data: null,  render: function ( data, type, row ) {
                return "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#datalle-"+data.id+"'><i class='fa fa-expand'> Detalle</i></button>"  }
            },

            //Usuario
            { data: 'user.email', name: 'user.email' },

            //Tipo de pago
            { data: 'pago_tipo', name: 'pago_tipo' },

            //total
            { data: null,  render: function ( data, type, row ) {
              return "$"+data.total+"" 
              }
            },

            //STATUS
            { data: null,  render: function ( data, type, row ) {

              if(data.status == "pagado"){
                return "<a href='#status-"+data.id+"' data-toggle='modal' ><span class='label label-success'>"+data.status+"</span></a>" 
                }

              if(data.status == "pendiente"){
                return "<a href='#status-"+data.id+"' data-toggle='modal' ><span class='label label-warning'>"+data.status+"</span></a>" 
                }

              if(data.status == "cancelado"){
                if(data.pago_tipo == "puntos"){
                  return "<span class='label label-danger'>"+data.status+"</span>" 
                }else{
                  return "<a href='#status-"+data.id+"' data-toggle='modal' ><span class='label label-danger'>"+data.status+"</span></a>" 
                 }
                }

                 }
              },

            //Fecha
            { data: 'created_at', name: 'created_at' },


            //operaciones
            { data: null,  render: function ( data, type, row ) {
                return "<a href='venta-detalle-pdf/1/"+data.id+"' target='_blank' ><button class='btn btn-danger'><i class='fa fa-file-pdf-o'> PDF</i></button></a>      <a href='venta-enviar-factura-email/"+data.id+"'  ><button class='btn btn-primary'><i class='fa  fa-envelope'> ENVIAR</i></button></a>"  }
            },

            //Pagar
            { data: null,  render: function ( data, type, row ) {

                if(data.status == "pendiente"){
                return "<a href='venta-pagar-"+data.id+"' target='_blank' ><img height='50' width='50' src='storage/icono admin/credit-card.svg' alt='' ></a>"  
                }else{
                  return ""
                }

              }
            },

          
        ],
    });
}


activartabla();
</script>
@stop




@endsection
