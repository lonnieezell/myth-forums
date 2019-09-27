<?php namespace Myth\Forums;

use App\Core\BaseManager;
use CodeIgniter\HTTP\IncomingRequest;
use Myth\Forums\Models\TopicModel;

class TopicManager extends BaseManager
{
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
        $dir = $request->getVar('dir') ?? 'asc';

        $topics = $this->model
            ->{$sort}($dir)
            ->paginate(20);

        return $topics;
    }

    /**
     * @param IncomingRequest $request
     *
     * @return bool|int|string
     * @throws \ReflectionException
     */
    public function createFromRequest(IncomingRequest $request)
    {
        helper('text');

        foreach ($this->model->allowedFields as $field)
        {
            $this->set($field, $request->getPost($field) ?? null);
        }

        $this->set('slug', slugify($request->getPost('title')));
        $this->set('author_id', user_id());

        return $this->create();
    }
}
