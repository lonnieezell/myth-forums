<?php namespace Myth\Users\Controllers;

use App\Core\ThemedController;
use App\Exceptions\DataException;
use Myth\Forums\TopicManager;
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

    public function show(string $username, string $listType = 'topics')
    {
        try
        {
            $user = $this->manager->findWithStats($username);

            switch($listType)
            {
                case 'discussions':
                    $records = null;
                    $view = null;
                    break;
                default:
                    $topics = new TopicManager();
                    $records = $topics->recentForUser($user->id, 10);
                    $view = 'forums/_topic_list_item';
                    break;
            }

            echo $this->render('users/show', [
                'user' => $user,
                'records' => $records,
                'view' => $view,
            ]);
        }
        catch (DataException $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
