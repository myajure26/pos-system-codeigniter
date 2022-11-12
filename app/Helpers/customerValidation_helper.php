<?php 

function createCustomerValidation()
{
	$customer = [
		'letter' => [
			'label' => 'letter',
			'rules' => 'required|in_list[V, J, E, P, G]',
			'errors' => [
				'required' => 'La cédula/rif es requerida',
				'in_list' => 'La letra de la cédula/rif no es válida'
			]
		],
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|min_length[9]|max_length[12]|regex_match[^([VEJPG]{1})([-]{1})([0-9]{7,9})$]|is_unique[clientes.identificacion]',
			'errors' => [
				'required' => 'El rif es requerido',
				'min_length' => 'Introduce una cédula/rif válida',
				'max_length' => 'Introduce una cédula/rif válida',
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
			'rules' => 'required|numeric|max_length[11]|min_length[11]',
			'errors' => [
				'required' => 'El teléfono es requerido',
				'max_length' => 'Introduce un número válido',
				'min_length' => 'Introduce un número válido',
				'numeric' => 'Para el teléfono sólo se permiten números.'
			]
		]
	];

	return $customer;
}

function updateCustomerValidation()
{
	$updateCustomer = [
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|min_length[9]|max_length[12]|regex_match[^([VEJPG]{1})([-]{1})([0-9]{7,9})$]|is_not_unique[clientes.identificacion]',
			'errors' => [
				'required' => 'La cédula/rif es requerida',
				'min_length' => 'Introduce una cédula/rif válido',
				'max_length' => 'Introduce una cédula/rif válido',
				'regex_match' => 'El formato de la cédula/rif no es válido',
				'is_not_unique' => 'La cédula/rif no existe'
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
			'rules' => 'required|numeric|max_length[11]|min_length[11]',
			'errors' => [
				'required' => 'El teléfono es requerido',
				'max_length' => 'Introduce un número válido',
				'min_length' => 'Introduce un número válido',
				'numeric' => 'Para el teléfono sólo se permiten números.'
			]
		]
	];

	return $updateCustomer;
}