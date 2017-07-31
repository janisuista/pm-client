<?php
 /**
   * User
   * 
   * @package    Property Maintenance
   * @subpackage Client
   * @author     Jani Suista <jani.suista@student.samk.fi>
   */
class User
{
	/** @var int $uid Holds the user_id */
	public $uid   = null;
	
	/** @var string $uid Holds the users real name */
	public $ureal = null;
	
	/** @var object $pdo Holds the pdo object which is used to insert and fetch data from database */
	private $pdo;
  
	/**
	 * Constructor to initialize a new pdo object and store it to the variable
	 * @private
	 */	
	function __construct()
	{
		$this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
	}

	function __destruct(){}

	/**
	 * Checks if users login credentials are valid
	 * @param  string $uname username
	 * @param  string $upwd  user password
	 * @return boolean  
	 */
	public function checkLogin($uacc, $upwd)
	{
		/* Prepare pdo statement and bind parameters */
		$stmt = $this->pdo->prepare('SELECT user_id, user_real_name FROM user WHERE user_pwd = :upwd AND user_account = :uacc');
		$stmt->bindValue(':upwd', $upwd, PDO::PARAM_STR);
		$stmt->bindValue(':uacc', $uacc, PDO::PARAM_STR);
		
		/* Execute and assign the possible result array to variable */
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		
		/* If result is empty, just return false. Otherwise assign id and users real name to the class properties */
		if(!empty($res)){
			$this->uid = $res['user_id'];
			$this->ureal = $res['user_real_name'];
			return true;
		}
		else
			return false;
	}
	
	/**
	 * Register new user
	 * @param array $data array from the registration form
	 */
	public function RegisterNewUser($data)
	{
		/* If password and confirmation doesn't match, just go back to login page */
		if($data['upwd'] != $data['conf_upwd']) return false;
		
		$stmt = $this->pdo->prepare('INSERT into user (user_account, user_real_name, user_pwd) VALUES (:uacc, :ureal, :upwd)');
		$stmt->bindValue(':uacc', $data['uacc']);
		$stmt->bindValue(':ureal', $data['ureal']);
		$stmt->bindValue(':upwd', $data['upwd']);
		$stmt->execute();
	}
	
	public function UpdateUser($uid, $udata)
	{
		foreach($udata as $key => $val){
			$stmt = $this->pdo->prepare("update user set {$key}=? where user_id=?");
			$stmt->bindValue(2, $uid, PDO::PARAM_INT);
			
			if(is_numeric($val))
				$stmt->bindValue(1, $val, PDO::PARAM_INT);
			else
				$stmt->bindValue(1, $val, PDO::PARAM_STR);

			try{
				$stmt->execute();
			}							
			catch(PDOException $e){
				$_SESSION['errors'][] = 'Virhe:'.$e;
			}
		}
		$this->Redirect('user');
	}	
	
	public function getUserData($uid)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE user_id=:uid");
		$stmt->bindValue(':uid', $uid, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
	
	private function Redirect($page='')
	{
		if(!empty($page)) header('Location:'.PATH.'?p='.$page);
		else header('Location:'.PATH);
	}
}