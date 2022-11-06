<?php 

function createCoinPriceValidation()
{
	$coinPrice = [
		'principalCoin' => [
			'label' => 'principalCoin',
			'rules' => 'required|is_not_unique[monedas.identificacion]|differs[secondaryCoin]',
			'errors' => [
				'required' => 'La moneda principal es requerida',
				'is_not_unique' => 'La moneda principal no se encuentra registrada',
				'differs'	=> 'Las monedas tienen que ser diferentes'
			]
		],
		'secondaryCoin' => [
			'label' => 'secondaryCoin',
			'rules' => 'required|is_not_unique[monedas.identificacion]|differs[principalCoin]',
			'errors' => [
				'required' => 'La moneda secundaria es requerida',
				'is_not_unique' => 'La moneda secundaria no se encuentra registrada',
				'differs'	=> 'Las monedas tienen que ser diferentes'
			]
		],
		'price' => [
			'label' => 'price',
			'rules' => 'required|max_length[10]',
			'errors' => [
				'required' => 'El precio es requerido',
				'max_length' => 'El precio no debe contener más de 10 carácteres'
			]
		],
	];

	return $coinPrice;
}

function updateCoinPriceValidation()
{
	$updateCoinPrice = [
		'principalCoin' => [
			'label' => 'principalCoin',
			'rules' => 'required|is_not_unique[monedas.identificacion]|differs[secondaryCoin]',
			'errors' => [
				'required' => 'La moneda principal es requerida',
				'is_not_unique' => 'La moneda principal no se encuentra registrada',
				'differs'	=> 'Las monedas tienen que ser diferentes'
			]
		],
		'secondaryCoin' => [
			'label' => 'secondaryCoin',
			'rules' => 'required|is_not_unique[monedas.identificacion]|differs[principalCoin]',
			'errors' => [
				'required' => 'La moneda secundaria es requerida',
				'is_not_unique' => 'La moneda secundaria no se encuentra registrada',
				'differs'	=> 'Las monedas tienen que ser diferentes'
			]
		],
		'price' => [
			'label' => 'price',
			'rules' => 'required|max_length[10]',
			'errors' => [
				'required' => 'El precio es requerido',
				'max_length' => 'El precio no debe contener más de 10 carácteres'
			]
		],
	];

	return $updateCoinPrice;
}