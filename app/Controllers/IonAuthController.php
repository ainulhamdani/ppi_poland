<?php
namespace App\Controllers;

class IonAuthController extends BaseController
{
  /**
	 *
	 * @var array
	 */
	public $data = [];

	/**
	 * Configuration
	 *
	 * @var \IonAuth\Config\IonAuth
	 */
	protected $configIonAuth;

	/**
	 * IonAuth library
	 *
	 * @var \IonAuth\Libraries\IonAuth
	 */
	protected $ionAuth;

	/**
	 * Session
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	/**
	 * Validation library
	 *
	 * @var \CodeIgniter\Validation\Validation
	 */
	protected $validation;

	/**
	 * Validation list template.
	 *
	 * @var string
	 * @see https://bcit-ci.github.io/CodeIgniter4/libraries/validation.html#configuration
	 */
	protected $validationListTemplate = 'list';

	/**
	 * Views folder
	 * Set it to 'auth' if your views files are in the standard application/Views/auth
	 *
	 * @var string
	 */
	protected $viewsFolder = 'auth';

  /**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
    $this->ionAuth    = new \IonAuth\Libraries\IonAuth();
    $this->security    = \Config\Services::security();
    helper(['form', 'url']);
    $this->configIonAuth = config('IonAuth');

		if (! empty($this->configIonAuth->templates['errors']['list']))
		{
			$this->validationListTemplate = $this->configIonAuth->templates['errors']['list'];
		}

		if ($this->ionAuth->loggedIn()) {
			$photoModel = model('App\Models\StudentPhotoModel');
			$notificationModel = model('App\Models\NotificationModel');
			$notificationTypeModel = model('App\Models\NotificationTypeModel');

			$notificationTypes = $notificationTypeModel->findAll();

			$this->data['username'] = $this->session->get('nickname');
			$this->data['fullname'] = $this->session->get('fullname');
			$this->data['user_id'] = $this->ionAuth->getUserId();
			$this->data['is_active'] =  $this->ionAuth->where('id', $this->ionAuth->getUserId())->users()->row()->active;
			$this->data['is_admin'] = $this->ionAuth->isAdmin($this->ionAuth->getUserId());
			$this->data['photo'] = $photoModel->withWhere('user_id',$this->ionAuth->getUserId())->first();

			$this->data['notifications'] = $notificationModel
				->withSelect(['notification.id',
						'MAX(notification_type_id) as notification_type_id',
						'MAX(user_to) as user_to',
						'MAX(user_from) as user_from',
						'MAX(post_id) as post_id',
						'MAX(comment_id) as comment_id',
						'MIN(is_read) as is_read',
						'MAX(created_at) as created_at',
						'MAX(notification_type.name) as name',
						'MAX(notification_type.content) as content',
						'MAX(notification_type.url) as url',
						'MAX(notification_type.options) as options',
						'users.fullname as from'])
				->withJoin('notification_type','id','notification_type_id')
				->withJoin('users','id','user_from')
				->withWhere('is_read', 0)
				->withWhere('user_to', $this->data['user_id'])
				->withGroupBy('id,notification_type_id,user_to,user_from,post_id,users.fullname')
				->withOrderBy('created_at','DESC')
				->findAll();
		}
	}
}
