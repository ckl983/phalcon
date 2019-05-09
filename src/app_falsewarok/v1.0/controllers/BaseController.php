<?php
/**
 * @desc 控制器基类
 *
 * @author --
 * @copyright 2014-2018
 */

use WPLib\Base\Controller;

class BaseController extends Controller
{
	protected static $_no_sign_actions = [
		['m' => '', 'n' => '', 'c' => '*', 'a' => '*'],
	];

	protected static $_sign_actions = [
	];

	public function initialize()
	{

		parent::initialize();

		$this->view->disable();

		Logger::info(sprintf("\nCLIENT IP:%s\nURL:%s\nRAW:%s\nPOST:%s\nGET:%s\nSERVER: %s",
			Helper::getClientIp(),
			$this->request->getURI(),
			file_get_contents('php://input'),
			http_build_query($_POST),
			http_build_query($_GET),
			json_encode($_SERVER)
		));
//		header('Access-Control-Allow-Origin:*');
//        header('Access-Control-Allow-Headers:x-requested-with,content-type');
	}

}
