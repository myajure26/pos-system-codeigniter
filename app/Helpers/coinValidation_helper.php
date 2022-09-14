<?php 

function createCoinValidation()
{
	$coin = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-z0-9ñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]|is_unique[coins.coin]',
			'errors' => [
				'required' => 'El nombre de la moneda es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfanuméricos.',
				'is_unique' => 'El nombre de la moneda ya existe'
			]
		],
		'symbol' => [
			'label' => 'symbol',
			'rules' => 'required|max_length[5]|alpha_numeric_punct',
			'errors' => [
				'required' => 'El símbolo de la moneda es requerido',
				'max_length' => 'Para el símbolo solo se permite un máximo de 5 carácteres',
				'alpha_numeric_punct' => 'Para el símbolo sólo se permiten carácteres alfanuméricos, espacio o este conjunto limitado de carácteres de puntuación: ~ (tilde), ! (exclamación), # (número), $ (dólar), % (porcentaje), & (ampersand), * (asterisco), - (guión), _ (guion bajo), + (más), = (igual), | (barra vertical), : (dos puntos), . (período).'
			]
		]
	];
	return $coin;
}

function updateCoinValidation()
{
	$updateCoin = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-z0-9ñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]|is_unique[coins.coin,id,{id}]',
			'errors' => [
				'required' => 'El nombre de la moneda es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfanuméricos.',
				'is_unique' => 'El nombre de la moneda ya existe'
			]
		],
		'symbol' => [
			'label' => 'symbol',
			'rules' => 'required|max_length[5]|alpha_numeric_punct',
			'errors' => [
				'required' => 'El símbolo de la moneda es requerido',
				'max_length' => 'Para el símbolo solo se permite un máximo de 5 carácteres',
				'alpha_numeric_punct' => 'Para el símbolo sólo se permiten carácteres alfanuméricos, espacio o este conjunto limitado de carácteres de puntuación: ~ (tilde), ! (exclamación), # (número), $ (dólar), % (porcentaje), & (ampersand), * (asterisco), - (guión), _ (guion bajo), + (más), = (igual), | (barra vertical), : (dos puntos), . (período).'
			]
		]
	];

	return $updateCoin;
}