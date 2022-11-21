<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentMethodModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'metodo_pago';
	protected $primaryKey           = 'id_metodo_pago';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ["nombre", "estado_metodo_pago", "actualizado_en", "creado_en"];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'creado_en';
	protected $updatedField         = 'actualizado_en';

	public function createPaymentMethod($data)
	{
		if($this->save($data)){
			return true;
		}
		
		return false;
	}

	public function getPaymentMethods()
	{
		$query = $this
			->select('id_metodo_pago as identificacion, nombre, estado_metodo_pago as estado');
		return $query;
	}

	public function getPaymentMethodById($data)
	{
		$query = $this->where($data);
		return $query->get()->getResultArray();
	}

	public function getLastId()
	{
		return $this->insertID();
	}

	public function updatePaymentMethod($data, $identification)
	{
		$query = $this
				->where('id_metodo_pago', $identification)
				->set($data)
				->update();
		return $query;	
	}

	public function deletePaymentMethod($identification)
	{
		$query = $this
				->where('id_metodo_pago', $identification)
				->set('estado_metodo_pago', 0)
				->update();
		return $query;
	}

	public function recoverPaymentMethod($identification)
	{
		$query = $this
				->where('id_metodo_pago', $identification)
				->set('estado_metodo_pago', 1)
				->update();
		return $query;
	}
}
