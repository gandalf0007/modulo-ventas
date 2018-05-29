<?php


/*--------------------------------------VENTAS----------------------------------------------------*/
Route::get('nueva-venta','VentaController@NuevaVenta');
Route::post('nueva-venta-store','VentaController@NuevaVentaStore');

Route::get('nueva-venta-show','VentaController@show');
Route::get('nueva-venta-actualizar-item/{id}/{cantidad}','VentaController@update');
Route::get('nueva-venta-add-item/{id}','VentaController@add');
Route::get('nueva-venta-delete-item/{id}','VentaController@delete');
Route::get('nueva-venta-vaciar','VentaController@trash');


//listar ventas
Route::get('listar-ventas','VentaController@listarVentas')->middleware('permission:listar-ventas');
Route::get('listar-ventas-datatable','VentaController@listarVentasDatatable');


//datalle de venta
Route::get('venta-detalle-{id}','VentaController@detalleVenta');


//cambiar status de venta
Route::post('cambiar-status/{id}','VentaController@cambiarStatusVenta')->middleware('permission:editar-venta');


//factura pdf o download
Route::get('venta-detalle-pdf/{tipo}/{id}','VentaController@detalleVentaPdf');
//enviar factura por correo
Route::get('venta-enviar-factura-email/{idventa}','VentaController@EnviarFacturaEmail');
//pagar por mercadopago
Route::get('venta-pagar-{id}','VentaController@PagarFactura');
/*--------------------------------------VENTAS----------------------------------------------------*/

