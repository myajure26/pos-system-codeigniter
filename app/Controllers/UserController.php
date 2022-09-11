<?php 
namespace App\Controllers;
use App\Models\UserModel;
use App\Models\AuditModel;
use \Hermawan\DataTables\DataTable;

class UserController extends BaseController
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

	protected $auditContent = [
		"user"			=> "",
		"module"		=> "Usuarios",
		"action"		=> "",
		"description"	=> ""
	];

	public function signin()
	{
		if(!$this->validate('signin')){
			
			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$ci = $this->request->getPost('ci');
		$password = crypt($this->request->getPost('password'), '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

		$UserModel = new UserModel();
		$user = $UserModel->getUserById(['ci' => $ci]);

		if($user[0]['password'] != $password){
			$this->errorMessage['text'] = "La contraseña es incorrecta";
			return sweetAlert($this->errorMessage);
		}

		$userData = [
			"id"		=> $user[0]["id"],
			"ci" 		=> $user[0]["ci"],
			"name" 		=> $user[0]["name"],
			"privilege" => $user[0]["privilege"],
			"photo" 	=> $user[0]["photo"]
		];
		$date = date("Y-m-d H:i:s");
		$UserModel->updateUser(["last_session" => $date], $ci);

		$this->session->set($userData);

		//PARA LA AUDITORÍA
		$this->auditContent['user_id'] = $user[0]["id"];
		$this->auditContent['action'] = "Inicio de sesión";
		$this->auditContent['description'] = "El usuario ha iniciado sesión exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);

		//SWEET ALERT
		$this->successMessage['alert'] 	= "reload";
		$this->successMessage['title'] 	= "¡Bienvenido/a!";
		$this->successMessage['text'] 	= $user[0]["name"];
		$this->successMessage['url'] 	= base_url();
		return sweetAlert($this->successMessage);

	}

	public function createUser()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate('users')){
			
			//Mostrar errores de validación
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

		$UserModel = new UserModel();
		$user = $UserModel->createUser($userData);

		if(!$user){
			$this->errorMessage['text'] = "Ha ocurrido un error al guardar los datos";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] = $auditUserId;
		$this->auditContent['action'] = "Crear usuario";
		$this->auditContent['description'] = "Se ha creado al usuario con ID #" . $UserModel->getLastId() . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El usuario se ha creado correctamente";
		$this->successMessage['ajaxReload'] = "users";
		return sweetAlert($this->successMessage);
	}

	public function getUsers()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$UserModel = new UserModel();
				
		return DataTable::of($UserModel->getUsers())
			->edit('photo', function($row){

				if($row->photo == NULL){
					return '<img src="'.base_url('assets/images/users/anonymous.png').'" class="rounded-circle header-profile-user">';
				}

				return '<img src="'.$row->photo.'" class="rounded-circle header-profile-user">';
			})
			->add('Acciones', function($row){
				return '<div class="btn-list"> 
                            <button type="button" class="btnUpdateUser btn btn-sm btn-primary waves-effect" user-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#updateUserModal">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="btnDeleteUser btn btn-sm btn-danger waves-effect" user-id="'.$row->id.'" photo="'.$row->photo.'" ci="'.$row->ci.'">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>';
			}, 'last') 
			->toJson();
	}

	public function getUserById($id)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$UserModel = new UserModel();
		$user = $UserModel->getUserById(['id' => $id]);
		if(!$user){
			return false;
		}
		return json_encode($user);
	}

	public function updateUser()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate('updateUser')){
			
			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}
		}
		
		$id = $this->request->getPost('id');
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
			"photo" 		=> $this->request->getPost('updatePhotoPreview')
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

		$UserModel = new UserModel();
		$user = $UserModel->updateUser($userData, $ci);

		if(!$user){
			$this->errorMessage['text'] = "Ha ocurrido un error al guardar los datos";
			return sweetAlert($this->errorMessage);
		}
		
		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] = $auditUserId;
		$this->auditContent['action'] = "Actualizar usuario";
		$this->auditContent['description'] = "Se ha actualizado al usuario con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El usuario se ha actualizado correctamente";
		$this->successMessage['ajaxReload'] = "users";
		return sweetAlert($this->successMessage);
	}

	public function deleteUser()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$id = $this->request->getPost('id');
		$ci = $this->request->getPost('ci');
		$photo = $this->request->getPost('photo');

		$UserModel = new UserModel();
		$deleteUser = $UserModel->deleteUser($id);

		if(!$deleteUser){
			$this->errorMessage['text'] = "El usuario no existe";
			return sweetAlert($this->errorMessage);
		}

		self::deletePhoto($photo);

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('id');
		$this->auditContent['user_id'] = $auditUserId;
		$this->auditContent['action'] = "Eliminar usuario";
		$this->auditContent['description'] = "Se ha eliminado al usuario con ID #" . $id . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Usuario eliminado";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		$this->successMessage['ajaxReload'] = "users";
		return sweetAlert($this->successMessage);
	}

	//Funciones parciales
	public function photoUpload($photo, $ci)
	{
		$photoName = $ci.'.'.explode('/', $photo->getMimeType())[1];
		
		if(file_exists(ROOTPATH.'public/uploads/users/'.$photoName)){
			unlink(ROOTPATH.'public/uploads/users/'.$photoName);
		}

		if ($photo->isValid() && ! $photo->hasMoved()) {
		    $photo->move(ROOTPATH . 'public/uploads', $photoName);

		    //Redimensionar la foto
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