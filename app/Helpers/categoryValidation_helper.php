<?php 

function createCategoryValidation()
{
	$category = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-z0-9ñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]|is_unique[categorias.categoria]',
			'errors' => [
				'required' => 'El nombre de la categoría es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfanuméricos.',
				'is_unique' => 'El nombre de la categoría ya existe'
			]
		]
	];
	return $category;
}

function updateCategoryValidation()
{
	$updateCategory = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-z0-9ñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]|is_unique[categorias.categoria,identificacion,{identification}]',
			'errors' => [
				'required' => 'El nombre de la categoría es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfanuméricos.',
				'is_unique' => 'El nombre de la categoría ya existe'
			]
		]
	];

	return $updateCategory;
}