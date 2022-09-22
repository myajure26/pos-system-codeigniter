<?php 

function createProviderValidation()
{
	$provider = [
		'code' => [
			'label' => 'code',
			'rules' => 'required|alpha_numeric_punct|is_unique[providers.code]',
			'errors' => [
				'required' => 'El código es requerido',
				'alpha_numeric_punct' => 'Para el código sólo se permiten carácteres alfanuméricos y guiones',
				'is_unique' => 'El código ya se encuentra registrado'
			]
		],
		'rifLetter' => [
			'label' => 'rifLetter',
			'rules' => 'required|in_list[V, J, E, P, G]',
			'errors' => [
				'required' => 'El rif es requerido',
				'in_list' => 'La letra del rif no es válida'
			]
		],
		'rif' => [
			'label' => 'rif',
			'rules' => 'required|numeric|min_length[7]|max_length[10]|is_unique[providers.rif]',
			'errors' => [
				'required' => 'El rif es requerido',
				'numeric' => 'Para el rif sólo se permiten números',
				'min_length' => 'Introduce un rif válida',
				'max_length' => 'Introduce un rif válida',
				'is_unique' => 'El rif ya se encuentra registrado'
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
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]',
			'errors' => [
				'required' => 'La dirección es requerida',
				'regex_match' => 'Para la dirección sólo se permiten carácteres alfabéticos.'
			]
		],
		'phone' => [
			'label' => 'phone',
			'rules' => 'required|numeric|max_length[11]|min_length[11]',
			'errors' => [
				'required' => 'El teléfono es requerido',
				'max_length' => 'Introduce un número válido',
				'min_length' => 'Introduce un número válido',
				'numeric' => 'Para el teléfono sólo se permiten números.'
			]
		],
		'phone2' => [
			'label' => 'phone',
			'rules' => 'permit_empty|numeric|max_length[11]|min_length[11]',
			'errors' => [
				'max_length' => 'Introduce un número válido',
				'min_length' => 'Introduce un número válido',
				'numeric' => 'Para el teléfono sólo se permiten números.'
			]
		]
	];

	return $provider;
}

function updateUserValidation()
{
	$updateProvider = [
		'code' => [
			'label' => 'code',
			'rules' => 'required|alpha_numeric_punct|is_unique[providers.code,id,{id}]',
			'errors' => [
				'required' => 'El código es requerido',
				'alpha_numeric_punct' => 'Para el código sólo se permiten carácteres alfanuméricos y guiones',
				'is_unique' => 'El código ya se encuentra registrado'
			]
		],
		'rifLetter' => [
			'label' => 'rifLetter',
			'rules' => 'required|in_list[V, J, E, P, G]',
			'errors' => [
				'required' => 'El rif es requerido',
				'in_list' => 'La letra del rif no es válida'
			]
		],
		'rif' => [
			'label' => 'rif',
			'rules' => 'required|numeric|min_length[7]|max_length[10]|is_unique[providers.rif,id,{id}]',
			'errors' => [
				'required' => 'El rif es requerido',
				'numeric' => 'Para el rif sólo se permiten números',
				'min_length' => 'Introduce un rif válida',
				'max_length' => 'Introduce un rif válida',
				'is_unique' => 'El rif ya se encuentra registrada'
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
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]',
			'errors' => [
				'required' => 'La dirección es requerida',
				'regex_match' => 'Para la dirección sólo se permiten carácteres alfabéticos.'
			]
		],
		'phone' => [
			'label' => 'phone',
			'rules' => 'required|numeric|max_length[11]|min_length[11]',
			'errors' => [
				'required' => 'El teléfono es requerido',
				'max_length' => 'Introduce un número válido',
				'min_length' => 'Introduce un número válido',
				'numeric' => 'Para el teléfono sólo se permiten números.'
			]
		],
		'phone2' => [
			'label' => 'phone',
			'rules' => 'permit_empty|numeric|max_length[11]|min_length[11]',
			'errors' => [
				'max_length' => 'Introduce un número válido',
				'min_length' => 'Introduce un número válido',
				'numeric' => 'Para el teléfono sólo se permiten números.'
			]
		]

	];

	return $updateProvider;
}