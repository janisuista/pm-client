<?php
 /**
   * Controller
   * 
   * Handles all the actions towards the database.
   * 
   * @package    Property Maintenance
   * @subpackage Client
   * @author     Jani Suista <jani.suista@student.samk.fi>
   */
class Controller
{
	function __construct($action, $data)
	{		
		$this->SelectController($action, $data);
	}	
	
	/**
	 * Select correct class and method to execute.
	 * @param string $action Parameter to obtain correct action
	 * @param array  $data   Array which holds all the data submitted by user
	 */
	private function SelectController($action, $data)
	{
		switch($action){
			case 'NewRequest':
				$request = new Request();
				$request->Create($data['request_description'],$data['user_id']);
				break;
			case 'NewOrder':
				$order = new Order();
				$order->Create($data['order_description'],$data['user_id']);
				break;
			case 'EditRequest':
				$request = new Request();
				$request->Edit($_SESSION['uid'], $data);
				break;	
			case 'EditOrder':
				$order = new Order();
				$order->Edit($_SESSION['uid'], $data);
				break;	
			case 'DeleteOrder':
				$order = new Order();
				$order->Delete($_GET['oid']);
				break;	
			case 'DeleteRequest':
				$request = new Request();
				$request->Delete($_GET['rid']);
				break;				
			case 'UpdateUser':
				$user = new User();
				$user->UpdateUser($_SESSION['uid'], $data);
				break;
			default:
				break;
		}			
	}
}