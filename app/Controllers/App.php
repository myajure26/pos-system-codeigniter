<?php

namespace App\Controllers;

class App extends BaseController
{
	public function index()
	{
		if(!$this->session->has('name')){
			
			$data = [
				"title" => "Iniciar sesión - $this->system", 
				"system" => $this->system
			];
			return view('app/signin', $data);

		}else{
			
			$data = [
				"title" => $this->system, 
				"system" => $this->system,
				"name" => $this->session->get('name'),
				"photo" => $this->session->get('photo')
			];
			return view('app/dashboard', $data);


		}

	}

	public function recover()
	{
		if(!$this->session->has('name')){
			
			$data = [
				"title" => "Recuperar contraseña - $this->system", 
				"system" => $this->system
			];
			return view('app/recover', $data);

		}else{
			
			return redirect()->to(base_url('#dashboard'));

		}

	}

	public function dashboard()
	{
		if($this->session->has('name')){
			
			$data = [
				"title" => "Inicio - $this->system"
			];
			return view('app/ajax/dashboard', $data);
		
		}else{

			return redirect()->to(base_url());
		
		}
	}

	public function audits()
	{
		if($this->session->has('name')){
			
			$data = [
				"title" => "Auditoría - $this->system"
			];
			return view('app/ajax/audits', $data);
		
		}else{

			return redirect()->to(base_url());
		
		}
	}

	public function categories()
	{
		if($this->session->has('name')){
			
			$data = [
				"title" => "Categorías - $this->system"
			];
			return view('app/ajax/categories', $data);
		
		}else{

			return redirect()->to(base_url());
		
		}
	}

	public function users()
	{
		if($this->session->has('name')){
		
			$data = [
				"title" => "Usuarios - $this->system"
			];
			return view('app/ajax/users', $data);
		
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
