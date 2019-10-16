<?php namespace App\Controllers;

use App\Core\ThemeTrait;
use App\Theme\MetaCollection;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Email;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;
use Psr\Log\LoggerInterface;
use Config\Services;

class AuthController extends \Myth\Auth\Controllers\AuthController
{
    use ThemeTrait;

	protected $auth;

	/**
	 * @var Auth
	 */
	protected $config;

	/**
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	public function __construct()
	{
		// Most services in this controller require
		// the session to be started - so fire it up!
		$this->session = session();

		$this->config = config('Auth');
		$this->auth = service('authentication');
	}

    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param LoggerInterface   $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Ensure our site-wide helpers are loaded without messing up per-controller settings.
        $this->helpers = array_merge($this->helpers, ['asset', 'auth']);
        $this->meta = new MetaCollection();

        parent::initController($request, $response, $logger);
    }

	//--------------------------------------------------------------------
	// Login/out
	//--------------------------------------------------------------------

	/**
	 * Displays the login form, or redirects
	 * the user to their destination/home if
	 * they are already logged in.
	 */
	public function login()
	{
		// No need to show a login form if the user
		// is already logged in.
		if ($this->auth->check())
		{
			$redirectURL = session('redirect_url') ?? '/';
			unset($_SESSION['redirect_url']);

			return redirect()->to($redirectURL);
		}

		echo $this->render($this->config->views['login'], ['config' => $this->config]);
	}

	/**
	 * Attempts to verify the user's credentials
	 * through a POST request.
	 */
	public function attemptLogin()
	{
		$rules = [
			'login'	=> 'required',
			'password' => 'required',
		];
		if ($this->config->validFields == ['email'])
		{
			$rules['login'] .= '|valid_email';
		}

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$login = $this->request->getPost('login');
		$password = $this->request->getPost('password');
		$remember = (bool)$this->request->getPost('remember');

		// Determine credential type
		$type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		// Try to log them in...
		if (! $this->auth->attempt([$type => $login, 'password' => $password], $remember))
		{
			return redirect()->back()->withInput()->with('error', $this->auth->error() ?? lang('Auth.badAttempt'));
		}

		// Is the user being forced to reset their password?
		if ($this->auth->user()->force_pass_reset === true)
		{
			return redirect('change_pass');
		}

		$redirectURL = session('redirect_url') ?? '/';
		unset($_SESSION['redirect_url']);

		return redirect()->to($redirectURL)->with('message', lang('Auth.loginSuccess'));
	}

	/**
	 * Log the user out.
	 */
	public function logout()
	{
		if ($this->auth->check())
		{
			$this->auth->logout();
		}

		return redirect('/');
	}

	//--------------------------------------------------------------------
	// Register
	//--------------------------------------------------------------------

	/**
	 * Displays the user registration page.
	 */
	public function register()
	{
		// Check if registration is allowed
		if (! $this->config->allowRegistration)
		{
			return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
		}

		echo $this->render($this->config->views['register'], ['config' => $this->config]);
	}

	/**
	 * Attempt to register a new user.
	 */
	public function attemptRegister()
	{
		// Check if registration is allowed
		if (! $this->config->allowRegistration)
		{
			return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
		}

		$users = new UserModel();

		// Validate here first, since some things,
		// like the password, can only be validated properly here.
		$rules = array_merge($users->getValidationRules(['only' => ['username']]), [
			'email'		=> 'required|valid_email|is_unique[users.email]',
			'password'	 => 'required|strong_password',
			'pass_confirm' => 'required|matches[password]',
		]);

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $users->errors());
		}

		// Save the user
		$user = new User($this->request->getPost());

		$this->config->requireActivation !== false ? $user->generateActivateHash() : $user->activate();

		if (! $users->save($user))
		{
			return redirect()->back()->withInput()->with('errors', $users->errors());
		}

		if ($this->config->requireActivation !== false)
		{
			$activator = Services::activator();
			$sent = $activator->send($user);

			if (! $sent)
			{
				return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
			}

			// Success!
			return redirect()->route('login')->with('message', lang('Auth.activationSuccess'));
		}

		// Success!
		return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
	}

	//--------------------------------------------------------------------
	// Forgot Password
	//--------------------------------------------------------------------

	/**
	 * Displays the forgot password form.
	 */
	public function forgotPassword()
	{
		echo $this->render($this->config->views['forgot'], ['config' => $this->config]);
	}

	/**
	 * Attempts to find a user account with that password
	 * and send password reset instructions to them.
	 */
	public function attemptForgot()
	{
		$users = new UserModel();

		$user = $users->where('email', $this->request->getPost('email'))->first();

		if (is_null($user))
		{
			return redirect()->back()->with('error', lang('Auth.forgotNoUser'));
		}

		// Save the reset hash /
		$user->generateResetHash();
		$users->save($user);

		$email = Services::email();
		$config = new Email();

		$sent = $email->setFrom($config->fromEmail, $config->fromEmail)
			  ->setTo($user->email)
			  ->setSubject(lang('Auth.forgotSubject'))
			  ->setMessage(view($this->config->views['emailForgot'], ['hash' => $user->reset_hash]))
			  ->setMailType('html')
			  ->send();

		if (! $sent)
		{
			log_message('error', "Failed to send forgotten password email to: {$user->email}");
			return redirect()->back()->withInput()->with('error', lang('Auth.unknownError'));
		}

		return redirect()->route('reset-password')->with('message', lang('Auth.forgotEmailSent'));
	}

	/**
	 * Displays the Reset Password form.
	 */
	public function resetPassword()
	{
		$token = $this->request->getGet('token');

		echo $this->render($this->config->views['reset'], [
			'config' => $this->config,
			'token'  => $token,
		]);
	}

	/**
	 * Verifies the code with the email and saves the new password,
	 * if they all pass validation.
	 *
	 * @return mixed
	 */
	public function attemptReset()
	{
		$users = new UserModel();

		// First things first - log the reset attempt.
		$users->logResetAttempt(
			$this->request->getPost('email'),
			$this->request->getPost('token'),
			$this->request->getIPAddress(),
			(string)$this->request->getUserAgent()
		);

		$rules = [
			'token'		=> 'required',
			'email'		=> 'required|valid_email',
			'password'	 => 'required|strong_password',
			'pass_confirm' => 'required|matches[password]',
		];

		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $users->errors());
		}

		$user = $users->where('email', $this->request->getPost('email'))
					  ->where('reset_hash', $this->request->getPost('token'))
					  ->first();

		if (is_null($user))
		{
			return redirect()->back()->with('error', lang('Auth.forgotNoUser'));
		}

        // Reset token still valid?
        if (! empty($user->reset_expires) && time() > $user->reset_expires->getTimestamp())
        {
            return redirect()->back()->withInput()->with('error', lang('Auth.resetTokenExpired'));
        }

		// Success! Save the new password, and cleanup the reset hash.
		$user->password 		= $this->request->getPost('password');
		$user->reset_hash 		= null;
		$user->reset_at 		= date('Y-m-d H:i:s');
		$user->reset_expires    = null;
		$users->save($user);

		return redirect()->route('login')->with('message', lang('Auth.resetSuccess'));
	}

	/**
	 * Activate account.
	 */
	public function activateAccount()
	{
		$users = new UserModel();

		// First things first - log the activation attempt.
		$users->logActivationAttempt(
			$this->request->getGet('token'),
			$this->request->getIPAddress(),
			(string) $this->request->getUserAgent()
		);

		$throttler = Services::throttler();

		if ($throttler->check($this->request->getIPAddress(), 2, MINUTE) === false)
        {
			return Services::response()->setStatusCode(429)->setBody(lang('Auth.tooManyRequests', [$throttler->getTokentime()]));
        }

		$user = $users->where('activate_hash', $this->request->getGet('token'))
					  ->where('active', 0)
					  ->first();

		if (is_null($user))
		{
			return redirect()->route('login')->with('error', lang('Auth.activationNoUser'));
		}

		$user->activate();

		$users->save($user);

		return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
	}
}
