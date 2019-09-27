<?php namespace Myth\Forums\Models;

use CodeIgniter\Model;

class TopicModel extends Model
{
    protected $table = 'topics';

    protected $allowedFields = [
        'author_id', 'title', 'slug', 'body', 'html', 'parser', 'views'
    ];
}
