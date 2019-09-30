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
        $dir = $request->getVar('dir') ?? 'desc';

        $topics = $this->model
            ->{$sort}($dir)
            ->select('topics.*, users.username')
            ->join('users', 'users.id = topics.author_id')
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

        $this->set('author_id', user_id());

        $this->set('html', $this->parseBody(
            $request->getPost('body'),
            $request->getPost('parser')
        ));

        $topic = $this->create();

        $this->set('slug', $topic->id .'-'. slugify($request->getPost('title')));
        $topic = $this->updateInstance($topic);

        return $topic;
    }

    /**
     * @param string|null $body
     * @param string|null $parser
     *
     * @return string
     */
    protected function parseBody(string $body = null, string $parser = null): string
    {
        if (empty($body))
        {
            return '';
        }

        $useParser = ! empty($parser)
            ? $parser
            : config('Parsers')->defaultParser;

        $parsers = config('Parsers')->availableParsers;

        // No parser found - then should be raw text,
        // just do a simple formatting to preserve returns.
        if (! isset($parsers[$useParser]))
        {
            return nl2br($body);
        }

        $useParser = $parsers[$useParser];

        $parser = new $useParser();

        return $parser->parse($body);
    }
}
