<?php namespace App\Controllers\Admin;

use App\Core\AdminController;

class Home extends AdminController
{
	public function index()
	{
		echo $this->render('admin/dashboard');
	}

	//--------------------------------------------------------------------

}
