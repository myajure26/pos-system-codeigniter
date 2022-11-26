<?php

function createBrandValidation()
{
	$brand = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|is_unique[marcas.marca]',
			'errors' => [
				'required' => 'El nombre de la marca es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos.',
				'is_unique' => 'El nombre de la marca ya existe'
			]
		]
	];

	return $brand;
}

function updateBrandValidation()
{
	$updateBrand = [
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|is_not_unique[marcas.identificacion]',
			'errors' => [
				'required' => 'La identificación de la marca es requerida',
				'is_not_unique' => 'La identificación de la marca no existe'
			]
		],
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|is_unique[marcas.marca,identificacion,{identification}]',
			'errors' => [
				'required' => 'El nombre de la marca es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos.',
				'is_unique' => 'El nombre de la marca ya existe'
			]
		]
	];

	return $updateBrand;
}