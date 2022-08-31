<?php

namespace App\Controllers;

class App extends BaseController
{
	public function index()
	{
		if(!$this->session->has('session')){
			
			$data = ["title" => "Iniciar sesión - $this->system", "system" => $this->system];
			return view('app/signin', $data);

		}else{
			
			return redirect()->to(base_url('app/dashboard'));

		}

	}

	public function recover()
	{
		if(!$this->session->has('session')){
			
			$data = ["title" => "Recuperar contraseña - $this->system", "system" => $this->system];
			return view('app/recover', $data);

		}else{
			
			return redirect()->to(base_url('app/dashboard'));

		}

	}

	public function dashboard()
	{
		if($this->session->has('session')){
			
			$data = [
				"title" => "Inicio - $this->system", 
				"system" => $this->system,
				"name" => $this->session->get('name'),
				"photo" => $this->session->get('photo')
			];
			return view('app/index', $data);

		}else{
			
			return redirect()->to(base_url());

		}

	}

	public function logout()
	{
		$this->session->destroy();
		return redirect()->to(base_url());
	}

}
