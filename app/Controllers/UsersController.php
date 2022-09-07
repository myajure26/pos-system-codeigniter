<?php 
namespace App\Controllers;
use App\Models\UsersModel;
use \Hermawan\DataTables\DataTable;

class UsersController extends BaseController
{
	protected $message;
	protected $response;

	public function signin()
	{
		if($this->validate('signin')){
			
			$username = $this->request->getPost('username');
			$password = $this->request->getPost('password');
			$password = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			$usersModel = new UsersModel();
			
			$user = $usersModel->signin(['username' => $username]);

			if(count($user) > 0){
			
				if($password == $user[0]['password']){

					$userData = [
						"name" => $user[0]["name"],
						"email" => $user[0]["username"],
						"role" => $user[0]["role"],
						"photo" => $user[0]["photo"]
					];

					$this->session->set($userData);

					$this->response = [
						"alert" => "reload",
						"type" => "success",
						"title" => "¡Bienvenido/a!",
						"text" => $user[0]['name'],
						"url" => base_url()
					];
					

				}else{
					$this->message = "Contraseña incorrecta";
				}
			
			}else{
				$this->message = "El usuario no existe";
			}
		
		}else{

			// Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->message = esc($error);
				break;
			}
			
		}

		//Definir el sweet alert una sola vez
		if($this->message != null){
			$this->response = [
				"alert" => "simple",
				"type" => "error",
				"title" => "Oops!",
				"text" => $this->message
			];
		}
		return sweetAlert($this->response);

	}

	public function createUser()
	{
		if($this->validate('users')){

			$username = $this->request->getPost('username');
			$password = $this->request->getPost('password');
			$password = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			$data = [
				"name" => $this->request->getPost('name'),
				"username" => $this->request->getPost('username'),
				"email" => $this->request->getPost('email'),
				"password" => $password,
				"role" => $this->request->getPost('role'),
				"photo" => NULL
			];	
			
			// Subir foto al servidor
			if($this->request->getFile('photo') != ''){
				$photo = $this->request->getFile('photo');
				$photoName = $username.'.'.explode('/', $photo->getMimeType())[1];

				if ($photo->isValid() && ! $photo->hasMoved()) {
				    $photo->move(ROOTPATH . 'public/uploads', $photoName);

				    // Redimensionar la foto
				    $photo = \Config\Services::image()
					    ->withFile(ROOTPATH.'public/uploads/'.$photoName)
					    ->fit(500, 500, 'center')
					    ->save(ROOTPATH.'public/uploads/users/'.$photoName);
					unlink(ROOTPATH.'public/uploads/'.$photoName);

					$photo = base_url('uploads/users/'.$photoName);
					$data['photo'] = $photo;
				}else{
					$this->message = "Ocurrió un error al subir la foto";
				}

				
			}

			$usersModel = new UsersModel();

			$user = $usersModel->createUser($data);

			if($user){
				$this->response = [
					"alert" => "clean",
					"type" => "success",
					"title" => "!",
					"text" => "Usuario creado con éxito",
					"ajaxReload" => "users"
				];
			}else{
				$this->message = "Ocurrió un error al guardar el usuario en la base de datos";
			}
			
		
		}else{

			// Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->message = esc($error);
				break;
			}
			
		}

		//Definir el sweet alert una sola vez
		if($this->message != null){
			$this->response = [
				"alert" => "simple",
				"type" => "error",
				"title" => "Oops!",
				"text" => $this->message
			];
		}
		return sweetAlert($this->response);
	}

	public function getUsers()
	{
		$usersModel = new UsersModel();
				
		return DataTable::of($usersModel->getUsers())
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