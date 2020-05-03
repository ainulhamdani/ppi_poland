<?php namespace App\Filters;

use Firebase\JWT\JWT;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\JWTConfig;

class JWTFilter implements FilterInterface
{
   public function before(RequestInterface $request)
   {
     $auth = $request->getServer('HTTP_AUTHORIZATION');
     if (!$auth) {
       http_response_code(401);
         echo json_encode(array(
          "message" => "Access denied.",
          "error" => "Authentication required"
      ));
      exit();
     }
     try {
       $userJwtModel = model('App\Models\UserJwtModel');
       $decoded = JWT::decode($auth, JWTConfig::$KEY, JWTConfig::$ALGO);
       $jwt = $userJwtModel->withWhere('token', $decoded->token)->first();
       if (!$jwt) {
         throw new \Exception('Invalid token');
       }
       $request->user = new \stdClass();
       $request->user = $decoded;
       return $request;
     } catch (\Exception $e) {
        http_response_code(401);

        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
        exit();
     }
   }

   public function after(RequestInterface $request, ResponseInterface $response)
   {

   }

}
