<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];
	protected $system = "";
	protected $principalCoin = "";
	protected $businessName = "";
	protected $businessIdentification = "";
	protected $businessAddress = "";
	protected $businessPhone = "";
	

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//Llamar a las funciones de Util
		helper('util');
		date_default_timezone_set("America/Caracas");

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
		$this->session = \Config\Services::session();

		if($this->session->has('system')){
			$this->system = $this->session->get('system');
			$this->principalCoin = $this->session->get('principalCoin');
			$this->businessName = $this->session->get('businessName');
			$this->businessIdentification = $this->session->get('businessIdentification');
			$this->businessAddress = $this->session->get('businessAddress');
			$this->businessPhone = $this->session->get('businessPhone');
		}else{
			$db      = \Config\Database::connect();
			$configuracion = $db
							->table('configuracion')
							->select('valor_configuracion');
			
			$systemName = $configuracion->where('nom_configuracion', 'sistema_nombre')->get()->getResult();
			$principalCoin = $configuracion->where('nom_configuracion', 'moneda_principal')->get()->getResult();
			$businessName = $configuracion->where('nom_configuracion', 'empresa_nombre')->get()->getResult();
			$businessIdentification = $configuracion->where('nom_configuracion', 'empresa_rif')->get()->getResult();
			$businessAddress = $configuracion->where('nom_configuracion', 'empresa_direccion')->get()->getResult();
			$businessPhone = $configuracion->where('nom_configuracion', 'empresa_telefono')->get()->getResult();

			$this->session->set(['system' 					=> $systemName[0]->valor_configuracion]);
			$this->session->set(['principalCoin' 			=> $principalCoin[0]->valor_configuracion]);
			$this->session->set(['businessName' 			=> $businessName[0]->valor_configuracion]);
			$this->session->set(['businessIdentification' 	=> $businessIdentification[0]->valor_configuracion]);
			$this->session->set(['businessAddress' 			=> $businessAddress[0]->valor_configuracion]);
			$this->session->set(['businessPhone' 			=> $businessPhone[0]->valor_configuracion]);

			$this->system = $this->session->get('system');
			$this->principalCoin = $this->session->get('principalCoin');
			$this->businessName = $this->session->get('businessName');
			$this->businessIdentification = $this->session->get('businessIdentification');
			$this->businessAddress = $this->session->get('businessAddress');
			$this->businessPhone = $this->session->get('businessPhone');

		}
		
		

	}
}
