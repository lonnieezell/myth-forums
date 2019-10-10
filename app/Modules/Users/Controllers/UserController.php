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
                    $recent = $this->render('users/_recent_topics', [
                        'topics' => $topics->recentForUser($user->id, 10)
                    ]);
                    break;
            }

            echo $this->render('users/show', [
                'user' => $user,
                'recent' => $recent ?? null,
            ]);
        }
        catch (DataException $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
