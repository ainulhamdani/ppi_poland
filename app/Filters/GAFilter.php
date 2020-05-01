<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Events\Events;

class GAFilter implements FilterInterface
{
   public $user_id;
   public function before(RequestInterface $request)
   {
       $auth = new \IonAuth\Libraries\IonAuth();
       $this->user_id = $auth->getUserId();
       Events::on('add_google_analytics_tag', function() {
       		echo \Config\GAnalytics::getTag($this->user_id);
       });
   }

   public function after(RequestInterface $request, ResponseInterface $response)
   {

   }

}
