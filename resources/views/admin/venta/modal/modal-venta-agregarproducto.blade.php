@foreach($productos as $producto)
<div class="modal fade" id="productos" tabindex="-1" role="dialog" aria-labelledby="confirmDelete">
 <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Seleccione El Producto</h4>
         </div>


<table id="example2" class="table table-bordered table-hover">
	<thead>
		<th>Codigo</th>
		<th>Imagen</th>
		<th>Descripcion</th>
		<th>Iva</th>
		<th>Costo</th>
		<th>venta</th>
		<th>venta 2</th>
		<th>Stock</th>
		<th>Agregar</th>
	</thead>
	@foreach($productos as $producto)
	<tbody>
	<!-- -->
	<td>{{ $producto -> codigo}}</td>
	<td><img src="storage/productos/{{$producto->imagen1}}" alt="" style="height:100px"></td>
  	<td>{{ $producto -> descripcion}}</td>
   	<td>{{ $producto -> iva_id}}</td>
  	<td>{{ $producto -> preciocosto}}</td>
  	<td>{{ $producto -> precioventa}}</td>
  	<td>{{ $producto -> precio2}}</td>
  	<td>{{ $producto -> stockactual}}</td>

 <!--el usuario.edit hace referencia a la funcion edit del UsuarioController y $user->id nos envia
 el id a esa funcion -->




<td>
<a href="{{ URL::to('venta-addtocart/'.$producto->id) }}">{{ Form::submit('Agregar',array('class'=>'btn btn-success')) }}</a>
</td>


	</tbody>
	@endforeach
	</table>

<!--para renderizar la paginacion-->
  {!! $productos->render() !!}

     </div>
   </div>
 </div>
	@endforeach