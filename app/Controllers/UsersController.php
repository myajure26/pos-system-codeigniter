<?php 
namespace App\Controllers;
use App\Models\UsersModel;
use \Hermawan\DataTables\DataTable;

class UsersController extends BaseController
{
	public function signinController()
	{
		$message = NULL;
		$response = NULL;

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
						"title" => "¡Bienvenido/a!",
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

	public function getUsersController()
	{
		$model = new UsersModel();
				
		return DataTable::of($model->getUsersModel())
			->edit('photo', function($row){

				if($row->photo == ''){
					return '<img src="'.base_url('assets/images/users/anonymous.png').'" class="rounded-circle header-profile-user">';
				}

				return '<img src="'.$row->photo.'" class="rounded-circle header-profile-user">';
			})
			->edit('status', function($row){

				if($row->status == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->add('Acciones', function($row){
				return '<div class="btn-list"> 
                            <button type="button" class="btnEditUser btn btn-sm btn-primary" username="'.$row->username.'" data-bs-effect="effect-scale" data-bs-toggle="modal" data-bs-target="#modalEditUser">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button id="bDel" type="button" class="btnDeleteUser btn  btn-sm btn-danger" username="'.$row->username.'" photo="'.$row->photo.'">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>';
			}, 'last') 
			->toJson();
	}
}