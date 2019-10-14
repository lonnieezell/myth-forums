<?php namespace Myth\Forums;

use App\Core\BaseManager;
use Myth\Forums\Models\TagModel;

class TagManager extends BaseManager
{
    public function __construct()
    {
        $this->model = model(TagModel::class);

        parent::__construct();
    }
}
