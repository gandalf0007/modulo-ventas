<?php

namespace Soft;

use Illuminate\Database\Eloquent\Model;
use Soft\Venta;
use Soft\Producto;
use Soft\Servicio;

class Transaction extends Model
{
	 protected $fillable = [
        	'id',
        	'venta_id',
            'servicio_id',
            'producto_id',
            'user',
            'cantidad',
            'total_price',
            'status',
    ];
 

 public function producto()
    {
      //una transaccion corresponde a un producto
        return $this->belongsTo(Producto::class);
    }

public function venta()
    {
      //una transaccion corresponde a una venta
        return $this->belongsTo(Venta::class);
    }

     public function servicio()
    {
      //una transaccion corresponde a una servicio 
        return $this->belongsTo(servicio::class);
    }



}
