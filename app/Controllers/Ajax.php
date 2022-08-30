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
		$data = [
			"title" => "Inicio - $this->system"
		];
		return view('app/ajax/index', $data);
	}

}