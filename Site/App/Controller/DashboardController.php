<?php
namespace App\Controller;

class DashboardController extends Controller {
	public static function index() 
	{        
		include 'View/modules/Home/Dashboard.php';
	}
}