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
		"usuario"		=> "",
		"modulo"		=> "Usuarios",
		"accion"		=> "",
		"descripcion"	=> ""
	];

	public function signin()
	{
		helper('signinValidation');

		if(!$this->validate(signinValidation())){
			
			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}

		}

		$identification = $this->request->getPost('identification');
		$password = crypt($this->request->getPost('password'), '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

		$UserModel = new UserModel();
		$user = $UserModel->getUserById(['identificacion' => $identification]);

		if($user[0]['clave'] != $password){
			$this->errorMessage['text'] = "La contraseña es incorrecta";
			return sweetAlert($this->errorMessage);
		}

		$userData = [
			"identification"		=> $user[0]["identificacion"],
			"name" 					=> $user[0]["nombre"],
			"privilege" 			=> $user[0]["privilegio"],
			"photo" 				=> $user[0]["foto"]
		];
		$date = date("Y-m-d H:i:s");
		$UserModel->updateUser(["ultima_sesion" => $date], $identification);

		$this->session->set($userData);

		//PARA LA AUDITORÍA
		$this->auditContent['usuario'] 		= $user[0]["identificacion"];
		$this->auditContent['accion'] 		= "Inicio de sesión";
		$this->auditContent['descripcion'] 	= "El usuario ha iniciado sesión exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);

		//SWEET ALERT
		$this->successMessage['alert'] 	= "reload";
		$this->successMessage['title'] 	= "¡Bienvenido/a!";
		$this->successMessage['text'] 	= $user[0]["nombre"];
		$this->successMessage['url'] 	= base_url();
		return sweetAlert($this->successMessage);

	}

	public function createUser()
	{
		helper('userValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(createUserValidation())){
			
			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}
		}

		$identification = $this->request->getPost('identification');
		$password = crypt($this->request->getPost('password'), '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

		$userData = [
			"identificacion" 		=> $this->request->getPost('identification'),
			"nombre" 				=> $this->request->getPost('name'),
			"correo" 				=> $this->request->getPost('email'),
			"clave" 				=> $password,
			"privilegio" 			=> $this->request->getPost('privilege'),
			"foto" 					=> NULL
		];

		if($this->request->getFile('photo') != ''){
			$photoUpload = self::photoUpload($this->request->getFile('photo'), $identification);
			if(!$photoUpload){
				$this->errorMessage['text'] = "Ha ocurrido un error al subir la foto";
				return sweetAlert($this->errorMessage);
			}

			$userData["foto"] = $photoUpload;
		}

		$UserModel = new UserModel();
		$user = $UserModel->createUser($userData);

		if(!$user){
			$this->errorMessage['text'] = $user;
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Crear usuario";
		$this->auditContent['descripcion'] 	= "Se ha creado al usuario con identificacion " . $identification . " exitosamente.";
		$AuditModel 						= new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El usuario se ha creado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function getUsers()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$UserModel = new UserModel();
				
		return DataTable::of($UserModel->getUsers())
			->edit('foto', function($row){

				if($row->foto == '' || $row->foto == NULL ){
					return '<img src="'.base_url('assets/images/users/anonymous.png').'" class="rounded-circle header-profile-user">';
				}

				return '<img src="'.$row->foto.'" class="rounded-circle header-profile-user">';
			})
			->edit('estado', function($row){
				
				if($row->estado == 0){
					return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-danger text-danger p-2 px-3">Desactivado</a></div>';
				}

				return '<div class="mt-sm-1 d-block"><a href="javascript:void(0)" class="badge bg-soft-success text-success p-2 px-3">Activado</a></div>';
			})
			->add('Acciones', function($row){
				if($row->estado == 1){
					return '<div class="btn-list"> 
								<button type="button" class="btnView btn btn-sm btn-primary waves-effect" data-id="'.$row->identificacion.'" data-type="users" data-bs-toggle="modal" data-bs-target="#viewModal">
									<i class="far fa-eye"></i>
								</button>
								<button type="button" class="btnDelete btn btn-sm btn-danger waves-effect" data-id="'.$row->identificacion.'" data-type="users" photo="'.$row->foto.'">
									<i class="far fa-trash-alt"></i>
								</button>
							</div>';
				}

				return '<div class="btn-list"> 
								<button type="button" class="btnRecover btn btn-sm btn-success waves-effect" data-id="'.$row->identificacion.'" data-type="users">
									<i class="fas fa-check"></i>
								</button>
							</div>';

			}, 'last')
			->filter(function ($builder, $request) {
        
				if ($request->status == ''){
					return true;
				}
				
				return $builder->where('usuarios.estado', $request->status);
		
			})
			->toJson();
	}

	public function getUserById($identification)
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$UserModel = new UserModel();
		$user = $UserModel->getUserById(['identificacion' => $identification]);
		if(!$user){
			return false;
		}
		return json_encode($user);
	}

	public function updateUser()
	{
		helper('userValidation');

		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		if(!$this->validate(updateUserValidation())){
			
			//Mostrar errores de validación
			$errors = $this->validator->getErrors();
			foreach ($errors as $error) {
				$this->errorMessage['text'] = esc($error);
				return sweetAlert($this->errorMessage);
			}
		}
	
		$identification = $this->request->getPost('identification');
		(empty($this->request->getPost('password')))
		?$password = $this->request->getPost('updatePasswordPreview')
		:$password = crypt($this->request->getPost('password'), '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

		$userData = [
			"identificacion"=> $identification,
			"nombre" 		=> $this->request->getPost('name'),
			"correo" 		=> $this->request->getPost('email'),
			"clave" 		=> $password,
			"privilegio" 	=> $this->request->getPost('privilege'),
			"foto" 			=> $this->request->getPost('viewPhotoPreview')
		];

		if($this->request->getFile('photo') != ''){
			self::deletePhoto($userData['foto']);
			$photoUpload = self::photoUpload($this->request->getFile('photo'), $identification);
			if(!$photoUpload){
				$this->errorMessage['text'] = "Ha ocurrido un error al subir la foto";
				return sweetAlert($this->errorMessage);
			}

			$userData["foto"] = $photoUpload;
		}

		$UserModel = new UserModel();
		$user = $UserModel->updateUser($userData, $identification);

		if(!$user){
			$this->errorMessage['text'] = "Ha ocurrido un error al guardar los datos";
			return sweetAlert($this->errorMessage);
		}
		
		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Actualizar usuario";
		$this->auditContent['descripcion'] 	= "Se ha actualizado al usuario con identificación " . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['text'] 		= "El usuario se ha actualizado correctamente";
		return sweetAlert($this->successMessage);
	}

	public function deleteUser()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');
		$photo = $this->request->getPost('photo');

		$UserModel = new UserModel();
		$deleteUser = $UserModel->deleteUser($identification);

		if(!$deleteUser){
			$this->errorMessage['text'] = "El usuario no existe";
			return sweetAlert($this->errorMessage);
		}

		self::deletePhoto($photo);

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Eliminar usuario";
		$this->auditContent['descripcion'] 	= "Se ha eliminado al usuario con identificación " . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "Usuario eliminado";
		$this->successMessage['text'] 		= "Puede recuperarlo desde la papelera";
		return sweetAlert($this->successMessage);
	}

	public function recoverUser()
	{
		if(!$this->session->has('name')){
			return redirect()->to(base_url());
		}

		$identification = $this->request->getPost('identification');

		$UserModel = new UserModel();
		$recoverUser = $UserModel->recoverUser($identification);

		if(!$recoverUser){
			$this->errorMessage['text'] = "El usuario no existe";
			return sweetAlert($this->errorMessage);
		}

		//PARA LA AUDITORÍA
		$auditUserId = $this->session->get('identification');
		$this->auditContent['usuario'] 		= $auditUserId;
		$this->auditContent['accion'] 		= "Recuperar usuario";
		$this->auditContent['descripcion'] 	= "Se ha recuperado al usuario con identificación " . $identification . " exitosamente.";
		$AuditModel = new AuditModel();
		$AuditModel->createAudit($this->auditContent);
		
		//SWEET ALERT
		$this->successMessage['alert'] 		= "clean";
		$this->successMessage['title'] 		= "¡Exito!";
		$this->successMessage['text'] 		= "El usuario ha sido recuperado";
		return sweetAlert($this->successMessage);
	}

	//Funciones parciales
	public function photoUpload($photo, $identification)
	{
		$photoName = $identification.'.'.explode('/', $photo->getMimeType())[1];
		
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