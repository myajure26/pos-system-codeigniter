<?php 

function createSaleValidation()
{
	$sale = [
		'customer' => [
			'label' => 'customer',
			'rules' => 'required|regex_match[^([VEJPG]{1})([-]{1})([0-9]{7,9})$]|is_not_unique[clientes.identificacion]',
			'errors' => [
				'required' => 'El cliente es requerido',
				'regex_match' => 'Ingresa un cliente válido',
				'is_not_unique' => 'El cliente no existe'
			]
		],
		'receipt' => [
			'label' => 'receipt',
			'rules' => 'required|is_not_unique[tipo_documento.identificacion]',
			'errors' => [
				'required' => 'El comprobante es requerido',
				'is_not_unique' => 'El comprobante no existe'
			]
		],
		'tax' => [
			'label' => 'tax',
			'rules' => 'required|is_not_unique[impuestos.identificacion]',
			'errors' => [
				'required' => 'El impuesto es requerido',
				'is_not_unique' => 'El impuesto no existe'
			]
		],
		'paymentMethod' => [
			'label' => 'paymentMethod',
			'rules' => 'required|numeric|is_not_unique[metodo_pago.id_metodo_pago]',
			'errors' => [
				'required' => 'El método de pago es requerido',
				'numeric' => 'Ingresa un método de pago válido',
				'is_not_unique' => 'El método de pago no existe'
			]
		],
		'coin' => [
			'label' => 'coin',
			'rules' => 'required|numeric|is_not_unique[monedas.identificacion]',
			'errors' => [
				'required' => 'La moneda es requerida',
				'numeric' => 'Ingresa una moneda válida',
				'is_not_unique' => 'La moneda no existe'
			]
		],
		'rate' => [
			'label' => 'rate',
			'rules' => 'required|max_length[15]',
			'errors' => [
				'required' => 'La tasa es requerida',
				'max_length' => 'La tasa sobrepasa la longitud de carácteres'
			]
		],
		'productCode.*' => [
			'label' => 'productId',
			'rules' => 'required|alpha_numeric_punct|is_not_unique[productos.codigo]',
			'errors' => [
				'required' => 'El producto es requerido',
				'alpha_numeric_punct' => 'El producto {value} es incorrecto',
				'is_not_unique' => 'El producto {value} no existe'
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
			'rules' => 'required|max_length[15]',
			'errors' => [
				'required' => 'El precio es requerido',
				'max_length' => 'El precio no debe contener más de 15 carácteres'
			]
		]
		
	];

	return $sale;
}
