<?php 

function createProductValidation()
{
	$product = [
		'code' => [
			'label' => 'code',
			'rules' => 'required|alpha_numeric_punct|is_unique[products.code]',
			'errors' => [
				'required' => 'El código es requerido',
				'alpha_numeric_punct' => 'Para el código sólo se permiten carácteres alfanuméricos y guiones',
				'is_unique' => 'El código ya se encuentra registrado'
			]
		],
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]',
			'errors' => [
				'required' => 'El nombre es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos.'
			]
		],
		'brand' => [
			'label' => 'brand',
			'rules' => 'required',
			'errors' => [
				'required' => 'La marca es requerida'
			]
		],
		'category' => [
			'label' => 'category',
			'rules' => 'required',
			'errors' => [
				'required' => 'La categoría es requerida'
			]
		],
		'coin' => [
			'label' => 'coin',
			'rules' => 'required',
			'errors' => [
				'required' => 'La moneda es requerida'
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
		'tax' => [
			'label' => 'tax',
			'rules' => 'required',
			'errors' => [
				'required' => 'El impuesto es requerido'
			]
		]
	];

	return $product;
}

function updateProductValidation()
{
	$updateProduct = [
		'code' => [
			'label' => 'code',
			'rules' => 'required|alpha_numeric|is_unique[products.code,id,{id}]',
			'errors' => [
				'required' => 'El código es requerido',
				'alpha_numeric' => 'Para el código sólo se permiten carácteres alfanuméricos',
				'is_unique' => 'El código ya se encuentra registrado'
			]
		],
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]',
			'errors' => [
				'required' => 'El nombre es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos.'
			]
		],
		'brand' => [
			'label' => 'brand',
			'rules' => 'required',
			'errors' => [
				'required' => 'La marca es requerida'
			]
		],
		'category' => [
			'label' => 'category',
			'rules' => 'required',
			'errors' => [
				'required' => 'La categoría es requerida'
			]
		],
		'coin' => [
			'label' => 'coin',
			'rules' => 'required',
			'errors' => [
				'required' => 'La moneda es requerida'
			]
		],
		'price' => [
			'label' => 'price',
			'rules' => 'required|max_length[10]',
			'errors' => [
				'required' => 'El precio es requerido',
				'max_length' => 'El precio no debe contener más de 15 carácteres'
			]
		],
		'tax' => [
			'label' => 'tax',
			'rules' => 'required',
			'errors' => [
				'required' => 'El impuesto es requerido'
			]
		]
	];

	return $updateProduct;
}