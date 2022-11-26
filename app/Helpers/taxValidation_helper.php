<?php 

function createTaxValidation()
{
	$tax = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ0-9 %]*$/u]|is_unique[impuestos.impuesto]',
			'errors' => [
				'required' => 'El nombre del impuesto es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfanuméricos y el símbolo de porcentaje (%).',
				'is_unique' => 'El nombre del impuesto ya existe'
			]
		],
		'percentage' => [
			'label' => 'percentage',
			'rules' => 'required|max_length[2]|integer',
			'errors' => [
				'required' => 'El porcentaje del impuesto es requerido',
				'max_length' => 'Para el porcentaje solo se permite un máximo de 2 números',
				'integer' => 'Para el porcentaje sólo se permiten números enteros'
			]
		]
	];
	return $tax;
}

function updateTaxValidation()
{
	$updateTax = [
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|is_not_unique[impuestos.identificacion]',
			'errors' => [
				'required' => 'La identificación del impuesto es requerida',
				'is_not_unique' => 'La identificación del impuesto no existe'
			]
		],
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ0-9 %]*$/u]|is_unique[impuestos.impuesto,identificacion,{identification}]',
			'errors' => [
				'required' => 'El nombre del impuesto es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfanuméricos y el símbolo de porcentaje (%).',
				'is_unique' => 'El nombre del impuesto ya existe'
			]
		],
		'percentage' => [
			'label' => 'percentage',
			'rules' => 'required|max_length[2]|integer',
			'errors' => [
				'required' => 'El porcentaje del impuesto es requerido',
				'max_length' => 'Para el porcentaje solo se permite un máximo de 2 números',
				'integer' => 'Para el porcentaje sólo se permiten números enteros'
			]
		]
	];

	return $updateTax;
}