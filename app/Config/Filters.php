<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'     => \CodeIgniter\Filters\CSRF::class,
		'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot' => \CodeIgniter\Filters\Honeypot::class,
		'ionAuth' => \App\Filters\IonAuth::class,
		'ionAdmin' => \App\Filters\IonAdmin::class,
		'GA' => \App\Filters\GAFilter::class,
		'JWTFilter' => \App\Filters\JWTFilter::class,
	];

	// Always applied before every request
	public $globals = [
		'before' => [
			//'honeypot'
			'csrf' => ['except' => ['home/*','api/*']],
			'GA' => ['except' => ['api/*']],
		],
		'after'  => [
			'toolbar',
			//'honeypot'
		],
	];

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'post' => ['CSRF', 'throttle'],
	public $methods = [];

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	//    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
	public $filters = [
		'ionAuth' => ['before' => ['home/*', 'admin/*', 'profile/*']],
		'ionAdmin' => ['before' => ['admin/*']],
		'JWTFilter' => ['before' => ['api/post/*','api/email/*','api/user/*']],
	];
}
