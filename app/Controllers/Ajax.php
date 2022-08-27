<?php

namespace App\Controllers;

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

	/*====================================
				  FORMULARIOS
	====================================*/
}