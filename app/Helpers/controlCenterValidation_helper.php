<?php 

function createCoinPriceValidation()
{
	$coinPrice = [
		'secondaryCoin' => [
			'label' => 'secondaryCoin',
			'rules' => 'required|is_not_unique[monedas.identificacion]',
			'errors' => [
				'required' => 'La moneda secundaria es requerida',
				'is_not_unique' => 'La moneda secundaria no se encuentra registrada'
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
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|is_not_unique[precio_monedas.identificacion]',
			'errors' => [
				'required' => 'La identificación de la transacción es requerida',
				'is_not_unique' => 'La identificación de la transacción no existe'
			]
		],
		'secondaryCoin' => [
			'label' => 'secondaryCoin',
			'rules' => 'required|is_not_unique[monedas.identificacion]',
			'errors' => [
				'required' => 'La moneda secundaria es requerida',
				'is_not_unique' => 'La moneda secundaria no se encuentra registrada'
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