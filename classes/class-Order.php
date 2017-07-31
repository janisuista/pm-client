<?php
 /**
   * Order
   * 
   * @package    Property Maintenance
   * @subpackage Client
   * @author     Jani Suista <jani.suista@student.samk.fi>
   */
class Order implements IWork
{
	/** @var object $pdo The PDO instance */
	private $pdo;
	
	function __construct()
	{
		$this->initPDO();
	}
	
	public function initPDO()
	{
		$this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
	}
		
	public function Create($desc, $uid)
	{
		$stmt = $this->pdo->prepare("insert into orders (user_id, order_status, order_creation_time, order_description) values (?,'TILATTU',?,?)");
		$stmt->bindValue(1, $uid, PDO::PARAM_INT);
		$stmt->bindValue(2, time(), PDO::PARAM_INT);
		$stmt->bindValue(3, $desc, PDO::PARAM_STR);
		try{
			$stmt->execute();
		}							
		catch(PDOException $e){
			$_SESSION['errors'][] = 'Virhe:'.$e;
		}
		$this->Redirect();		
	}
	
	public function Delete($id)
	{
		$stmt = $this->pdo->prepare("delete from orders where order_id=? limit 1");
		$stmt->bindValue(1, $id ,PDO::PARAM_INT);
		try{
			$stmt->execute();	
		}
		catch(PDOException $e){
			$_SESSION['errors'][] = 'Virhe:'.$e;
		}		
	}
	
	public function Edit($uid, $data)
	{
		$stmt = $this->pdo->prepare("update orders set order_description=? where order_id=? and user_id=?");
		$stmt->bindValue(1, $data['order_description'], PDO::PARAM_STR);
		$stmt->bindValue(2, $data['order_id'], PDO::PARAM_INT);
		$stmt->bindValue(3, $uid, PDO::PARAM_INT);
		try{
			$stmt->execute();
		}							
		catch(PDOException $e){
			$_SESSION['errors'][] = 'Virhe:'.$e;
		}
		$this->Redirect();		
	}
	
	/**
	 * Fetches and displays all the orders created by certain user.
	 * @param int $uid unique users id-number
	 */
	public function getAll($uid)
	{
		$stmt = $this->pdo->prepare("select o.order_id, o.order_creation_time, o.order_starting_time, o.order_description, o.order_status, o.order_estimated_budget, u.user_real_name, u.user_property_type from orders o join user u on u.user_id=o.user_id where o.user_id=:uid");
		$stmt->bindValue(':uid', $uid, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$strcol = '<td>%s</td>';
		$intcol = '<td>%d</td>';
		$editcol = '<td><form id="edit_order" method=POST action="?action=EditOrder"><input type="hidden" name="order_id" value="%d"><input type="text" name="order_description" value="%s"><input type="submit" value="OK"></form></td>';
			
		foreach($result as $row){
			echo '<tr data-href="#">';
			echo sprintf($strcol,date("d.m.Y G:i",$row['order_creation_time']));
			echo sprintf($strcol,$row['user_property_type']);
			
			if(!empty($_GET['mode']) && $_GET['mode'] == 'edit_order' && $_GET['oid'] == $row['order_id'])
				echo sprintf($editcol,$row['order_id'],$row['order_description']);
			else
				echo sprintf($strcol,$row['order_description']);
			
			echo sprintf($strcol,$row['order_status']);
			
			if(!empty($row['order_starting_time']))
				echo sprintf($strcol,date("d.m.Y G:i",$row['order_starting_time']));
			else
				echo sprintf($strcol,'-');
			
			if(!empty($row['order_finishing_time']))
				echo sprintf($strcol,date("d.m.Y",$row['order_finishing_time']));
			else
				echo sprintf($strcol,'-');
			echo sprintf($intcol,$row['order_estimated_budget']);
			
			echo sprintf($strcol,'<a class="'.($row['order_status'] == 'TILATTU' ? 'active' : 'not-active').'" href="?mode=edit_order&oid='.$row['order_id'].'" title="Muokkaa työtilausta"><i class="fa fa-edit"></i></a>');
			echo sprintf($strcol,'<a class="'.($row['order_status'] == 'TILATTU' ? 'active' : 'not-active').'" href="?action=DeleteOrder&oid='.$row['order_id'].'" title="Poista työtilaus"><i class="fa fa-trash"></i>');
			echo '</tr>';
		}		
	}

	/**
	 * Redirects user to the homepage or to the page given as parameter
	 * @param string $page page name
	 */	
	private function Redirect($page='')
	{
		if(!empty($page)) header('Location:'.PATH.'?p='.$page);
		else header('Location:'.PATH);	
	}
}