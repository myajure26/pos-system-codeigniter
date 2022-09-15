<?php 

function createTaxValidation()
{
	$tax = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|alpha_numeric_punct|is_unique[taxes.tax]',
			'errors' => [
				'required' => 'El nombre del impuesto es requerido',
				'alpha_numeric_punct' => 'Para el nombre sólo se permiten carácteres alfanuméricos y el símbolo de porcentaje (%).',
				'is_unique' => 'El nombre de la moneda ya existe'
			]
		],
		'percentage' => [
			'label' => 'percentage',
			'rules' => 'required|max_length[2]|numeric',
			'errors' => [
				'required' => 'El porcentaje de la moneda es requerido',
				'max_length' => 'Para el porcentaje solo se permite un máximo de 2 números',
				'numeric' => 'Para el porcentaje sólo se permiten números'
			]
		]
	];
	return $tax;
}

function updateTaxValidation()
{
	$updateTax = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|alpha_numeric_punct|is_unique[coins.coin,id,{id}]',
			'errors' => [
				'required' => 'El nombre de la moneda es requerido',
				'alpha_numeric_punct' => 'Para el nombre sólo se permiten carácteres alfanuméricos y el símbolo de porcentaje (%).',
				'is_unique' => 'El nombre de la moneda ya existe'
			]
		],
		'percentage' => [
			'label' => 'percentage',
			'rules' => 'required|max_length[2]|numeric',
			'errors' => [
				'required' => 'El porcentaje de la moneda es requerido',
				'max_length' => 'Para el porcentaje solo se permite un máximo de 2 números',
				'numeric' => 'Para el porcentaje sólo se permiten números'
			]
		]
	];

	return $updateTax;
}