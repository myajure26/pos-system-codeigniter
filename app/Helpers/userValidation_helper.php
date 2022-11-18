<?php 

function createUserValidation()
{
	$user = [
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|numeric|min_length[7]|max_length[8]|is_unique[usuarios.identificacion]',
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
			'rules' => 'required|valid_email|is_unique[usuarios.correo]',
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
			'rules' => 'required',
			'errors' => [
				'required' => 'El privilegio es requerido'
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
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|numeric|min_length[7]|max_length[8]|is_not_unique[usuarios.identificacion]',
			'errors' => [
				'required' => 'La cédula es requerida',
				'numeric' => 'Para la cédula sólo se permiten números',
				'min_length' => 'Introduce una cédula válida',
				'max_length' => 'Introduce una cédula válida',
				'is_not_unique'	=> 'La cédula no se encuentra registrada'
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
		'password' => [
			'label' => 'password',
			'rules' => 'permit_empty|min_length[8]',
			'errors' => [
				'min_length' => 'La contraseña debe tener una longitud mínima de 8 carácteres'
			]
		],
		'email' => [
			'label' => 'email',
			'rules' => 'required|valid_email|is_unique[usuarios.correo,identificacion,{identification}]',
			'errors' => [
				'required' => 'El correo electrónico es requerido.',
				'valid_email' => 'Por favor, introduce un correo electrónico válido',
				'is_unique' => 'El correo electrónico ya se encuentra registrado en la base de datos'
			]
		],
		'privilege' => [
			'label' => 'privilege',
			'rules' => 'required',
			'errors' => [
				'required' => 'El privilegio es requerido'
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

function updateCurrentUserValidation()
{
	$updateCurrentUser = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]',
			'errors' => [
				'required' => 'El nombre es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos.'
			]
		],
		'password' => [
			'label' => 'password',
			'rules' => 'permit_empty|min_length[8]',
			'errors' => [
				'min_length' => 'La contraseña debe tener una longitud mínima de 8 carácteres'
			]
		],
		'email' => [
			'label' => 'email',
			'rules' => 'required|valid_email|is_unique[usuarios.correo,identificacion,{identification}]',
			'errors' => [
				'required' => 'El correo electrónico es requerido.',
				'valid_email' => 'Por favor, introduce un correo electrónico válido',
				'is_unique' => 'El correo electrónico ya se encuentra registrado en la base de datos'
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

	return $updateCurrentUser;
}