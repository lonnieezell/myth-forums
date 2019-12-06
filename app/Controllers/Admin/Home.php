<?php namespace App\Controllers\Admin;

use App\Core\AdminController;

class Home extends AdminController
{
	public function index()
	{
	    $db = db_connect();

		echo $this->render('admin/dashboard', [
		    'dbDriver' => $db->DBDriver,
            'dbVersion' => $db->getVersion(),
        ]);
	}

	//--------------------------------------------------------------------

}
