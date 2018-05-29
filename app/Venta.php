<?php

namespace Soft;

use Illuminate\Database\Eloquent\Model;
use Soft\Transaction;
use Soft\Producto;
use Soft\User;
class Venta extends Model
{
    		protected $fillable = [
        	  'id',
            'user_id',
           	'pago_tipo',
            'concepto',
            'pagoefectivo',
            'pagotargeta',
           	'total',
            'realizada',
           	'status',
    ];


public function user()
    {
      //una venta corresponde a un usuario
        return $this->belongsTo(User::class);
    }

public function transaction()
    {
      //una venta corresponde a muchas transacciones
         return $this->hasMany(Transaction::class);
    }

}
