<?php namespace Myth\Forums\Models;

use CodeIgniter\Model;
use Myth\Forums\Entities\Tag;

class TagModel extends Model
{
    protected $table = 'tags';

    protected $allowedFields = ['title', 'slug', 'description', 'parent_id', 'order', 'is_structural'];

    protected $returnType = Tag::class;
}
