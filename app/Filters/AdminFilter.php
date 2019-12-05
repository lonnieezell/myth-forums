<?php namespace App\Filters;

use Config\Services;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Myth\Users\UserManager;

class AdminFilter implements FilterInterface
{
    /**
     * @param \CodeIgniter\HTTP\RequestInterface $request
     *
     * @return mixed
     * @throws \App\Exceptions\DataException
     * @throws \ReflectionException
     */
	public function before(RequestInterface $request)
	{
	    helper('auth');

        $current = (string)current_url(true)
            ->setHost('')
            ->setScheme('')
            ->stripQuery('token');

        // Make sure this isn't already a login route
        if (in_array((string)$current, [route_to('login'), route_to('forgot'), route_to('reset-password')]))
        {
            return;
        }

        $auth = service('authentication');

        // Must be logged in to have a user
        if (! $auth->check() || ! user()->isAdmin()) {
            session()->set('redirect_url', current_url());
            return redirect('login');
        }

        // Successfully logged in, so track our user
        $user = user();
        $manager = new UserManager();
        $manager->set('last_ip_address', $request->getIPAddress())
            ->set('last_seen', date('Y-m-d H:i:s'))
            ->updateInstance($user);
	}

	//--------------------------------------------------------------------

	/**
	 * Allows After filters to inspect and modify the response
	 * object as needed. This method does not allow any way
	 * to stop execution of other after filters, short of
	 * throwing an Exception or Error.
	 *
	 * @param \CodeIgniter\HTTP\RequestInterface  $request
	 * @param \CodeIgniter\HTTP\ResponseInterface $response
	 *
	 * @return mixed
	 */
	public function after(RequestInterface $request, ResponseInterface $response)
	{

	}

	//--------------------------------------------------------------------
}
