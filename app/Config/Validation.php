<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single'
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------

	public $signin = [
		'username' => [
			'label' => 'username',
			'rules' => 'required|alpha_dash|is_not_unique[users.username]',
			'errors' => [
				'required' => 'El nombre de usuario es requerido.',
				'alpha_dash' => 'Para el nombre de usuario sólo se permiten carácteres alfanuméricos, guiones y guiones bajos.',
				'is_not_unique' => 'El nombre de usuario no existe'
			]
		],
		'password' => [
			'label' => 'password',
			'rules' => 'required|min_length[8]',
			'errors' => [
				'required' => 'La contraseña es requerida.',
				'min_length' => 'La contraseña debe tener una longitud mínima de 8 carácteres'
			]
		]
	];

	public $users = [
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ,.]*$/u]',
			'errors' => [
				'required' => 'El nombre es requerido.',
				'regex_match' => 'Para el nombre sólo se permiten carácteres alfabéticos.'
			]
		],
		'username' => [
			'label' => 'username',
			'rules' => 'required|alpha_dash|is_unique[users.username]',
			'errors' => [
				'required' => 'El nombre de usuario es requerido.',
				'alpha_dash' => 'Para el nombre de usuario sólo se permiten carácteres alfanuméricos, guiones y guiones bajos.',
				'is_unique' => 'El nombre de usuario ya se encuentra registrado en la base de datos'
			]
		],
		'email' => [
			'label' => 'email',
			'rules' => 'required|valid_email|is_unique[users.email]',
			'errors' => [
				'required' => 'El correo electrónico es requerido.',
				'valid_email' => 'Por favor, introduce un correo electrónico válido',
				'is_unique' => 'El correo electrónico ya se encuentra registrado en la base de datos'
			]
		],
		'password' => [
			'label' => 'password',
			'rules' => 'required|min_length[8]',
			'errors' => [
				'required' => 'La contraseña es requerida.',
				'min_length' => 'La contraseña debe tener una longitud mínima de 8 carácteres'
			]
		],
		'role' => [
			'label' => 'role',
			'rules' => 'required|in_list[admin, special, seller]',
			'errors' => [
				'required' => 'El rol es requerido.',
				'in_list' => 'Por favor, elige un rol válido'
			]
		],
		'photo' => [
			'label' => 'photo',
			'rules' => 'max_size[photo,3000]|ext_in[photo,png,jpg,jpeg]',
			'errors' => [
				'max_size' => 'El tamaño de la foto tiene que ser menor a 3MB',
				'ext_in' => 'Para la foto sólo se aceptan los formatos png, jpg y jpeg'
			]
		]
	];
	

}
