<?php

namespace App\Libraries;

use App\User;
use App\Order;
use DB;

/**
 * 
 */
class Base
{
	public static function extractNumbers( $data )
	{
		$res = preg_replace( '/[^0-9]+/' , '' , $data );

        return $res;
	}

	public static function getOrdersQty()
	{
		$step = '';

		switch (auth()->user()->user_types_id) {
			case 2:
				$step = [2 , 4];
				break;

			case 3:
				$step = [3];
				break;

			case 4:
				$step = [6];
				break;

			case 5:
				$step = [5];
				break;

			case 6:
				$step = [7];
				break;

			case 7:
				$step = [8];
				break;
			
			default:
				$step = [1];
				break;
		}

		/*
			2 = Crear Remisión 	   - Ventas
			3 = Verificar Cartera  - Cartera
			4 = Subir Contabilidad - Ventas
			5 = Alistamiento 	   - Bodega
			6 = Creación Factura   - Contabilidad
			7 = Agregar Guía 	   - Despacho
			8 = Recepción Factura  - Devoluciones
		*/

		$orders = Order::from('orders as o')
			->select(
				'o.id as os_id' ,
				'o.number' ,
				'osp.comment' ,
				'u.name' ,
				'ost.status' ,
				's.step' ,
				'osp.next' ,
				DB::raw('timestampdiff(DAY , o.created_at , curdate()) as days')
			)
			->leftJoin('order_step as osp' , 'osp.orders_id' , 'o.id')
			->leftJoin('users as u' , 'u.id' , 'osp.users_id')
			->leftJoin('order_status as ost' , 'ost.id' , 'o.status_id')
			->leftJoin('steps as s' , 's.id' , 'osp.steps_id')
			->whereIn('osp.next' , $step)
			->where('osp.actual' , 1)
			->where('o.status_id' , '<' , 3)
			->get()
		;

		return $orders;
	}
	
}