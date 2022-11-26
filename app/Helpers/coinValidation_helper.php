<?php 

function createCoinValidation()
{
	$coin = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|is_unique[monedas.moneda]',
			'errors' => [
				'required' => 'El nombre de la moneda es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos.',
				'is_unique' => 'El nombre de la moneda ya existe'
			]
		],
		'symbol' => [
			'label' => 'symbol',
			'rules' => 'required|max_length[5]|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ $€¥.,]*$/u]',
			'errors' => [
				'required' => 'El símbolo de la moneda es requerido',
				'max_length' => 'Para el símbolo solo se permite un máximo de 5 carácteres',
				'regex_match' => 'El símbolo no debe ir vacío, ni contener números o carácteres especiales'
			]
		]
	];
	return $coin;
}

function updateCoinValidation()
{
	$updateCoin = [
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|is_not_unique[monedas.identificacion]',
			'errors' => [
				'required' => 'La identificación de la moneda es requerida',
				'is_not_unique' => 'La identificación de la moneda no existe'
			]
		],
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]|is_unique[monedas.moneda,identificacion,{identification}]',
			'errors' => [
				'required' => 'El nombre de la moneda es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos.',
				'is_unique' => 'El nombre de la moneda ya existe'
			]
		],
		'symbol' => [
			'label' => 'symbol',
			'rules' => 'required|max_length[5]|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ $€¥.,]*$/u]',
			'errors' => [
				'required' => 'El símbolo de la moneda es requerido',
				'max_length' => 'Para el símbolo solo se permite un máximo de 5 carácteres',
				'regex_match' => 'El símbolo no debe ir vacío, ni contener números o carácteres especiales'
			]
		]
	];

	return $updateCoin;
}