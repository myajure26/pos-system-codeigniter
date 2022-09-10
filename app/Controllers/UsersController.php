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

		$ci = $this->request->getPost('ci');
		$password = crypt($this->request->getPost('password'), '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

		$usersModel = new UsersModel();
		$user = $usersModel->getUserById(['ci' => $ci]);

		if($user[0]['password'] != $password){
			$this->errorMessage['text'] = "La contraseña es incorrecta";
			return sweetAlert($this->errorMessage);
		}

		$userData = [
			"ci" 		=> $user[0]["ci"],
			"name" 		=> $user[0]["name"],
			"privilege" => $user[0]["privilege"],
			"photo" 	=> $user[0]["photo"]
		];

		$this->session->set($userData);

		$this->successMessage['alert'] 	= "reload";
		$this->successMessage['title'] 	= "¡Bienvenido/a";
		$this->successMessage['text'] 	= $user[0]["name"];
		$this->successMessage['url'] 	= base_url();
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

		$ci = $this->request->getPost('ci');
		$password = crypt($this->request->getPost('password'), '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

		$userData = [
			"ci" 		=> $this->request->getPost('ci'),
			"name" 		=> $this->request->getPost('name'),
			"email" 	=> $this->request->getPost('email'),
			"password" 	=> $password,
			"privilege" => $this->request->getPost('privilege'),
			"photo" 	=> NULL
		];

		if($this->request->getFile('photo') != ''){
			$photoUpload = self::photoUpload($this->request->getFile('photo'), $ci);
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
		
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El usuario se ha creado correctamente";
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
                            <button type="button" class="btnUpdateUser btn btn-sm btn-primary waves-effect" user-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#updateUserModal">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="btnDeleteUser btn btn-sm btn-danger waves-effect" user-id="'.$row->id.'" photo="'.$row->photo.'">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>';
			}, 'last') 
			->toJson();
	}

	public function getUserById($id)
	{
		$usersModel = new UsersModel();
		$user = $usersModel->getUserById(['id' => $id]);
		if(!$user){
			return false;
		}
		return json_encode($user);
	}

	public function updateUser()
	{
		if(!$this->validate('updateUser')){
			
			// Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}
		}

		$ci = $this->request->getPost('ci');
		(empty($this->request->getPost('password')))
		?$password = $this->request->getPost('updatePasswordPreview')
		:$password = crypt($this->request->getPost('password'), '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

		$userData = [
			"ci" 			=> $ci,
			"name" 			=> $this->request->getPost('name'),
			"email" 		=> $this->request->getPost('email'),
			"password" 		=> $password,
			"privilege" 	=> $this->request->getPost('privilege'),
			"photo" 		=> $this->request->getPost('updatePhotoPreview'),
			"updated_at" 	=> date("Y-m-d H:i:s")
		];

		if($this->request->getFile('photo') != ''){
			self::deletePhoto($userData['photo']);
			$photoUpload = self::photoUpload($this->request->getFile('photo'), $ci);
			if(!$photoUpload){
				$this->errorMessage['text'] = "Ha ocurrido un error al subir la foto";
				return sweetAlert($this->errorMessage);
			}

			$userData["photo"] = $photoUpload;
		}

		$usersModel = new UsersModel();
		$user = $usersModel->updateUser($userData, $ci);

		if(!$user){
			$this->errorMessage['text'] = "Ha ocurrido un error al guardar los datos";
			return sweetAlert($this->errorMessage);
		}
		
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El usuario se ha actualizado correctamente";
		$this->successMessage['ajaxReload'] = "users";
		return sweetAlert($this->successMessage);
	}

	// Funciones parciales
	public function photoUpload($photo, $ci)
	{
		$photoName = $ci.'.'.explode('/', $photo->getMimeType())[1];
		
		if(file_exists(ROOTPATH.'public/uploads/users/'.$photoName)){
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

	public function deletePhoto($src){
		if(!empty($src)){
			$img = explode('/', $src);
			$img = end($img);
			if(file_exists(ROOTPATH.'public/uploads/users/'.$img)){
				unlink(ROOTPATH.'public/uploads/users/'.$img);
			}
			return true;
		}
		return false;
	}
}