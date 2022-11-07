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
			->toJson();
	}
}
