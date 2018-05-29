
    <h3 class="panel-title">Usuario</h3>
    <div class="row">
       <div class=" col-xs-12 col-sm-12 col-md-12">

                <select name="iduser" id="iduser" class="form-control custom-select select2"  required="">
                <option  value="">Seleccione al Usuario</option>
                    @foreach($users as $user)
                     <option value="{{$user->id}}">Nombre: {{$user->nombre}} {{$user->apellido}}  --- Email: {{$user->email}}</option>
                     @endforeach
                </select>
        </div>
        </div>




<br>

 <h3 class="panel-title">Tipo de Pago</h3>
<div class="row">


 
        <div class="form-group col-xs-12 col-sm-12 col-md-3">
            <div class="input-group input-icon right ">
                <span class="input-group-addon"><i class="fa fa-file-text font-blue">:</i></span>
                 <select name="tipo_comprobante" id="tipo_comprobante" class="form-control" name="tipo_pago">
                       <option value="Boleta">Boleta</option>
                       <option value="Factura">Factura</option>
                       <option value="Ticket">Ticket</option>
                </select>
            </div>
        </div>


        <div class="form-group col-xs-12 col-sm-12 col-md-3">
            <div class="input-group input-icon right ">
            <span class="input-group-addon"><i class="fa fa-file-text font-blue"></i></span>
                 <input type="text" name="serie_comprobante" value="{{old('serie_comprobante')}}" class="form-control" placeholder="Serie comprobante...">
            </div>
        </div>


        <div class="form-group col-xs-12 col-sm-12 col-md-3">
            <div class="input-group input-icon right ">
                <span class="input-group-addon"><i class="fa fa-file-text font-blue"></i></span>
                 <input type="text" name="num_comprobante"  value="{{old('num_comprobante')}}" class="form-control" placeholder="Número comprobante...">
            </div>
        </div>




        <div class="form-group form-md-checkboxes col-xs-12 col-sm-12 col-md-3">
            <div class="md-checkbox-list">
                <div class="md-checkbox has-success">
                    <input type="checkbox" id="impuesto" class="md-check" name="impuesto" checked="">
                    <label for="impuesto">
                        <span></span>
                        <span class="check"></span>
                        <span class="box"></span> 18% Impuesto </label>
                </div>
            </div>
        </div>

</div><!-- end row-->


<div class="row">


        <div class="form-group col-xs-12 col-sm-12 col-md-3">
            <div class="input-group input-icon right ">
                <span class="input-group-addon"><i class="fa fa-paypal font-blue"> </i></span>
                 {!! Form::select('tipo_pago', config('options.tipopago'),'', array('class' => 'form-control' , 'onchange'=>"if(this.value=='Pagos Multiples') document.getElementById('efectivo').disabled = false  ,document.getElementById('targeta').disabled = false , document.getElementById('numerotargeta').disabled = false")) !!}
            </div>
        </div>


        <div class="form-group col-xs-12 col-sm-12 col-md-3">
            <div class="input-group input-icon right ">
            <span class="input-group-addon"><i class="fa fa-money font-blue"></i></span>
                 <input class="form-control" type="text" id="efectivo" name="efectivo" size="12" value="" placeholder="Monto en Efectivo" disabled>
            </div>
        </div>


      <div class="form-group col-xs-12 col-sm-12 col-md-3">
            <div class="input-group input-icon right ">
            <span class="input-group-addon"><i class="fa fa-credit-card font-blue"></i></span>
                 <input class="form-control" type="text" id="targeta" name="targeta" size="12" value="" placeholder="Monto en Targeta" disabled >
            </div>
        </div>


        <div class="form-group col-xs-12 col-sm-12 col-md-3">
            <div class="input-group input-icon right ">
            <span class="input-group-addon"><i class="fa fa-credit-card font-blue"></i></span>
                  <input class="form-control " type="text" id="numerotargeta" name="numerotargeta" size="12" value="" placeholder="xxxx xxxx xxxx xxxx" disabled >
            </div>
        </div>

</div><!-- end row-->










<div class="row">

                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                    <div class="form-group">
                        <label>Artículo</label>
                        <select name="pidarticulo" class="form-control select2" id="pidarticulo" data-live-search="true" >
                            <option value="">Seleccione el producto</option>
                            @foreach($productos as $producto)                        
                            <option value="{{$producto->id}}_{{$producto->stockactual}}_{{$producto->precioventa}}">{{$producto->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="pcantidad" id="pcantidad" class="form-control" value="0" 
                        placeholder="cantidad">
                    </div>
                </div>

                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" disabled name="pstock" id="pstock" class="form-control" 
                        placeholder="Stock">
                    </div>
                </div>

                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="precio_venta">Precio venta</label>
                        <input type="number"  name="pprecio_venta" id="pprecio_venta" class="form-control" value="0" 
                        placeholder="P. venta">
                    </div>
                </div>

                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="descuento">Descuento</label>
                        <input type="number" name="pdescuento" id="pdescuento" class="form-control" 
                        placeholder="Descuento" value="0">
                    </div>
                </div> 
                
                <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                       <button type="button" id="bt_add"  class="btn btn-primary">Agregar</button>
                    </div>
                </div>

                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <table  id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead style="background-color:#A9D0F5">
                            <th style="width: 5%">Imagen</th>
                            <th style="width: 40%">Artículo</th>
                            <th style="width: 10%">P/Venta</th>
                            <th style="width: 25%">Cantidad</th>
                            <th style="width: 10%">Descuento</th>
                            <th style="width: 10%">Eliminar</th>
                            <th style="width: 10%">Subtotal</th>   
                           
                        </thead>
                        <tfoot>
                            <tr>
                                <th  colspan="6"><p align="right">TOTAL:</p></th>
                                <th><p align="right"><span id="total">$0.00</span> <input type="hidden" name="total_venta" id="total_venta"></p></th>
                            </tr>
                            <tr>
                                <th colspan="6"><p align="right">TOTAL DESCUENTO:</p></th>
                                <th><p align="right"><span id="total_impuesto">$0.00</span></p></th>
                            </tr>
                            <tr>
                                <th  colspan="6"><p align="right">TOTAL PAGAR:</p></th>
                                <th><p align="right"><span align="right" id="total_pagar">$0.00</span></p></th>
                            </tr>  
                        </tfoot>
                        <tbody id="datos">
                            
                        </tbody>
                    </table>
                 </div>


            
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12" id="guardar">
        <div class="form-group">
              <input name"_token" value="{{ csrf_token() }}" type="hidden"></input>
              <a href="{!! URL::to('nueva-venta-vaciar') !!}" class="btn btn-danger">Vaciar Venta <i class="fa fa-trash"></i></a>
                
                <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-dolar">Crear Venta </i></button>

      

                <a href="" class="btn btn-danger" data-toggle="modal" data-target="#descuento" > <i class="fa fa-trash">Descuento</i></a>

                
            </div>
      </div>
      
     </div>