<?php 

function createDocumentTypeValidation()
{
	$documentType = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]|is_unique[tipo_documento.nombre]',
			'errors' => [
				'required' => 'El nombre es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos',
				'is_unique' => 'El nombre ya existe'
			]
		]
	];
	return $documentType;
}

function updateDocumentTypeValidation()
{
	$updateDocumentType = [
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|is_not_unique[tipo_documento.identificacion]',
			'errors' => [
				'required' => 'La identificación del tipo de documento es requerida',
				'is_not_unique' => 'La identificación del tipo de documento no existe'
			]
		],
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]|is_unique[tipo_documento.nombre,identificacion,{identification}]',
			'errors' => [
				'required' => 'El nombre es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos',
				'is_unique' => 'El nombre ya existe'
			]
		]
	];

	return $updateDocumentType;
}