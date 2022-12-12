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
				"photo" => $this->session->get('photo'),
				"privilege" => $this->session->get('privilege')
			];
			return view('app/dashboard', $data);


		}

	}

	public function dashboard()
	{
		if($this->session->has('name')){
			$db     = \Config\Database::connect();

			$where = "MONTH(ventas.creado_en) = MONTH(CURRENT_DATE)";
			$chart = $db
				->table('ventas')
				->select("FORMAT(SUM((detalle_ventas.precio*detalle_ventas.cantidad)+((detalle_ventas.precio*detalle_ventas.cantidad)*impuestos.porcentaje)/100), 2) as total, DATE_FORMAT(ventas.creado_en, '%Y-%m-%d') as fecha")
				->join('detalle_ventas', 'detalle_ventas.venta = ventas.identificacion')
				->join('impuestos', 'impuestos.identificacion = ventas.impuesto')
				->where($where)
				->where('ventas.estado', 1)
				->groupBy('fecha')
				->get()->getResult();

			$data = [
				"title" => "Inicio - $this->system",
				"chart" => $chart
			];
			return view('app/ajax/dashboard', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function audits()
	{
		if($this->session->get('privilege') == 1){

			$data = [
				"title" => "Auditoría - $this->system"
			];
			return view('app/ajax/audits', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function control_center()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 2){

			$db      	= \Config\Database::connect();
			$coins 		= $db
							->table('monedas')
							->select('identificacion, moneda, simbolo')
							->where('estado', 1)
							->get()
							->getResult();

			$data = [
				"title" => "Centro de control - $this->system",
				"coins" => $coins,
				"principalCoin" => $this->principalCoin
			];
			return view('app/ajax/control_center', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function newSale()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 2){

			$db      	= \Config\Database::connect();
			
			$taxes 			= $db
							->table('impuestos')
							->select('identificacion, impuesto, porcentaje')
							->where('estado', 1)
							->get()
							->getResult();
			$paymentMethod 	= $db
							->table('metodo_pago')
							->select('id_metodo_pago, nombre')
							->where('estado_metodo_pago', 1)
							->get()
							->getResult();
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
				"title" 		=> "Nueva venta - $this->system",
				"taxes" 		=> $taxes,
				"paymentMethod" => $paymentMethod,
				"coins"			=> $coins,
				"receipt"		=> $receipt,
				"principalCoin"	=> $this->principalCoin
			];
			return view('app/ajax/newSale', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function sales()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 2){

			$db      	= \Config\Database::connect();
			$taxes 			= $db
							->table('impuestos')
							->select('identificacion, impuesto, porcentaje')
							->get()
							->getResult();
			$paymentMethod 	= $db
							->table('metodo_pago')
							->select('id_metodo_pago, nombre')
							->get()
							->getResult();
			$coins 		= $db
							->table('monedas')
							->select('identificacion, moneda, simbolo')
							->get()
							->getResult();
			$receipt 	= $db
							->table('tipo_documento')
							->select('identificacion, nombre')
							->get()
							->getResult();

			$data = [
				"title" => "Ventas - $this->system",
				"taxes" 		=> $taxes,
				"paymentMethod" => $paymentMethod,
				"coins"			=> $coins,
				"receipt"		=> $receipt
			];
			return view('app/reports/sales', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function newPurchase()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 3){

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

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function purchases()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 3){

			$db      	= \Config\Database::connect();
			$coins 		= $db
							->table('monedas')
							->select('identificacion, moneda, simbolo')
							->get()
							->getResult();
			$receipt 	= $db
							->table('tipo_documento')
							->select('identificacion, nombre')
							->get()
							->getResult();
			
			$data = [
				"title" => "Compras - $this->system",
				"receipt" 	=> $receipt,
				"coins"		=> $coins
			];
			return view('app/reports/purchases', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function inventory()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 3){
			
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
			$high 		= $db
							->table('alto_caucho')
							->select('id_alto_caucho, alto_numero')
							->where('estado_alto_caucho', 1)
							->get()
							->getResult();
			$wide 		= $db
							->table('ancho_caucho')
							->select('id_ancho_caucho, ancho_numero')
							->where('estado_ancho_caucho', 1)
							->get()
							->getResult();

			$data = [
				"title" => "Inventario - $this->system",
				"brands" 		=> $brands,
				"categories" 	=> $categories,
				"high" 			=> $high,
				"wide" 			=> $wide
			];
			return view('app/ajax/inventory', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function purchases_per_provider()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 3){
			
			$data = [
				"title" => "Reportes de compras por proveedor - $this->system",
				"businessName" 			=> $this->businessName,
				"businessIdentification"=> $this->businessIdentification,
				"businessAddress" 		=> $this->businessAddress,
				"businessPhone" 		=> $this->businessPhone
			];
			return view('app/reports/purchases_per_provider', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function best_providers()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 3){
			
			$data = [
				"title" => "Reportes de los mejores proveedores - $this->system",
				"businessName" 			=> $this->businessName,
				"businessIdentification"=> $this->businessIdentification,
				"businessAddress" 		=> $this->businessAddress,
				"businessPhone" 		=> $this->businessPhone
			];
			return view('app/reports/best_providers', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function general_purchase_reports()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 3){
			
			$data = [
				"title" => "Reportes de toma de decisión - $this->system"
			];
			return view('app/reports/general_purchase_reports', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function sales_per_customer()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 2){
			
			$data = [
				"title" 				=> "Reportes de ventas por cliente - $this->system",
				"businessName" 			=> $this->businessName,
				"businessIdentification"=> $this->businessIdentification,
				"businessAddress" 		=> $this->businessAddress,
				"businessPhone" 		=> $this->businessPhone
			];
			return view('app/reports/sales_per_customer', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function sales_per_product()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 2){
			
			$data = [
				"title" => "Reportes de ventas por producto - $this->system",
				"businessName" 			=> $this->businessName,
				"businessIdentification"=> $this->businessIdentification,
				"businessAddress" 		=> $this->businessAddress,
				"businessPhone" 		=> $this->businessPhone
			];
			return view('app/reports/sales_per_product', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function most_selled_products()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 2){
			
			$data = [
				"title" => "Reportes de productos más vendidos - $this->system",
				"businessName" 			=> $this->businessName,
				"businessIdentification"=> $this->businessIdentification,
				"businessAddress" 		=> $this->businessAddress,
				"businessPhone" 		=> $this->businessPhone
			];
			return view('app/reports/most_selled_products', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function less_sold_products()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 2){
			
			$data = [
				"title" => "Reportes de productos menos vendidos - $this->system",
				"businessName" 			=> $this->businessName,
				"businessIdentification"=> $this->businessIdentification,
				"businessAddress" 		=> $this->businessAddress,
				"businessPhone" 		=> $this->businessPhone
			];
			return view('app/reports/less_sold_products', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function best_customers()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 2){
			
			$data = [
				"title" => "Reportes de mejores clientes - $this->system",
				"businessName" 			=> $this->businessName,
				"businessIdentification"=> $this->businessIdentification,
				"businessAddress" 		=> $this->businessAddress,
				"businessPhone" 		=> $this->businessPhone
			];
			return view('app/reports/best_customers', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function general_sale_reports()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 2){
			
			$data = [
				"title" => "Reportes de toma de decisión - $this->system",
			];
			return view('app/reports/general_sale_reports', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function products()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 3){

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
			$high 		= $db
							->table('alto_caucho')
							->select('id_alto_caucho, alto_numero')
							->where('estado_alto_caucho', 1)
							->get()
							->getResult();
			$wide 		= $db
							->table('ancho_caucho')
							->select('id_ancho_caucho, ancho_numero')
							->where('estado_ancho_caucho', 1)
							->get()
							->getResult();
			
			$data = [
				"title" 		=> "Productos - $this->system",
				"brands" 		=> $brands,
				"categories" 	=> $categories,
				"coin" 			=> $this->symbol,
				"high" 			=> $high,
				"wide" 			=> $wide
			];
			return view('app/ajax/products', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function assign_products()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 3){
			
			$data = [
				"title" => "Asignar productos al proveedor - $this->system"
			];
			return view('app/ajax/assign_products', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function categories()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 3){
			
			$data = [
				"title" => "Categorías - $this->system"
			];
			return view('app/ajax/categories', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function brands()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 3){
			
			$data = [
				"title" => "Marcas - $this->system"
			];
			return view('app/ajax/brands', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function high_rubber()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 3){
			
			$data = [
				"title" => "Alto caucho - $this->system"
			];
			return view('app/ajax/high_rubber', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function wide_rubber()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 3){
			
			$data = [
				"title" => "Ancho caucho - $this->system"
			];
			return view('app/ajax/wide_rubber', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function customers()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 2){
			$data = [
				"title" => "Clientes - $this->system"
			];
			return view('app/ajax/customers', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function providers()
	{
		if($this->session->get('privilege') == 1 || $this->session->get('privilege') == 3){
			
			$data = [
				"title" => "Proveedores - $this->system"
			];
			return view('app/ajax/providers', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function users()
	{
		if($this->session->get('privilege') == 1){

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

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function coins()
	{
		if($this->session->get('privilege') == 1){
		
			$data = [
				"title" => "Monedas - $this->system"
			];
			return view('app/ajax/coins', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function taxes()
	{
		if($this->session->get('privilege') == 1){
		
			$data = [
				"title" => "Impuestos - $this->system"
			];
			return view('app/ajax/taxes', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function document_type()
	{
		if($this->session->get('privilege') == 1){
		
			$data = [
				"title" => "Tipos de documento - $this->system"
			];
			return view('app/ajax/document_type', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function payment_method()
	{
		if($this->session->get('privilege') == 1){
		
			$data = [
				"title" => "Métodos de pago - $this->system"
			];
			return view('app/ajax/payment_method', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function profile()
	{
		if($this->session->has('name')){

			$db      	= \Config\Database::connect();
			$privileges = $db
						->table('privilegios')
						->select('identificacion, nombre')
						->where('estado', 1)
						->get()
						->getResult();
			$user		= $db
						->table('usuarios')
						->select()
						->where('identificacion', $this->session->get('identification'))
						->get()
						->getResult();
			$user 		= $user[0];

			$data = [
				"title" => "Perfil - $this->system",
				"privileges" => $privileges,
				"user"		=> $user
			];
			return view('app/ajax/profile', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}
	
	public function settings()
	{
		if($this->session->get('privilege') == 1){

			$db      	= \Config\Database::connect();
			$coins 		= $db
							->table('monedas')
							->select('identificacion, moneda')
							->where('estado', 1)
							->get()
							->getResult();
			$configuracion 		= $db
							->table('configuracion')
							->select('valor_configuracion');

			$data = [
				"title" 		=> "Cofiguraciones del sistema - $this->system",
				"coins" 		=> $coins,
				"systemName" 	=> $this->system,
				"principalCoin" => $this->principalCoin,
				"name" 			=> $this->businessName,
				"identification"=> $this->businessIdentification,
				"address" 		=> $this->businessAddress,
				"phone" 		=> $this->businessPhone

			];
			return view('app/ajax/settings', $data);
		
		}else{

			return "<script>window.location.href='".base_url()."'</script>";
		
		}
	}

	public function logout()
	{
		$this->session->destroy();
		return "<script>window.location.href='".base_url()."'</script>";
	}

}
