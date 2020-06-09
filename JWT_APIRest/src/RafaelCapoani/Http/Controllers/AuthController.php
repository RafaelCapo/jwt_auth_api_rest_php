<?php
    namespace Rafa\Http\Controllers;
    
    class AuthController {
        public function login(){

            if ($_POST['email'] == 'teste@gmail.com' && $_POST['password'] == '123') {
                //Application Key
                $key = '123456';

                //Header Token
                $header = [
                    'typ' => 'JWT',
                    'alg' => 'HS256'
                ];

                //Payload - Content
                $payload = [
                    'name' => 'Rafael Capoani',
                    'email' => $_POST['email'],
                ];

                //JSON
                $header = json_encode($header);
                $payload = json_encode($payload);

                //Base 64
                $header = base64_encode($header);
                $payload = base64_encode($payload);

                //Sign
                $sign = hash_hmac('sha256', $header . "." . $payload, $key, true);
                $sign = base64_encode($sign);

                //Token
                $token = $header . '.' . $payload . '.' . $sign;

                return $token;
            }
            
            throw new \Exception('Não autenticado');

        }

        public static function checkAuth()
        {
            $http_header = apache_request_headers();

            if (isset($http_header['Authorization']) && $http_header['Authorization'] != null) {
                $bearer = explode (' ', $http_header['Authorization']);
                //$bearer[0] = 'bearer';
                //$bearer[1] = 'token jwt';

                $token = explode('.', $bearer[1]);
                $header = $token[0];
                $payload = $token[1];
                $sign = $token[2];

                //Conferir Assinatura
                $valid = hash_hmac('sha256', $header . "." . $payload, '123456', true);
                $valid = base64_encode($valid);

                if ($sign === $valid) {
                    return true;
                }
            }

            return false;
        } 
    }