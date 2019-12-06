<?php namespace Myth\Forums\Controllers\Admin;

use App\Core\AdminController;
use Myth\Forums\TagManager;

class TagController extends AdminController
{
    /**
     * @var TagManager
     */
    protected $tags;

    public function __construct()
    {
        $this->tags = new TagManager();
    }

    /**
     * Manage tags
     */
    public function list()
    {
        echo $this->render('admin/forum/tags', [
            'primaryTags' => $this->tags->parents()->primary()->all(),
            'secondaryTags' => $this->tags->parents()->secondary()->all(),
        ]);
    }
}
