<?php namespace Myth\Forums\Controllers\Admin;

use App\Core\AdminController;

class ForumController extends AdminController
{
    public function index()
    {
        echo $this->render('admin/forum/index');
    }
}
