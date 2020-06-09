<?php
	namespace Rafa\Http\Controllers;

	class UsersController {
		public function getall()
		{
			if (AuthController::checkAuth()) {
				return array(1 => 'Rafael', 2 => 'Bruna', 3 => 'Marcelo');
			}
			
			throw new \Exception('Não autenticado');
		}
	}