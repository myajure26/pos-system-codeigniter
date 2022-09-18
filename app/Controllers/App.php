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

	public function controlCenter()
	{
		if($this->session->has('name')){

			$db      	= \Config\Database::connect();
			$coins 		= $db
							->table('coins')
							->select('id, coin')
							->where('deleted_at', NULL)
							->get()
							->getResult();
			$settings 	= $db
							->table('settings')
							->select('type, name, value')
							->where('type', 'coin')
							->get()
							->getResult();

			$data = [
				"title" => "Centro de control - $this->system",
				"coins" => $coins,
				"settings" => $settings
			];
			return view('app/ajax/controlCenter', $data);
		
		}else{

			return redirect()->to(base_url());
		
		}
	}

	public function products()
	{
		if($this->session->has('name')){

			$db      	= \Config\Database::connect();
			$brands 	= $db
							->table('brands')
							->select('id, brand')
							->where('deleted_at', NULL)
							->get()
							->getResult();
			$categories = $db
							->table('categories')
							->select('id, category')
							->where('deleted_at', NULL)
							->get()
							->getResult();
			$taxes = $db
							->table('taxes')
							->select('id, tax')
							->where('deleted_at', NULL)
							->get()
							->getResult();
			
			$data = [
				"title" 		=> "Productos - $this->system",
				"brands" 		=> $brands,
				"categories" 	=> $categories,
				"taxes" 		=> $taxes
			];
			return view('app/ajax/products', $data);
		
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

	public function brands()
	{
		if($this->session->has('name')){
			
			$data = [
				"title" => "Marcas - $this->system"
			];
			return view('app/ajax/brands', $data);
		
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

	public function coins()
	{
		if($this->session->has('name')){
		
			$data = [
				"title" => "Monedas - $this->system"
			];
			return view('app/ajax/coins', $data);
		
		}else{

			return redirect()->to(base_url());
		
		}
	}

	public function taxes()
	{
		if($this->session->has('name')){
		
			$data = [
				"title" => "Impuestos - $this->system"
			];
			return view('app/ajax/taxes', $data);
		
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
