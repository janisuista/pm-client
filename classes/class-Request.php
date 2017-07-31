<?php
 /**
   * Request
   * 
   * @package    Property Maintenance
   * @subpackage Client
   * @author     Jani Suista <jani.suista@student.samk.fi>
   */
class Request implements IWork
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
		$stmt = $this->pdo->prepare("insert into requests (request_user_id, request_time, request_description, request_status) values (?,?,?,?)");
		$stmt->bindValue(1,$uid ,PDO::PARAM_INT);
		$stmt->bindValue(2,time(),PDO::PARAM_INT);
		$stmt->bindValue(3,$desc,PDO::PARAM_STR);
		$stmt->bindValue(4,'JÄTETTY',PDO::PARAM_STR);
		try{
			$stmt->execute();
		}							
		catch(PDOException $e){
			$_SESSION['errors'][] = 'Virhe:'.$e;
		}
		$this->Redirect();		
	}
	
	public function Edit($uid, $data)
	{
		$stmt = $this->pdo->prepare("update requests set request_description=? where request_id=? and request_user_id=?");
		$stmt->bindValue(1,$data['request_description'],PDO::PARAM_STR);
		$stmt->bindValue(2,$data['request_id'],PDO::PARAM_INT);
		$stmt->bindValue(3,$uid,PDO::PARAM_INT);
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
		$stmt = $this->pdo->prepare("delete from requests where request_id=? limit 1");
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		try{
			$stmt->execute();	
		}
		catch(PDOException $e){
			$_SESSION['errors'][] = 'Virhe:'.$e;
		}		
	}

	/**
	 * Fetch and display all the requests created by certain user.
	 * @param int $uid unique users id-number
	 */		
	public function getAll($uid)
	{
		$stmt = $this->pdo->prepare("select r.request_id, r.request_time, r.request_description, r.request_status, r.budget_estimate, u.user_real_name, u.user_property_type from requests r join user u on u.user_id=r.request_user_id where r.request_user_id=:uid");
		$stmt->bindValue(':uid', $uid, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$strcol = '<td>%s</td>';
		$intcol = '<td>%d</td>';
		$editcol = '<td><form id="edit_request" method=POST action="?action=EditRequest"><input type="hidden" name="request_id" value="%d"><input type="text" name="request_description" value="%s"><input type="submit" value="OK"></form></td>';
			
		foreach($result as $row){
			echo '<tr data-href="#">';	
			echo sprintf($strcol,date("d.m.Y G:i",$row['request_time']));
			echo sprintf($strcol,$row['user_property_type']);
			
			if(!empty($_GET['mode']) && $_GET['mode'] == 'edit_request' && $_GET['rid'] == $row['request_id'])
				echo sprintf($editcol,$row['request_id'],$row['request_description']);
			else
				echo sprintf($strcol,$row['request_description']);
			
			
			echo sprintf($strcol,$row['request_status']);
			echo sprintf($intcol,$row['budget_estimate']);
			
			echo sprintf($strcol,'<a class="'.($row['request_status'] == 'JÄTETTY' ? 'active' : 'not-active').'" href="?mode=edit_request&rid='.$row['request_id'].'" title="Muokkaa tarjouspyyntöä"><i class="fa fa-edit"></i></a>');
			echo sprintf($strcol,'<a class="'.($row['request_status'] == 'JÄTETTY' ? 'active' : 'not-active').'" href="?action=DeleteRequest&rid='.$row['request_id'].'" title="Poista tarjouspyyntö"><i class="fa fa-trash"></i>');
			
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