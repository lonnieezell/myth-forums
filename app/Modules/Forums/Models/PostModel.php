<?php namespace Myth\Forums\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';

    protected $allowedFields = ['author_id', 'topic_id', 'slug', 'body', 'html', 'parser', 'views'];

    protected $useTimestamps = true;
}
