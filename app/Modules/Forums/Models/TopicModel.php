<?php namespace Myth\Forums\Models;

use CodeIgniter\Model;
use Myth\Forums\Entities\Topic;

class TopicModel extends Model
{
    protected $table = 'topics';

    protected $allowedFields = [
        'author_id', 'title', 'slug', 'body', 'html', 'parser', 'views'
    ];

    protected $validationRules = [
        'title' => 'required',
    ];

    protected $returnType = Topic::class;

    protected $useTimestamps = true;

    /**
     * Scope method to sort results by newest first.
     *
     * @return $this
     */
    public function newest()
    {
        $this->orderBy('created_at', 'desc');

        return $this;
    }

    /**
     * Scope method to sort results by oldest first.
     *
     * @return $this
     */
    public function oldest()
    {
        $this->orderBy('created_at', 'desc');

        return $this;
    }

    /**
     * Scope method to order results by those that have the
     * most recent activity.
     */
    public function latest()
    {
//        $this->join('posts');

        return $this;
    }
}
