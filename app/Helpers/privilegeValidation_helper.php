<?php 

function createPrivilegeValidation()
{
	$privilege = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]|is_unique[privilegios.nombre]',
			'errors' => [
				'required' => 'El nombre es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos',
				'is_unique' => 'El nombre ya existe'
			]
		],
		'permissions' => [
			'label' => 'permissions',
			'rules' => 'required|numeric|in_list[1,2,3]',
			'errors' => [
				'required' => 'El permiso es requerido',
				'numeric' => 'Ingresa un permiso válido',
				'in_list' => 'Ingresa un permiso válido'
			]
		]

	];
	return $privilege;
}

function updatePrivilegeValidation()
{
	$updatePrivilege = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]|is_unique[privilegios.nombre,identificacion,{identification}]',
			'errors' => [
				'required' => 'El nombre es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos',
				'is_unique' => 'El nombre ya existe'
			]
		],
		'permissions' => [
			'label' => 'permissions',
			'rules' => 'required|numeric|in_list[1,2,3]',
			'errors' => [
				'required' => 'El permiso es requerido',
				'numeric' => 'Ingresa un permiso válido',
				'in_list' => 'Ingresa un permiso válido'
			]
		]
	];

	return $updatePrivilege;
}