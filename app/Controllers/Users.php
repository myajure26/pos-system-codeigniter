<?php 
namespace App\Controllers;

class Users extends BaseController
{
	public function signin()
	{

		if($this->validate('signin')){
		
			return "Si";
		
		}else{
			
			if($this->validator->getError('username')){
				$error = esc($this->validator->getError('username'));
			}else{
				$error = esc($this->validator->getError('password'));
			}

			$response = [
				"alert" => "simple",
				"type" => "error",
				"title" => "Oops!",
				"text" => $error
			];
			
			return sweetAlert($response);
		}

	}
}