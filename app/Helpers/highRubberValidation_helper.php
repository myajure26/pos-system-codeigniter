<?php

function createHighRubberValidation()
{
	$highRubber = [
		'highNumber' => [
			'label' => 'highNumber',
			'rules' => 'required|regex_match[/^[0-9]{0,3}$/u]|is_unique[alto_caucho.alto_numero]',
			'errors' => [
				'required' => 'La medida es requerida',
				'regex_match' => 'Para la medida solo se permiten números, máximo 3',
				'is_unique' => 'La medida ya existe'
			]
		]
	];

	return $highRubber;
}

function updateHighRubberValidation()
{
	$updateHighRubber = [
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|is_not_unique[alto_caucho.id_alto_caucho]',
			'errors' => [
				'required' => 'La identificación del alto caucho es requerida',
				'is_not_unique' => 'La identificación del alto caucho no existe'
			]
		],
		'highNumber' => [
			'label' => 'highNumber',
			'rules' => 'required|regex_match[/^[0-9]{0,3}$/u]|is_unique[alto_caucho.alto_numero,id_alto_caucho,{identification}]',
			'errors' => [
				'required' => 'La medida es requerida',
				'regex_match' => 'Para la medida solo se permiten números, máximo 3',
				'is_unique' => 'La medida ya existe'
			]
		]
	];

	return $updateHighRubber;
}