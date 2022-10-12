<?php 

function createPurchaseValidation()
{
	$purchase = [
		'date' => [
			'label' => 'date',
			'rules' => 'required|valid_date',
			'errors' => [
				'required' => 'La fecha es requerida',
				'valid_date' => 'La fecha tiene que tener un formato dd/mm/aaaa'
			]
		],
		'provider' => [
			'label' => 'provider',
			'rules' => 'required|numeric|is_not_unique[providers.id]',
			'errors' => [
				'required' => 'El proveedor es requerido',
				'numeric' => 'Ingresa un proveedor válido',
				'is_not_unique' => 'El proveedor no existe'
			]
		],
		'receipt' => [
			'label' => 'receipt',
			'rules' => 'required|in_list[invoice, deliveryNote]',
			'errors' => [
				'required' => 'El comprobante es requerido',
				'in_list' => 'Selecciona un comprobante válido'
			]
		],
		'reference' => [
			'label' => 'reference',
			'rules' => 'required|numeric|is_unique[purchases.reference]',
			'errors' => [
				'required' => 'El número de referencia es requerido',
				'numeric' => 'El número de referencia debe contenter números solamente',
				'is_unique' => 'El número de referencia ya existe'
			]
		],
		'tax' => [
			'label' => 'tax',
			'rules' => 'required|numeric|is_not_unique[taxes.id]',
			'errors' => [
				'required' => 'El impuesto es requerido',
				'numeric' => 'Ingresa un impuesto válido',
				'is_not_unique' => 'El impuesto no existe'
			]
		],
		'coin' => [
			'label' => 'coin',
			'rules' => 'required|numeric|is_not_unique[coins.id]',
			'errors' => [
				'required' => 'La moneda es requerida',
				'numeric' => 'Ingresa una moneda válida',
				'is_not_unique' => 'La moneda no existe'
			]
		],
		'productId.*' => [
			'label' => 'productId',
			'rules' => 'required|numeric|is_not_unique[products.id]',
			'errors' => [
				'required' => 'El producto es requerido',
				'numeric' => 'El producto #{value} es incorrecto',
				'is_not_unique' => 'El producto #{value} no existe'
			]
		],
		'productQuantity.*' => [
			'label' => 'productQuantity',
			'rules' => 'required|numeric',
			'errors' => [
				'required' => 'La cantidad del producto es requerida',
				'numeric' => 'Solo se permiten números para la cantidad'
			]
		],
		'productPrice.*' => [
			'label' => 'productPrice',
			'rules' => 'required|max_length[10]',
			'errors' => [
				'required' => 'El precio es requerido',
				'max_length' => 'El precio no debe contener más de 10 carácteres'
			]
		]
		
	];

	return $purchase;
}

function updatePurchaseValidation()
{
		$updatePurchase = [
		'date' => [
			'label' => 'date',
			'rules' => 'required|valid_date',
			'errors' => [
				'required' => 'La fecha es requerida',
				'valid_date' => 'La fecha tiene que tener un formato dd/mm/aaaa'
			]
		],
		'provider' => [
			'label' => 'provider',
			'rules' => 'required|numeric|is_not_unique[providers.id]',
			'errors' => [
				'required' => 'El proveedor es requerido',
				'numeric' => 'Ingresa un proveedor válido',
				'is_not_unique' => 'El proveedor no existe'
			]
		],
		'receipt' => [
			'label' => 'receipt',
			'rules' => 'required|in_list[invoice, deliveryNote]',
			'errors' => [
				'required' => 'El comprobante es requerido',
				'in_list' => 'Selecciona un comprobante válido'
			]
		],
		'reference' => [
			'label' => 'reference',
			'rules' => 'required|numeric|is_unique[purchases.reference,id,{id}]',
			'errors' => [
				'required' => 'El número de referencia es requerido',
				'numeric' => 'El número de referencia debe contenter números solamente',
				'is_unique' => 'El número de referencia ya existe'
			]
		],
		'tax' => [
			'label' => 'tax',
			'rules' => 'required|numeric|is_not_unique[taxes.id]',
			'errors' => [
				'required' => 'El impuesto es requerido',
				'numeric' => 'Ingresa un impuesto válido',
				'is_not_unique' => 'El impuesto no existe'
			]
		],
		'coin' => [
			'label' => 'coin',
			'rules' => 'required|numeric|is_not_unique[coins.id]',
			'errors' => [
				'required' => 'La moneda es requerida',
				'numeric' => 'Ingresa una moneda válida',
				'is_not_unique' => 'La moneda no existe'
			]
		],
		'productId.*' => [
			'label' => 'productId',
			'rules' => 'required|numeric|is_not_unique[products.id]',
			'errors' => [
				'required' => 'El producto es requerido',
				'numeric' => 'El producto #{value} es incorrecto',
				'is_not_unique' => 'El producto #{value} no existe'
			]
		],
		'productQuantity.*' => [
			'label' => 'productQuantity',
			'rules' => 'required|numeric',
			'errors' => [
				'required' => 'La cantidad del producto es requerida',
				'numeric' => 'Solo se permiten números para la cantidad'
			]
		],
		'productPrice.*' => [
			'label' => 'productPrice',
			'rules' => 'required|max_length[10]',
			'errors' => [
				'required' => 'El precio es requerido',
				'max_length' => 'El precio no debe contener más de 10 carácteres'
			]
		]
		
	];

	return $updatePurchase;
}