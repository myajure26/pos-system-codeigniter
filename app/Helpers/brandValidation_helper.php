<?php

function createBrandValidation()
{
	$brand = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-z0-9ñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]|is_unique[marcas.marca]',
			'errors' => [
				'required' => 'El nombre de la marca es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfanuméricos.',
				'is_unique' => 'El nombre de la marca ya existe'
			]
		]
	];

	return $brand;
}

function updateBrandValidation()
{
	$updateBrand = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-z0-9ñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]|is_unique[marcas.marca,identificacion,{identification}]',
			'errors' => [
				'required' => 'El nombre de la marca es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfanuméricos.',
				'is_unique' => 'El nombre de la marca ya existe'
			]
		]
	];

	return $updateBrand;
}