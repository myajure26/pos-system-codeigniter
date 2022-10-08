<?php 

function createUserValidation()
{
	$user = [
		'ci' => [
			'label' => 'ci',
			'rules' => 'required|numeric|min_length[7]|max_length[8]|is_unique[users.ci]',
			'errors' => [
				'required' => 'La cédula es requerida',
				'numeric' => 'Para la cédula sólo se permiten números',
				'min_length' => 'Introduce una cédula válida',
				'max_length' => 'Introduce una cédula válida',
				'is_unique' => 'La cédula ya se encuentra registrada'
			]
		],
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]',
			'errors' => [
				'required' => 'El nombre es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos.'
			]
		],
		'email' => [
			'label' => 'email',
			'rules' => 'required|valid_email|is_unique[users.email]',
			'errors' => [
				'required' => 'El correo electrónico es requerido',
				'valid_email' => 'Por favor, introduce un correo electrónico válido',
				'is_unique' => 'El correo electrónico ya se encuentra registrado en la base de datos'
			]
		],
		'password' => [
			'label' => 'password',
			'rules' => 'required|min_length[8]',
			'errors' => [
				'required' => 'La contraseña es requerida',
				'min_length' => 'La contraseña debe tener una longitud mínima de 8 carácteres'
			]
		],
		'privilege' => [
			'label' => 'privilege',
			'rules' => 'required|in_list[admin, special, seller]',
			'errors' => [
				'required' => 'El privilegio es requerido',
				'in_list' => 'Por favor, elige un privilegio de la lista'
			]
		],
		'photo' => [
			'label' => 'photo',
			'rules' => 'max_size[photo,3000]|ext_in[photo,png,jpg,jpeg]',
			'errors' => [
				'max_size' => 'El tamaño de la foto tiene que ser menor a 3MB',
				'ext_in' => 'Para la foto sólo se aceptan los formatos png, jpg y jpeg'
			]
		]
	];

	return $user;
}

function updateUserValidation()
{
	$updateUser = [
		'ci' => [
			'label' => 'ci',
			'rules' => 'required|numeric|min_length[7]|max_length[8]|is_unique[users.ci,id,{id}]',
			'errors' => [
				'required' => 'La cédula es requerida',
				'numeric' => 'Para la cédula sólo se permiten números',
				'min_length' => 'Introduce una cédula válida',
				'max_length' => 'Introduce una cédula válida',
				'is_unique'	=> 'La cédula ya se encuentra registrada'
			]
		],
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]',
			'errors' => [
				'required' => 'El nombre es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos.'
			]
		],
		'email' => [
			'label' => 'email',
			'rules' => 'required|valid_email|is_unique[users.email,id,{id}]',
			'errors' => [
				'required' => 'El correo electrónico es requerido.',
				'valid_email' => 'Por favor, introduce un correo electrónico válido',
				'is_unique' => 'El correo electrónico ya se encuentra registrado en la base de datos'
			]
		],
		'privilege' => [
			'label' => 'privilege',
			'rules' => 'required|in_list[admin, special, seller]',
			'errors' => [
				'required' => 'El privilegio es requerido',
				'in_list' => 'Por favor, elige un privilegio de la lista'
			]
		],
		'photo' => [
			'label' => 'photo',
			'rules' => 'max_size[photo,3000]|ext_in[photo,png,jpg,jpeg]',
			'errors' => [
				'max_size' => 'El tamaño de la foto tiene que ser menor a 3MB',
				'ext_in' => 'Para la foto sólo se aceptan los formatos png, jpg y jpeg'
			]
		]
	];

	return $updateUser;
}