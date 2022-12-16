<?php 

function createProductValidation()
{
	$product = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]',
			'errors' => [
				'required' => 'El nombre es requerido',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos'
			]
		],
		'high' => [
			'label' => 'high',
			'rules' => 'required|is_not_unique[alto_caucho.id_alto_caucho]',
			'errors' => [
				'required' => 'La altura es requerida',
				'is_not_unique' => 'La altura no se encuentra registrada'
			]
		],
		'wide' => [
			'label' => 'wide',
			'rules' => 'required|is_not_unique[ancho_caucho.id_ancho_caucho]',
			'errors' => [
				'required' => 'El ancho es requerido',
				'is_not_unique' => 'El ancho no se encuentra registrado'
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
		'price' => [
			'label' => 'price',
			'rules' => 'required|max_length[15]',
			'errors' => [
				'required' => 'El precio es requerido',
				'max_length' => 'El precio no debe contener más de 15 carácteres'
			]
		],
		'maxStock' => [
			'label' => 'price',
			'rules' => 'required|regex_match[/^[0-9]{0,5}$/u]|',
			'errors' => [
				'required' => 'El stock máximo es requerido',
				'regex_match' => 'El stock máximo no debe contener más de 5 carácteres'
			]
		],
		'minStock' => [
			'label' => 'price',
			'rules' => 'required|regex_match[/^[0-9]{0,5}$/u]|',
			'errors' => [
				'required' => 'El stock mínimo es requerido',
				'regex_match' => 'El stock mínimo no debe contener más de 5 carácteres'
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
			'rules' => 'required|is_not_unique[productos.codigo]',
			'errors' => [
				'required' => 'El código es requerido',
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
		'high' => [
			'label' => 'high',
			'rules' => 'required|is_not_unique[alto_caucho.id_alto_caucho]',
			'errors' => [
				'required' => 'La altura es requerida',
				'is_not_unique' => 'La altura no se encuentra registrada'
			]
		],
		'wide' => [
			'label' => 'wide',
			'rules' => 'required|is_not_unique[ancho_caucho.id_ancho_caucho]',
			'errors' => [
				'required' => 'El ancho es requerido',
				'is_not_unique' => 'El ancho no se encuentra registrado'
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
		'price' => [
			'label' => 'price',
			'rules' => 'required|max_length[15]',
			'errors' => [
				'required' => 'El precio es requerido',
				'max_length' => 'El precio no debe contener más de 15 carácteres'
			]
		],
		'maxStock' => [
			'label' => 'price',
			'rules' => 'required|regex_match[/^[0-9]{0,5}$/u]|',
			'errors' => [
				'required' => 'El stock máximo es requerido',
				'regex_match' => 'El stock máximo no debe contener más de 5 carácteres'
			]
		],
		'minStock' => [
			'label' => 'price',
			'rules' => 'required|regex_match[/^[0-9]{0,5}$/u]|',
			'errors' => [
				'required' => 'El stock mínimo es requerido',
				'regex_match' => 'El stock mínimo no debe contener más de 5 carácteres'
			]
		]	
	];

	return $updateProduct;
}