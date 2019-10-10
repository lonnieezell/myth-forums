<?php namespace Myth\Forums\Controllers;

use App\Core\ThemedController;
use App\Exceptions\DataException;
use Myth\Forums\PostManager;
use Myth\Forums\TopicManager;

class ForumController extends ThemedController
{
    /**
     * @var TopicManager
     */
    protected $topics;

    public function __construct()
    {
        $this->topics = new TopicManager();
    }

    /**
     * Handles all listing of items at the topic-level,
     * both for the main page, and for a specific tag list.
     *
     * @param string|null $tag
     */
    public function list(string $tag = null)
    {
        echo $this->render('topics/list', [
            'topics' => $this->topics->list($this->request),
        ]);
    }

    /**
     * Displays the new topic form.
     */
    public function newTopic()
    {
        echo $this->render('topics/form', [
            'parsers' => config('Parsers')->availableParsers,
        ]);
    }

    /**
     * Handles the POST request to create a new topic.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function saveNewTopic()
    {
        try {
            $topic = $this->topics->createFromRequest($this->request);

            if (empty($topic))
            {
                return redirect()->route('new_topic')->withInput()->with('errors', $this->topics->errors());
            }

            return redirect()->to("/forum/discussion/{$topic->slug}")->with('message', lang('messages.resourceSaved', ['Topic']));
        }
        catch (DataException $e)
        {
            return redirect()->route('new_topic')->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Shows a single discussion
     *
     * @param string $slug
     *
     * @return mixed
     */
    public function showTopic(string $slug)
    {
        try
        {
            $topic = $this->topics->find((int)$slug);

            $this->topics->incrementViews($topic);

            echo $this->render('topics/discussion', [
                'topic' => $topic
            ]);
        }
        catch (DataException $e)
        {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Saves a new reply to a post
     *
     * @param string $topicSlug
     */
    public function postReply(string $topicSlug)
    {
        $posts = new PostManager();

        try {
            $topic = $this->topics->find((int)$topicSlug);
            $post = $posts->createFromRequest($this->request, $topic);

            if (empty($post))
            {
                return redirect()->route('new_topic')->withInput()->with('errors', $posts->errors());
            }

            return redirect()->route('topic', [$topicSlug])->with('message', lang('messages.resourceSaved', ['Reply']));
        }
        catch (DataException $e)
        {
            return redirect()->route('new_topic')->withInput()->with('error', $e->getMessage());
        }
    }
}
