<?php 

function createProductValidation()
{
	$product = [
		'code' => [
			'label' => 'code',
			'rules' => 'required|alpha_numeric_punct|is_unique[productos.codigo]',
			'errors' => [
				'required' => 'El código es requerido',
				'alpha_numeric_punct' => 'Para el código sólo se permiten carácteres alfanuméricos y guiones',
				'is_unique' => 'El código ya se encuentra registrado'
			]
		],
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]',
			'errors' => [
				'required' => 'El nombre es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos'
			]
		],
		'brand' => [
			'label' => 'brand',
			'rules' => 'required|is_not_unique[marcas.identificacion]',
			'errors' => [
				'required' => 'La marca es requerida',
				'is_not_unique' => 'La marca no se encuentra registrada'
			]
		],
		'category' => [
			'label' => 'category',
			'rules' => 'required|is_not_unique[categorias.identificacion]',
			'errors' => [
				'required' => 'La categoría es requerida',
				'is_not_unique' => 'La categoría no se encuentra registrada'
			]
		],
		'coin' => [
			'label' => 'coin',
			'rules' => 'required|is_not_unique[monedas.identificacion]',
			'errors' => [
				'required' => 'La moneda es requerida',
				'is_not_unique' => 'La moneda no se encuentra registrada'
			]
		],
		'price' => [
			'label' => 'price',
			'rules' => 'required|max_length[15]',
			'errors' => [
				'required' => 'El precio es requerido',
				'max_length' => 'El precio no debe contener más de 15 carácteres'
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
			'rules' => 'required|alpha_numeric_punct|is_not_unique[productos.codigo]',
			'errors' => [
				'required' => 'El código es requerido',
				'alpha_numeric_punct' => 'Para el código sólo se permiten carácteres alfanuméricos',
				'is_not_unique' => 'El código no se encuentra registrado'
			]
		],
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]',
			'errors' => [
				'required' => 'El nombre es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos'
			]
		],
		'brand' => [
			'label' => 'brand',
			'rules' => 'required|is_not_unique[marcas.identificacion]',
			'errors' => [
				'required' => 'La marca es requerida',
				'is_not_unique' => 'La marca no se encuentra registrada'
			]
		],
		'category' => [
			'label' => 'category',
			'rules' => 'required|is_not_unique[categorias.identificacion]',
			'errors' => [
				'required' => 'La categoría es requerida',
				'is_not_unique' => 'La categoría no se encuentra registrada'
			]
		],
		'coin' => [
			'label' => 'coin',
			'rules' => 'required|is_not_unique[monedas.identificacion]',
			'errors' => [
				'required' => 'La moneda es requerida',
				'is_not_unique' => 'La moneda no se encuentra registrada'
			]
		],
		'price' => [
			'label' => 'price',
			'rules' => 'required|max_length[15]',
			'errors' => [
				'required' => 'El precio es requerido',
				'max_length' => 'El precio no debe contener más de 15 carácteres'
			]
		]
	];

	return $updateProduct;
}