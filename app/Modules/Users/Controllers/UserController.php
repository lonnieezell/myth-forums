<?php namespace Myth\Users\Controllers;

use App\Core\ThemedController;
use App\Exceptions\DataException;
use Myth\Users\UserManager;

class UserController extends ThemedController
{
    /**
     * @var UserManager
     */
    protected $manager;

    public function __construct()
    {
        $this->manager = new UserManager();
    }

    public function show(string $username)
    {
        try
        {
            $user = $this->manager->findWhere(['username' => $username]);

            if (count($user))
            {
                $user = array_pop($user);
            }

            echo $this->render('users/show', [
                'user' => $user
            ]);
        }
        catch (DataException $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
