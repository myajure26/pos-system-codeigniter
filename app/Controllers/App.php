<?php

namespace App\Controllers;

class App extends BaseController
{
	public function index()
	{
		$data = [
			"title" => "Inicio - $this->system"
		];
		return view('app/index', $data);
	}
}
