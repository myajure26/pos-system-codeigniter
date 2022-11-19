<?php 

function createProviderValidation()
{
	$provider = [
		'code' => [
			'label' => 'code',
			'rules' => 'required|alpha_numeric_punct|is_unique[proveedores.codigo]',
			'errors' => [
				'required' => 'El código es requerido',
				'alpha_numeric_punct' => 'Para el código sólo se permiten carácteres alfanuméricos y guiones',
				'is_unique' => 'El código ya se encuentra registrado'
			]
		],
		'letter' => [
			'label' => 'rifLetter',
			'rules' => 'required|in_list[V, J, E, P, G]',
			'errors' => [
				'required' => 'La cédula/rif es requerida',
				'in_list' => 'La letra de la cédula/rif no es válida'
			]
		],
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|regex_match[^([VEJPG]{1})([-]{1})([0-9]{7,9})$]|is_unique[proveedores.identificacion]',
			'errors' => [
				'required' => 'La cédula/rif es requerida',
				'regex_match' => 'El formato de la cédula/rif no es válido',
				'is_unique' => 'La cédula/rif ya existe'
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
		'address' => [
			'label' => 'address',
			'rules' => 'required|regex_match[/^[a-z0-9ñáéíóúüA-ZÑÁÉÍÓÚÜ ~!#$%\&\*\-_+=|:.\/]*$/u]',
			'errors' => [
				'required' => 'La dirección es requerida',
				'regex_match' => 'Para la dirección sólo se permiten carácteres alfabéticos.'
			]
		],
		'phone' => [
			'label' => 'phone',
			'rules' => 'required|regex_match[^(0414|0424|0412|0416|0426|0251)[0-9]{7}$]',
			'errors' => [
				'required' => 'El teléfono es requerido',
				'regex_match' => 'Ingresa un número de teléfono válido: 04121534253'
			]
		]
	];

	return $provider;
}

function updateProviderValidation()
{
	$updateProvider = [
		'code' => [
			'label' => 'code',
			'rules' => 'required|alpha_numeric_punct|is_not_unique[proveedores.codigo]',
			'errors' => [
				'required' => 'El código es requerido',
				'alpha_numeric_punct' => 'Para el código sólo se permiten carácteres alfanuméricos y guiones',
				'is_not_unique' => 'El código no se encuentra registrado'
			]
		],
		'letter' => [
			'label' => 'rifLetter',
			'rules' => 'required|in_list[V, J, E, P, G]',
			'errors' => [
				'required' => 'La cédula/rif es requerida',
				'in_list' => 'La letra de la cédula/rif no es válida'
			]
		],
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|regex_match[^([VEJPG]{1})([-]{1})([0-9]{9})$]|is_unique[proveedores.identificacion,codigo,{code}]',
			'errors' => [
				'required' => 'La cédula/rif es requerida',
				'regex_match' => 'El formato de la cédula/rif no es válido',
				'is_unique' => 'La cédula/rif ya existe'
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
		'address' => [
			'label' => 'address',
			'rules' => 'required|regex_match[/^[a-z0-9ñáéíóúüA-ZÑÁÉÍÓÚÜ ~!#$%\&\*\-_+=|:.\/]*$/u]',
			'errors' => [
				'required' => 'La dirección es requerida',
				'regex_match' => 'Para la dirección sólo se permiten carácteres alfabéticos.'
			]
		],
		'phone' => [
			'label' => 'phone',
			'rules' => 'required|regex_match[^(0414|0424|0412|0416|0426|0251)[0-9]{7}$]',
			'errors' => [
				'required' => 'El teléfono es requerido',
				'regex_match' => 'Ingresa un número de teléfono válido: 04121534253'
			]
		]
	];

	return $updateProvider;
}