<?php 

function signinValidation()
{
	$signin = [
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|numeric|min_length[7]|max_length[8]|is_not_unique[usuarios.identificacion]',
			'errors' => [
				'required' => 'La cédula es requerida.',
				'numeric' => 'Para la cédula sólo se permiten números',
				'min_length' => 'Introduce una cédula válida',
				'max_length' => 'Introduce una cédula válida',
				'is_not_unique' => 'La cédula no existe'
			]
		],
		'password' => [
			'label' => 'password',
			'rules' => 'required|min_length[8]',
			'errors' => [
				'required' => 'La contraseña es requerida',
				'min_length' => 'La contraseña debe tener una longitud mínima de 8 carácteres'
			]
		]
	];

	return $signin;
}