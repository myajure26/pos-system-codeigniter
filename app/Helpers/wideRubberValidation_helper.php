<?php

function createWideRubberValidation()
{
	$wideRubber = [
		'wideNumber' => [
			'label' => 'wideNumber',
			'rules' => 'required|regex_match[/^[0-9]{0,3}$/u]|is_unique[ancho_caucho.ancho_numero]',
			'errors' => [
				'required' => 'La medida es requerida',
				'regex_match' => 'Para la medida solo se permiten números, máximo 3',
				'is_unique' => 'La medida ya existe'
			]
		]
	];

	return $wideRubber;
}

function updateWideRubberValidation()
{
	$updateWideRubber = [
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|is_not_unique[ancho_caucho.id_ancho_caucho]',
			'errors' => [
				'required' => 'La identificación del ancho caucho es requerida',
				'is_not_unique' => 'La identificación del ancho caucho no existe'
			]
		],
		'wideNumber' => [
			'label' => 'wideNumber',
			'rules' => 'required|regex_match[/^[0-9]{0,3}$/u]|is_unique[ancho_caucho.ancho_numero,id_ancho_caucho,{identification}]',
			'errors' => [
				'required' => 'La medida es requerida',
				'regex_match' => 'Para la medida solo se permiten números, máximo 3',
				'is_unique' => 'La medida ya existe'
			]
		]
	];

	return $updateWideRubber;
}