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
			'rules' => 'required|alpha_dash',
			'errors' => [
				'required' => 'El nombre de usuario es requerido.',
				'alpha_dash' => 'Sólo se permiten carácteres alfanuméricos, guiones y guiones bajos.'
			]
		],
		'password' => [
			'label' => 'password',
			'rules' => 'required',
			'errors' => [
				'required' => 'La contraseña es requerida.'
			]
		]
	];
	

}
