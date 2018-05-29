@foreach($transactions as $transaction)
<div class="modal fade " id="status-{{ $transaction->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDelete">
 <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
 
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Cambiar Status del Servicio</h4>
      </div>



<div class="container">
  {!!Form::open(['url'=>['cambiar-status-transaccion',$transaction->id], 'method'=>'POST' ])!!}

<div class="form-horizontal">
	<span class="label label-success">{!!Form::label('Activado', 'Activado') !!}</span>
	<input name="estado" 	type="radio" value="Activado" checked="checked" >
</div>
<div class="form-horizontal">
	<span class="label label-warning">{!!Form::label('Desactivado', 'Desactivado') !!}</span>
	<input name="estado" type="radio" value="Desactivado" >
</div>


<br><br>
{!!Form::submit('Cambiar Estado',['class'=>'btn btn-primary'])!!}
{!!Form::close()!!}
</div>

	
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
     </div>
   </div>
 </div>
@endforeach
