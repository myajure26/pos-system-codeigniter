<?php 

function createPaymentMethodValidation()
{
	$paymentMethod = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]|is_unique[metodo_pago.nombre]',
			'errors' => [
				'required' => 'El nombre del método de pago es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos.',
				'is_unique' => 'El nombre del método de pago ya existe'
			]
		]
	];
	return $paymentMethod;
}

function updatePaymentMethodValidation()
{
	$updatePaymentMethod = [
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|is_not_unique[metodo_pago.id_metodo_pago]',
			'errors' => [
				'required' => 'La identificación del método de pago es requerida',
				'is_not_unique' => 'La identificación del método de pago no existe'
			]
		],
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]|is_unique[metodo_pago.nombre,id_metodo_pago,{identification}]',
			'errors' => [
				'required' => 'El nombre del método de pago es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos.',
				'is_unique' => 'El nombre del método de pago ya existe'
			]
		]
	];

	return $updatePaymentMethod;
}