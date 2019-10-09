<?php namespace Myth\Forums;

use App\Core\BaseManager;
use App\Models\UserModel;
use CodeIgniter\HTTP\IncomingRequest;
use Myth\Forums\Entities\Topic;
use Myth\Forums\Models\TopicModel;
use Myth\Parsers\RenderPipeline;

class TopicManager extends BaseManager
{
    protected $afterFind = ['populateUser'];

    public function __construct()
    {
        $this->model = new TopicModel();

        parent::__construct();
    }

    /**
     * Returns a paginated list of topics for the main forum page.
     * Can be limited to a single tag, ordered by one of several
     * main criteria, etc.
     *
     * @param IncomingRequest $request
     *
     * @return
     */
    public function list(IncomingRequest $request)
    {
        $sort = $request->getVar('sort') ?? 'newest';
        $dir = $request->getVar('dir') ?? 'desc';

        $topics = $this->model
            ->{$sort}($dir)
            ->select('topics.*, users.username')
            ->join('users', 'users.id = topics.author_id')
            ->paginate(20);

        $topics = $this->populateUser($topics);

        return $topics;
    }

    /**
     * Populates the Author for many topics.
     *
     * @param array $topics
     *
     * @return array
     */
    public function populateUser($topics = null)
    {
        if (empty($topics)) return $topics;

        $userIds = [];
        $wasSingle = false;

        if ($topics instanceof Topic) {
            $topics = [$topics];
            $wasSingle = true;
        }

        foreach($topics as $topic) {
            $userIds[] = $topic->author_id;
        }

        $userIds = array_unique($userIds);

        $userModel = model(UserModel::class);

        $users = $userModel->find($userIds);

        // Index by id
        $indexedUsers = [];

        foreach($users as $user) {
            $indexedUsers[$user->id] = $user;
        }

        foreach ($topics as $topic) {
            if (empty($topic->author_id)) {
                continue;
            }

            $topic->author = $indexedUsers[$topic->author_id];
        }

        return $wasSingle
            ? array_pop($topics)
            : $topics;
    }

    /**
     * @param IncomingRequest $request
     *
     * @return bool|int|string
     * @throws \ReflectionException
     * @throws \App\Exceptions\DataException
     */
    public function createFromRequest(IncomingRequest $request)
    {
        helper('text');
        $pipeline = new RenderPipeline();

        foreach ($this->model->allowedFields as $field)
        {
            $this->set($field, $request->getPost($field) ?? null);
        }

        $this->set('author_id', user_id());

        $this->set('html', $pipeline->render(
            $request->getPost('body'),
            $request->getPost('parser')
        ));

        $topic = $this->create();

        $this->set('slug', $topic->id .'-'. slugify($request->getPost('title')));
        $topic = $this->updateInstance($topic);

        return $topic;
    }

    /**
     * Increment the view count for a single topic.
     *
     * @param Topic $topic
     *
     * @return bool
     */
    public function incrementViews(Topic $topic)
    {
        return $this->model
            ->where('id', $topic->id)
            ->increment('views', 1);
    }

    /**
     * Find the most recent topics for a single user.
     *
     * @param int $userId
     * @param int $limit
     *
     * @return \CodeIgniter\Database\BaseBuilder
     */
    public function recentForUser(int $userId, int $limit = 15)
    {
        return $this->model
            ->where('author_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->findAll();
    }
}
