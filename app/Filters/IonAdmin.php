<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class IonAdmin implements FilterInterface
{
   public function before(RequestInterface $request)
   {
       $auth = new \IonAuth\Libraries\IonAuth();

       if (!$auth->isAdmin($auth->getUserId())) {
     			return redirect()->to('/');
     	 }
   }

   public function after(RequestInterface $request, ResponseInterface $response)
   {

   }

}
