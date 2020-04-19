<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class IonAuth implements FilterInterface
{
   public function before(RequestInterface $request)
   {
       $auth = new \IonAuth\Libraries\IonAuth();

       if (!$auth->loggedIn()) {
     			return redirect()->to('/auth');
     	 }
   }

   public function after(RequestInterface $request, ResponseInterface $response)
   {

   }

}
