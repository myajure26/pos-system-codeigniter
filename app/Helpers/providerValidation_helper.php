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
		'letter' => [
			'label' => 'rifLetter',
			'rules' => 'required|in_list[V, J, E, P, G]',
			'errors' => [
				'required' => 'El rif es requerido',
				'in_list' => 'La letra del rif no es válida'
			]
		],
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|min_length[9]|max_length[12]|regex_match[^([VEJPG]{1})([-]{1})([0-9]{9})$]|is_unique[providers.rif]',
			'errors' => [
				'required' => 'El rif es requerido',
				'min_length' => 'Introduce un rif válido',
				'max_length' => 'Introduce un rif válido',
				'regex_match' => 'El formato del rif no es válido',
				'is_unique' => 'El rif ya existe'
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

function updateProviderValidation()
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
		'letter' => [
			'label' => 'rifLetter',
			'rules' => 'required|in_list[V, J, E, P, G]',
			'errors' => [
				'required' => 'El rif es requerido',
				'in_list' => 'La letra del rif no es válida'
			]
		],
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|min_length[9]|max_length[12]|regex_match[^([VEJPG]{1})([-]{1})([0-9]{9})$]|is_unique[providers.rif,id,{id}]',
			'errors' => [
				'required' => 'El rif es requerido',
				'min_length' => 'Introduce un rif válido',
				'max_length' => 'Introduce un rif válido',
				'regex_match' => 'El formato del rif no es válido',
				'is_unique' => 'El rif ya existe'
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