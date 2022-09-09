<?php 
namespace App\Controllers;
use App\Models\UsersModel;
use \Hermawan\DataTables\DataTable;

class UsersController extends BaseController
{
	protected $errorMessage = [
		"alert" => "simple",
		"type" => "error",
		"title" => "¡Oops!",
		"text" => ""

	];

	protected $successMessage = [
		"alert" => "simple",
		"type" => "success",
		"title" => "¡Éxito!",
		"text" => ""

	];

	public function signin()
	{
		if(!$this->validate('signin')){
			
			// Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$username = $this->request->getPost('username');
		$password = crypt($this->request->getPost('password'), '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

		$usersModel = new UsersModel();
		$user = $usersModel->signin(['username' => $username]);

		if($user[0]['password'] != $password){
			$this->errorMessage['text'] = "La contraseña es incorrecta";
			return sweetAlert($this->errorMessage);
		}

		$userData = [
			"name" => $user[0]["name"],
			"email" => $user[0]["username"],
			"role" => $user[0]["role"],
			"photo" => $user[0]["photo"]
		];

		$this->session->set($userData);

		$this->successMessage['alert'] = "reload";
		$this->successMessage['title'] = "¡Bienvenido/a";
		$this->successMessage['text'] = $user[0]["name"];
		$this->successMessage['url'] = base_url();
		return sweetAlert($this->successMessage);

	}

	public function createUser()
	{
		if(!$this->validate('users')){
			
			// Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}
		}

		$username = $this->request->getPost('username');
		$password = crypt($this->request->getPost('password'), '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

		$userData = [
			"name" => $this->request->getPost('name'),
			"username" => $this->request->getPost('username'),
			"email" => $this->request->getPost('email'),
			"password" => $password,
			"role" => $this->request->getPost('role'),
			"photo" => NULL
		];

		if($this->request->getFile('photo') != ''){
			$photoUpload = self::photoUpload($this->request->getFile('photo'), $username);
			if(!$photoUpload){
				$this->errorMessage['text'] = "Ha ocurrido un error al subir la foto";
				return sweetAlert($this->errorMessage);
			}

			$userData["photo"] = $photoUpload;
		}

		$usersModel = new UsersModel();
		$user = $usersModel->createUser($userData);

		if(!$user){
			$this->errorMessage['text'] = "Ha ocurrido un error al guardar los datos";
			return sweetAlert($this->errorMessage);
		}
		
		$this->successMessage['alert'] = "clean";
		$this->successMessage['text'] = "El usuario se ha creado correctamente";
		$this->successMessage['ajaxReload'] = "users";
		return sweetAlert($this->successMessage);
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

	// Funciones parciales
	public function photoUpload($photo, $username, $delete = false)
	{
		$photoName = $username.'.'.explode('/', $photo->getMimeType())[1];
		
		if($delete){
			unlink(ROOTPATH.'public/uploads/users/'.$photoName);
		}

		if ($photo->isValid() && ! $photo->hasMoved()) {
		    $photo->move(ROOTPATH . 'public/uploads', $photoName);

		    // Redimensionar la foto
		    $editPhoto = \Config\Services::image()
			    ->withFile(ROOTPATH.'public/uploads/'.$photoName)
			    ->fit(500, 500, 'center')
			    ->save(ROOTPATH.'public/uploads/users/'.$photoName);
			unlink(ROOTPATH.'public/uploads/'.$photoName);

			$photo = base_url('uploads/users/'.$photoName);
			return $photo;
		}

		return false;
	}
}