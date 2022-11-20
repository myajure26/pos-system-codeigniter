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
			->filter(function ($builder, $request) {
					
				if($request->range != ''){

					if(!empty(explode(' a ', $request->range)[1])){
						$from = explode(' a ', $request->range)[0];
						$to = explode(' a ', $request->range)[1];
						$where = "DATE_FORMAT(auditoria.creado_en, '%Y-%m-%d') BETWEEN '$from' AND '$to'";
						$builder->where($where);
					}else{
						$where = "DATE_FORMAT(auditoria.creado_en, '%Y-%m-%d') = '$request->range'";
						$builder->where($where);
					}
					
				}

			})
			->toJson();
	}
}