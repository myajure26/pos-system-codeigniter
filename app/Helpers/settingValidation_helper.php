<?php 


function settingValidation()
{
	$setting = [
		'identification' => [
			'label' => 'identification',
			'rules' => 'required|regex_match[^([VEJPG]{1})([-]{1})([0-9]{9})$]',
			'errors' => [
				'required' => 'El RIF es requerido',
				'regex_match' => 'El formato del RIF no es válido {value}',
			]
		],
		'systemName' => [
			'label' => 'systemName',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]',
			'errors' => [
				'required' => 'El nombre del sistema es requerido',
				'regex_match' => 'Para el nombre del sistema sólo se permiten carácteres alfabéticos.'
			]
		],
		'name' => [
			'label' => 'name',
			'rules' => 'required|regex_match[/^[a-zñáéíóúüA-ZÑÁÉÍÓÚÜ ]*$/u]',
			'errors' => [
				'required' => 'El nombre de la empresa es requerido',
				'regex_match' => 'Para el nombre de la empresa sólo se permiten carácteres alfabéticos.'
			]
		],
		'principalCoin' => [
			'label' => 'principalCoin',
			'rules' => 'required|is_not_unique[monedas.identificacion]',
			'errors' => [
				'required' => 'La moneda es requerida',
				'is_not_unique' => 'La moneda no se encuentra registrada'
			]
		],
		'nationalCoin' => [
			'label' => 'nationalCoin',
			'rules' => 'required|is_not_unique[monedas.identificacion]',
			'errors' => [
				'required' => 'La moneda es requerida',
				'is_not_unique' => 'La moneda no se encuentra registrada'
			]
		],
		'address' => [
			'label' => 'address',
			'rules' => 'required|regex_match[/^[a-z0-9ñáéíóúüA-ZÑÁÉÍÓÚÜ .,-]*$/u]',
			'errors' => [
				'required' => 'La dirección es requerida',
				'regex_match' => 'Para la dirección sólo se permiten carácteres alfabéticos y guiones.'
			]
		],
		'phone' => [
			'label' => 'phone',
			'rules' => 'required|regex_match[^(0414|0424|0412|0416|0426|0251)[0-9]{7}$]',
			'errors' => [
				'required' => 'El teléfono es requerido',
				'regex_match' => 'Ingresa un número de teléfono válido: 04121534253'
			]
		]
	];

	return $setting;
}