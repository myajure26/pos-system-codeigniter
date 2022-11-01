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
							->select('id, coin, symbol')
							->where('deleted_at', NULL)
							->get()
							->getResult();

			$data = [
				"title" => "Centro de control - $this->system",
				"coins" => $coins
			];
			return view('app/ajax/controlCenter', $data);
		
		}else{

			return redirect()->to(base_url());
		
		}
	}

	public function newPurchase()
	{
		if($this->session->has('name')){

			$db      	= \Config\Database::connect();
			$coins 		= $db
							->table('monedas')
							->select('identificacion, moneda, simbolo')
							->where('estado', 1)
							->get()
							->getResult();
			$receipt 	= $db
							->table('tipo_documento')
							->select('identificacion, nombre')
							->where('estado', 1)
							->get()
							->getResult();

			$data = [
				"title" 	=> "Registrar nueva compra - $this->system",
				"coins"		=> $coins,
				"receipt"	=> $receipt
			];
			return view('app/ajax/newPurchase', $data);
		
		}else{

			return redirect()->to(base_url());
		
		}
	}

	public function purchases()
	{
		if($this->session->has('name')){

			$db      	= \Config\Database::connect();
			$coins 		= $db
							->table('monedas')
							->select('identificacion, moneda, simbolo')
							->where('estado', 1)
							->get()
							->getResult();
			$receipt 	= $db
							->table('tipo_documento')
							->select('identificacion, nombre')
							->where('estado', 1)
							->get()
							->getResult();
			
			$data = [
				"title" => "Compras - $this->system",
				"receipt" 	=> $receipt,
				"coins"		=> $coins
			];
			return view('app/ajax/purchases', $data);
		
		}else{

			return redirect()->to(base_url());
		
		}
	}

	public function inventory()
	{
		if($this->session->has('name')){
			
			$data = [
				"title" => "Inventario - $this->system"
			];
			return view('app/ajax/inventory', $data);
		
		}else{

			return redirect()->to(base_url());
		
		}
	}

	public function products()
	{
		if($this->session->has('name')){

			$db      	= \Config\Database::connect();
			$brands 	= $db
							->table('marcas')
							->select('identificacion, marca')
							->where('estado', 1)
							->get()
							->getResult();
			$categories = $db
							->table('categorias')
							->select('identificacion, categoria')
							->where('estado', 1)
							->get()
							->getResult();
			$taxes = $db
							->table('impuestos')
							->select('identificacion, impuesto')
							->where('estado', 1)
							->get()
							->getResult();
			$coins 		= $db
							->table('monedas')
							->select('identificacion, moneda, simbolo')
							->where('estado', 1)
							->get()
							->getResult();
			
			$data = [
				"title" 		=> "Productos - $this->system",
				"brands" 		=> $brands,
				"categories" 	=> $categories,
				"taxes" 		=> $taxes,
				"coins" 		=> $coins
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

	public function customers()
	{
		if($this->session->has('name')){
			$data = [
				"title" => "Clientes - $this->system"
			];
			return view('app/ajax/customers', $data);
		
		}else{

			return redirect()->to(base_url());
		
		}
	}

	public function providers()
	{
		if($this->session->has('name')){
			
			$data = [
				"title" => "Proveedores - $this->system"
			];
			return view('app/ajax/providers', $data);
		
		}else{

			return redirect()->to(base_url());
		
		}
	}

	public function users()
	{
		if($this->session->has('name')){

			$db      	= \Config\Database::connect();
			$privileges = $db
						->table('privilegios')
						->select('identificacion, nombre')
						->where('estado', 1)
						->get()
						->getResult();
		
			$data = [
				"title" => "Usuarios - $this->system",
				"privileges" => $privileges
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

	public function document_type()
	{
		if($this->session->has('name')){
		
			$data = [
				"title" => "Tipos de documento - $this->system"
			];
			return view('app/ajax/document_type', $data);
		
		}else{

			return redirect()->to(base_url());
		
		}
	}

	public function privileges()
	{
		if($this->session->has('name')){
		
			$data = [
				"title" => "Privilegios - $this->system"
			];
			return view('app/ajax/privileges', $data);
		
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
