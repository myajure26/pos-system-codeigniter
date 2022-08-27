<?php

namespace App\Controllers;

class App extends BaseController
{
	public function index()
	{
		if(!isset($_POST['user'])){
			
			$data = ["title" => "Iniciar sesión - $this->system", "system" => $this->system];
			return view('app/signin', $data);

		}else{
			
			echo '<script>window.location.href="/app/dashboard"</script>';

		}

	}

	public function recover()
	{
		if(!isset($_POST['user'])){
			
			$data = ["title" => "Recuperar contraseña - $this->system", "system" => $this->system];
			return view('app/recover', $data);

		}else{
			
			echo '<script>window.location.href="/app/dashboard"</script>';

		}

	}
}
