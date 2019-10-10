<?php namespace Myth\Forums;

use App\Core\BaseManager;
use App\Models\UserModel;
use CodeIgniter\HTTP\IncomingRequest;
use Myth\Forums\Entities\Topic;
use Myth\Forums\Models\PostModel;
use Myth\Parsers\RenderPipeline;

class PostManager extends BaseManager
{
//    protected $afterFind = ['populateUser'];

    public function __construct()
    {
        $this->model = new PostModel();

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
     * @param Topic           $topic
     *
     * @return bool|int|string
     * @throws \App\Exceptions\DataException
     * @throws \ReflectionException
     */
    public function createFromRequest(IncomingRequest $request, Topic $topic)
    {
        helper('text');
        $pipeline = new RenderPipeline();
        $parser = user()->setting('parser');

        foreach ($this->model->allowedFields as $field)
        {
            $this->set($field, $request->getPost($field) ?? null);
        }

        $this->set('author_id', user_id());
        $this->set('topic_id', $topic->id);
        $this->set('parser', $parser);

        $this->set('html', $pipeline->render(
            $request->getPost('body'),
            $parser
        ));

        $post = $this->create();

//        $this->set('slug', $post->id .'-'. slugify($request->getPost('title')));
        $topic = $this->updateInstance($topic);

        return $topic;
    }

}
