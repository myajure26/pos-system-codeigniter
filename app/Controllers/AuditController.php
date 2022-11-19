<?php 
namespace App\Controllers;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class AuditController extends BaseController
{
	public function getAudits()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$AuditModel = new AuditModel();
				
		return DataTable::of($AuditModel->getAudits())
			->toJson();
	}
}