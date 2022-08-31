<?php 
namespace App\Controllers;
use App\Models\UsersModel;

class UsersController extends BaseController
{
	public function signinController()
	{
		$message = null;
		$response = null;

		if($this->validate('signin')){
			
			$username = cleanString($this->request->getPost('username'), 'string');
			$password = cleanString($this->request->getPost('password'), 'string');
			$password = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			$model = new UsersModel();
			
			$user = $model->signinModel(['username' => $username]);

			if(count($user) > 0){
			
				if($password == $user[0]['password']){

					$data = [
						"name" => $user[0]["name"],
						"username" => $user[0]["username"],
						"session" => $user[0]["role"],
						"photo" => $user[0]["photo"]
					];

					$this->session->set($data);

					$response = [
						"alert" => "reload",
						"type" => "success",
						"title" => "Bienvenido/a!",
						"text" => $user[0]['name'],
						"url" => base_url()
					];
					

				}else{
					$message = "Contraseña incorrecta";
				}
			
			}else{
				$message = "El usuario no existe";
			}
		
		}else{

			// Mostrar errores de validación
			if($this->validator->getError('username')){
				$message = esc($this->validator->getError('username'));
			}else{
				$message = esc($this->validator->getError('password'));
			}
			
		}

		//Definir el sweet alert una sola vez
		if($message != null){
			$response = [
				"alert" => "simple",
				"type" => "error",
				"title" => "Oops!",
				"text" => $message
			];
		}
		return sweetAlert($response);

	}
}