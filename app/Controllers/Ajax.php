<?php

namespace App\Controllers;

use App\Controllers\UsersController;

class Ajax extends BaseController
{
	/*====================================
					VISTAS
	====================================*/
	public function index()
	{
		if($this->session->has('session')){
			$data = [
				"title" => "Inicio - $this->system"
			];
			return view('app/ajax/index', $data);
		}else{

			return redirect()->to(base_url());
		
		}
	}

}