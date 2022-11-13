<?php 
namespace App\Controllers;
use App\Models\ReportModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class ReportController extends BaseController
{
	protected $errorMessage = [
		"alert" => "simple",
		"type" => "error",
		"title" => "¡Oops!",
		"text" => ""
	];

	protected $successMessage = [
		"alert" => "simple",
		"type" => "success",
		"title" => "¡Éxito!",
		"text" => ""
	];

	protected $auditContent = [
		"usuario"		=> "",
		"modulo"		=> "Reportes",
		"accion"		=> "",
		"descripcion"	=> ""
	];


	public function getInventory()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$ReportModel = new ReportModel();
				
		return DataTable::of($ReportModel->getInventory())
			->edit('cant_producto', function($row){
							
				if($row->cant_producto < 5){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-dark p-2 px-3">'.$row->cant_producto.'</a></div>';
				}
				
				if($row->cant_producto < 15){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-warning text-dark p-2 px-3">'.$row->cant_producto.'</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-dark p-2 px-3">'.$row->cant_producto.'</a></div>';
			})
			->toJson();
	}
}
