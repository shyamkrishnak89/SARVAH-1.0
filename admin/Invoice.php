<?php
include('email/index.php');
class Invoice{
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = '';
    private $database  = 'cman';   
	private $invoiceUserTable = 'invoice_user';	
	private $announcementTable = 'announcement';
	private $memberTable = 'members';	
    private $invoiceOrderTable = 'invoice_order';
	private $invoiceOrderItemTable = 'invoice_order_item';
	private $itemsTable = 'items';
	private $eventsTable = 'event';
	private $sambhavanaItemsTable = 'sambhavana_items';
	private $incomeTable = 'income';
	private $expenseTable = 'expense';
	private $eventsInvoiceOrderTable = 'events_sambhavana';
	private $sambhavanaOrderItemTable = 'sambhavana_order_item';
	private $auditTable = 'audit_table';
	private $logTable = 'user_log';
	private $activityTable = 'activity_log';
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function loginUsers($userName, $password){
		$sqlQuery = "
			SELECT * 
			FROM ".$this->invoiceUserTable." 
			WHERE username='".$userName."' AND password='".$password."'";
        return  $this->getData($sqlQuery);
	}	


	public function activity_log($userName, $action){
		$sqlInsert = "
		INSERT INTO ".$this->activityTable."(username, action)
			VALUES ('".$userName."', '".$action."')";
			mysqli_query($this->dbConnect, $sqlInsert);
	}

	

	// Function to log user actions
	public function log_action($user_id, $userName, $action) {
		$sqlInsert = "
			INSERT INTO ".$this->logTable."(user_id, username, action)
			VALUES ('".$user_id."', '".$userName."', '".$action."')";		
		mysqli_query($this->dbConnect, $sqlInsert);
   
}

	public function loginMembers($username, $password){
		$sqlQuery = "
			SELECT * 
			FROM ".$this->memberTable." 
			WHERE housenumber='".$username."' AND password='".$password."'";
        return  $this->getData($sqlQuery);
	}	


	public function getItemsByTypeAndCount(){
		$sqlQuery = "
		SELECT item_name, COUNT(*) AS item_count
		FROM ".$this->invoiceOrderItemTable."
		GROUP BY item_name";
			
        return  $this->getData($sqlQuery);
	}	


	public function checkLoggedIn(){
		if(!$_SESSION['userid']) {
			header("Location:index.php");
		}
	}		
	public function saveMember($POST) {		
		$sqlInsert = "
			INSERT INTO ".$this->memberTable."(fname, sname, lname, Gender, Birthday, housename, housenumber, zone, mobile, email,password,thumbnail,id) 
			VALUES ('".$POST['firstName']."', '".$POST['middleName']."', '".$POST['lastName']."', '".$POST['gender']."', '".$POST['dob']."', '".$POST['houseName']."', '".$POST['houseNumber']."', '".$POST['zone']."', '".$POST['mobileNumber']."', '".$POST['emailID']."','".$POST['password']."','uploads/none.png','".$POST['mobileNumber']."')";		
		mysqli_query($this->dbConnect, $sqlInsert);
		$action = "Added person " . $POST['firstName'] . ' ' . $POST['middleName'] . ' ' . $POST['lastName'] . '-HNo.' . $POST['houseNumber'];
			$this->activity_log($_SESSION['username'],$action);



		
		}   
		
	
	public function saveUser($POST) {	
		$type = $POST['type'];

		echo "Type: ".$type;
		$code = "";
		$sqlQuery = "
				SELECT * 
				FROM ".$this->invoiceUserTable." WHERE type ='".$type."'";
				$result = mysqli_query($this->dbConnect, $sqlQuery);
				$row = mysqli_num_rows($result);
		
		
		$num = $row + 1;
		if($type=="Staff"){
			$code = "STA";
		}
		else if($type=="Volunteer"){
			$code = "VOL";
		}
		else if($type=="Admin"){
			$code = "ADM";
		}
		else if($type=="Super Admin"){
			$code = "SUP";
		}
		$num_padded = sprintf("%02d", $num);
		$userName = $code.$num_padded;

		echo "Username: ".$userName;

			$sqlInsert = "
				INSERT INTO ".$this->invoiceUserTable."(email,username, first_name, last_name, type, mobile, password,address) 
				VALUES ('".$POST['email']."','$userName','".$POST['firstName']."', '".$POST['lastName']."', '".$POST['type']."','".$POST['mobileNumber']."','".$POST['password']."','".$POST['address']."')";		
			mysqli_query($this->dbConnect, $sqlInsert);
			$lastInsertId = mysqli_insert_id($this->dbConnect);
			$to = $POST['email'];
			$subject = 'User Account Created';
			$msg = '<p>Hello '.$POST['firstName'].' '.$POST['lastName'].',</p><p>A User Account is created with Sarvah software of Kizhuthully Sree Mahavishnu Temple with the following details: <br>User Type:'.$POST['type'].'  <br>User ID:'.$lastInsertId .'  <br> User Name: '.$userName.' <br>Password: '.$POST['password'].'<br>Login page: https://sarvah.alamalhandasa.com/</p><p>You may please contact the ERP admin for any support.</p><p>Thank You,</p><p>Secretary<br>Kizhuthully Sree Mahavishnu Kshethra Samrakshana Samithy <br>Nedumbal <br>Ph: 9072011551</p>';
			echo smtp_mailer($to,$subject, $msg);

			$action = "System User created" . $POST['firstName'] . ' ' . $POST['lastName'] . ' ' . $POST['type'];
			$this->activity_log($_SESSION['username'],$action);
			
			}     
		
		public function getMembers(){
			$sqlQuery = "
				SELECT * 
				FROM ".$this->memberTable." ";
			return  $this->getData($sqlQuery);
		}

		public function getNumOfMembers(){
			$sqlQuery = "
				SELECT COUNT(keyU) as num 
				FROM ".$this->memberTable." ";
			return  $this->getData($sqlQuery);
		}

		public function getUsers(){
			$sqlQuery = "
				SELECT * 
				FROM ".$this->invoiceUserTable." ";
			return  $this->getData($sqlQuery);
		}

		public function getAnnouncements(){
			$sqlQuery = "
				SELECT * 
				FROM ".$this->announcementTable."
				ORDER BY times DESC";
			return  $this->getData($sqlQuery);
		}

		public function getAnnouncementsCount(){
			$sqlQuery = "
				SELECT COUNT(*) AS ann_count
				FROM ".$this->announcementTable."
				ORDER BY times DESC";
			return  $this->getData($sqlQuery);
		}
		
		public function getMemberDetailsByHouseNumber($houseNumber){
			$sqlQuery = "
				SELECT fname, housename,zone, mobile
				FROM ".$this->memberTable."
				WHERE housenumber = '$houseNumber'";
				$result = mysqli_query($this->dbConnect, $sqlQuery);	
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			return  $row;
		}


		public function getDailyIncome(){
			$sqlQuery = "
			SELECT sum(amount_paid) as amount, date from ".$this->incomeTable." GROUP BY date ORDER BY date DESC";
			$result = mysqli_query($this->dbConnect, $sqlQuery);
			return $result;
		}

		public function getDailyExpense(){
			$sqlQuery = "
			SELECT sum(amount_paid) as amount, date from ".$this->expenseTable." GROUP BY date ORDER BY date DESC";
			$result = mysqli_query($this->dbConnect, $sqlQuery);
			return $result;
		}

		public function getThisMonthRevenue(){
			$sqlQuery = "
			SELECT SUM(amount_paid) as revenue, COUNT(id) as num
			FROM ".$this->incomeTable."
			WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())";
			return  $this->getData($sqlQuery);
		}

		public function getTodaysRevenue(){
			$sqlQuery = "
			SELECT SUM(amount_paid) as revenue, COUNT(id) as num
			FROM ".$this->incomeTable."
			WHERE DATE(date) = DATE(CURRENT_DATE()) AND MONTH(date) = MONTH(CURRENT_DATE())";
			return  $this->getData($sqlQuery);
		}



	
		public function saveExpense($POST) {
			if(!$POST['date']){
				$date = date("Y-m-d");
			}
			else{
				$date = $POST['date'];
			}
			$sqlInsertExpense = "
			INSERT INTO ".$this->expenseTable."(order_id, type, amount_paid, date, remarks) 
			VALUES ('self','".$POST['type']."' , '".$POST['amount']."','".$date."','".$POST['remarks']."')";		
		mysqli_query($this->dbConnect, $sqlInsertExpense);

		}

		public function saveIncome($POST) {
			
			if(!$POST['date']){
				$date = date("Y-m-d");
			}
			else{
				$date = $POST['date'];
			}
			$sqlInsertIncome = "
			INSERT INTO ".$this->incomeTable."(order_id, type, amount_paid, amount_due, date, remarks) 
			VALUES ('self','".$POST['type']."' , '".$POST['amount']."', '0', '".$date."' , '".$POST['remarks']."')";		
		mysqli_query($this->dbConnect, $sqlInsertIncome);

		}


		
	public function saveInvoice($POST) {		
		$today = date("Y-m-d");
		$sqlInsert = "
			INSERT INTO ".$this->invoiceOrderTable."(user_id, order_receiver_name, order_receiver_address, order_total_before_tax, order_total_after_tax, order_amount_paid, order_total_amount_due, note, collected_by) 
			VALUES ('".$POST['userId']."', '".$POST['devoteeName']."', '".$POST['devoteeStar']."', '".$POST['subTotal']."', '".$POST['totalAftertax']."', '".$POST['amountPaid']."', '".$POST['amountDue']."', '".$POST['floatingNotes']."', '".$_SESSION['username']."')";		
		mysqli_query($this->dbConnect, $sqlInsert);
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		for ($i = 0; $i < count($POST['productCode']); $i++) {
			$sqlInsertItem = "
			INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount, collected_by) 
			VALUES ('".$lastInsertId."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."', '".$_SESSION['username']."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);
		}  
		$sqlInsertIncome = "
			INSERT INTO ".$this->incomeTable."(order_id, type, amount_paid, amount_due, date, remarks) 
			VALUES ('".$lastInsertId."','vazhipadu' , '".$POST['amountPaid']."', '".$POST['amountDue']."','".$today."' ,'".$POST['floatingNotes']."')";		
		mysqli_query($this->dbConnect, $sqlInsertIncome);

		$action = "Invoice created-" . $lastInsertId . '-total ' .$POST['totalAftertax']. '-Paid  ' .$POST['amountPaid'].'-By  '.$_SESSION['username'];
			$this->activity_log($_SESSION['username'],$action);
	}	
	public function saveItems($POST) {	
		
		$sqlInsert = "
			INSERT INTO ".$this->itemsTable."(itemname,itemdesc,itemrate) 
			VALUES ('".$POST['itemName']."', '".$POST['itemDescription']."', '".$POST['rate']."')";		
		mysqli_query($this->dbConnect, $sqlInsert);
		$action = "Added Item " . $POST['itemName'] . ' ' . $POST['rate'] . ' ' . $POST['itemDescription'];
			$this->activity_log($_SESSION['username'],$action);
		      	
	}	

	public function saveAnnouncement($POST) {	
		
		$sqlInsert = "
			INSERT INTO ".$this->announcementTable."(title,content,times) 
			VALUES ('".$POST['itemName']."', '".$POST['itemDescription']."', '".$POST['date']."')";		
		mysqli_query($this->dbConnect, $sqlInsert);
		
		      	
	}	

	public function saveSambhavanaItems($POST) {	
		
		$sqlInsert = "
			INSERT INTO ".$this->sambhavanaItemsTable."(itemname,itemdesc,itemrate) 
			VALUES ('".$POST['sambhavanaItemName']."', '".$POST['sambhavanaItemDescription']."', '".$POST['sambhavanaItemRate']."')";		
		mysqli_query($this->dbConnect, $sqlInsert);
		$action = "Added SAmbhavana Item " . $POST['sambhavanaItemName'] . ' ' . $POST['sambhavanaItemRate'] . ' ' . $POST['sambhavanaItemDescription'];
			$this->activity_log($_SESSION['username'],$action);
		
		      	
	}
	public function saveEventInvoice($POST) {	
		$user = $_SESSION['username'];		
		$status = "";
		$due = $POST['amountDue'];
		$offered_amount = $POST['totalAftertax'];
		if($due == 0)
		{
			$status = "Paid";
		}
		else if($due < 0){
			$status = "Bonus";
		}
		else if($due == $offered_amount){
			$status = "Unpaid";
		}
		else{
			$status = "Partial";
		}
		$sqlInsert = "
			INSERT INTO ".$this->eventsInvoiceOrderTable."(eventid, eventName, eventDate, zone, houseNumber, name, houseName, amountOffered, 	amountReceived, amountPending, note, status, collected_by, mobile, ename) 
			VALUES ('".$POST['eid']."', '".$POST['etitle']."', '".$POST['edate']."', '".$POST['zone']."', '".$POST['housenumber']."', '".$POST['personName']."', '".$POST['houseName']."', '".$POST['totalAftertax']."', '".$POST['amountPaid']."', '".$POST['amountDue']."', '".$POST['notes']."','".$status."','".$user."','".$POST['phone']."', '".$POST['ename']."')";		
		
			mysqli_query($this->dbConnect, $sqlInsert);
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		for ($i = 0; $i < count($POST['productCode']); $i++) {
			$sqlInsertItem = "
			INSERT INTO ".$this->sambhavanaOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount, collected_by) 
			VALUES ('".$lastInsertId."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."','".$user."')" ;			
			mysqli_query($this->dbConnect, $sqlInsertItem);
		}       	
		$sqlInsertPayment = "
			INSERT INTO ".$this->auditTable."(sambhavanaId, eventid, eventName, zone, houseNumber, amount) 
			VALUES ('".$lastInsertId."', '".$POST['eid']."', '".$POST['etitle']."', '".$POST['zone']."', '".$POST['housenumber']."', '".$POST['amountPaid']."')";			
			mysqli_query($this->dbConnect, $sqlInsertPayment);

			$action = "Event Invoice created-" . $lastInsertId . '-total ' .$POST['totalAftertax']. '-Paid  ' .$POST['amountPaid'].'-By  '.$_SESSION['username'];
			$this->activity_log($_SESSION['username'],$action);
	}	
	public function updateInvoice($POST) {

		$amount_paid = $POST['previousPayment'] + $POST['amountPaid'];

		
		
		if($POST['invoiceId']) {	
			$sqlInsertInvoice = "
				UPDATE ".$this->invoiceOrderTable." 
				SET order_total_after_tax = '".$POST['totalAftertax']."', order_amount_paid = '".$amount_paid."', order_total_amount_due = '".$POST['amountDue']."', note = '".$POST['floatingNotes']."', modified_by = '".$_SESSION['username']."'
				WHERE order_id = '".$POST['invoiceId']."'";		
			
			mysqli_query($this->dbConnect, $sqlInsertInvoice);	
		}		
		$this->deleteInvoiceItems($POST['invoiceId']);
		for ($i = 0; $i < count($POST['productCode']); $i++) {			
			$sqlInsertItem = "
				INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount, modified_by) 
				VALUES ('".$POST['invoiceId']."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."', '".$_SESSION['username']."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);			
		}
		$action = "Invoice updated-" .$POST['invoiceId']. '-total ' .$POST['totalAftertax']. '-Paid  ' .$amount_paid.'-By  '.$_SESSION['username'];
			$this->activity_log($_SESSION['username'],$action);       	
	}	

	public function updateSambhavanaInvoice($POST) {
		if($POST['invoiceId']) {	
			
			
			$paymentTillNow = $POST['previousPayment'] + $POST['amountPaid'];
			if($paymentTillNow == $POST['totalAftertax']){
				$status = "Paid";
			}
			else if($paymentTillNow == 0){
				$status = "UnPaid";
			}
			else if($paymentTillNow < $POST['totalAftertax']){
				$status = "Partial";
			}
			else if($paymentTillNow > $POST['totalAftertax']){
				$status = "Bonus";
			}
			
			$sqlInsert = "
				UPDATE ".$this->eventsInvoiceOrderTable." 
				SET amountOffered = '".$POST['totalAftertax']."', amountReceived = '".$paymentTillNow."', amountPending = '".$POST['amountDue']."', note = '".$POST['floatingNotes']."', status = '".$status."', modified_by = '".$_SESSION['username']."' 
				WHERE sambhavanaId = '".$POST['invoiceId']."'";		
			mysqli_query($this->dbConnect, $sqlInsert);	
		}		
		$this->deleteSambhavanaInvoiceItems($POST['invoiceId']);
		for ($i = 0; $i < count($POST['productCode']); $i++) {			
			$sqlInsertItem = "
				INSERT INTO ".$this->sambhavanaOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount, modified_by) 
				VALUES ('".$POST['invoiceId']."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."', '".$_SESSION['username']."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);			
		} 
		$sqlInsertPayment = "
			INSERT INTO ".$this->auditTable."(sambhavanaId, eventid, eventName, zone, houseNumber, amount) 
			VALUES ('".$POST['invoiceId']."', '".$POST['eventid']."', '".$POST['eventName']."', '".$POST['zone']."', '".$POST['houseNumber']."', '".$POST['amountPaid']."')";			
			mysqli_query($this->dbConnect, $sqlInsertPayment);   
			$action = "Event Invoice updated-" .$POST['invoiceId']. '-total ' .$POST['totalAftertax']. '-Paid  ' .$paymentTillNow.'-By  '.$_SESSION['username'];
			$this->activity_log($_SESSION['username'],$action);   	
	}	

	public function getEventID($event){
		$sqlQuery = "
			SELECT id FROM ".$this->eventsTable." 
			WHERE Title = '".$_SESSION['userid']."'";
		return  $this->getData($sqlQuery);
	}	

	public function getSambhavanaItemsByID($id){
		$sqlQuery = "
			SELECT * FROM ".$this->sambhavanaItemsTable."
			WHERE itemid = '$id'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			return $row;
	}
	public function updateSambhavanaItemByID($POST){
		
		$sqlInsert = "
			UPDATE ".$this->sambhavanaItemsTable." 
			SET itemname = '".$POST['itemName']."', itemdesc= '".$POST['itemDescription']."', itemrate = '".$POST['rate']."' 
			WHERE itemid = '".$POST['itemid']."'";		
		mysqli_query($this->dbConnect, $sqlInsert);	
		$action = "Sambhavana Item updated-" .$POST['itemid']. ' ' .$POST['itemName']. ' '.$POST['itemDescription'].' '.$POST['rate'].' '.$_SESSION['username'];
			$this->activity_log($_SESSION['username'],$action); 
	
}

	public function getItemByID($id){
		$sqlQuery = "
			SELECT * FROM ".$this->itemsTable." 
			WHERE itemid = '$id'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			return $row;
	}

	public function updateItemByID($POST){
		
			$sqlInsert = "
				UPDATE ".$this->itemsTable." 
				SET itemname = '".$POST['itemName']."', itemdesc= '".$POST['itemDescription']."', itemrate = '".$POST['rate']."' 
				WHERE itemid = '".$POST['itemid']."'";		
			mysqli_query($this->dbConnect, $sqlInsert);	
			$action = "Item updated-" .$POST['itemid']. ' ' .$POST['itemName']. ' '.$POST['itemDescription'].' '.$POST['rate'].' '.$_SESSION['username'];
			$this->activity_log($_SESSION['username'],$action);
			
		
	}


	public function getInvoiceList(){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." ";
		return  $this->getData($sqlQuery);
	}
	public function getSambhavanaList(){
		$sqlQuery = "
			SELECT * FROM ".$this->eventsInvoiceOrderTable."";
		return  $this->getData($sqlQuery);
	}	
	public function getSambhavanaListByUser($houseNumber){
		$sqlQuery = "
		SELECT * FROM ".$this->eventsInvoiceOrderTable."
		WHERE houseNumber = $houseNumber
		ORDER BY date DESC";
		return  $this->getData($sqlQuery);
	}
	public function getSambhavanaListByCriteria( $event, $status , $date,$houseNumber,$sambhavanaId){
		echo "<script>console.log('Inside function: ' );</script>";
		try{
			
		$wheres = [];
		if(!empty($event)){
			$wheres[] = 'eventName = "'.$event.'"';	
		}
		if(!empty($date)){
			$wheres[] ='DATE(date) = "'.$date.'"';
		}
		if(!empty($houseNumber)){
			$wheres[] =  'houseNumber = "'.$houseNumber.'"';
		}
		if(!empty($sambhavanaId)){
			$wheres[] = 'sambhavanaId = "'.$sambhavanaId.'"';
		}
		if(!empty($status)){
			$wheres[] = 'status = "'.$status.'"';
		}
		$wheres = implode(" AND ", $wheres);
			$sql = "SELECT * FROM ".$this->eventsInvoiceOrderTable." WHERE $wheres";
			echo "<script>console.log('Query: ".$sql."' );</script>";
	
} catch (mysqli_sql_exception $e) { 
	var_dump($e);
	exit; 
}
return  $this->getData($sql);




	}

	public function getInvoiceListByCriteria( $order_date, $order_id){
		echo "<script>console.log('Inside function: ' );</script>";
		try{
			
		$wheres = [];
		if(!empty($order_date)){
			$wheres[] = 'DATE(order_date) = "'.$order_date.'"';	
		}
		if(!empty($order_id)){
			$wheres[] ='order_id = "'.$order_id.'"';
		}
		
		$wheres = implode(" AND ", $wheres);
			$sql = "SELECT * FROM ".$this->invoiceOrderTable." WHERE $wheres";
			echo "<script>console.log('Query: ".$sql."' );</script>";
	
} catch (mysqli_sql_exception $e) { 
	var_dump($e);
	exit; 
}
return  $this->getData($sql);




	}

	public function getInvoiceListByDateLimit( $order_date_from,$order_date_to, $order_id){
		echo "<script>console.log('Inside function: ' );</script>";
		try{
			
		$wheres = [];
		if(!empty($order_date_from)){
			$wheres[] = 'DATE(order_date) BETWEEN "'.$order_date_from.'"';	
		}
		if(!empty($order_date_to)){
			$wheres[] = '"'.$order_date_to.'"';	
		}
		if(!empty($order_id)){
			$wheres[] ='order_id = "'.$order_id.'"';
		}
		
		$wheres = implode(" AND ", $wheres);
			$sql = "SELECT * FROM ".$this->invoiceOrderTable." WHERE $wheres";
			echo "<script>console.log('Query: ".$sql."' );</script>";
	
} catch (mysqli_sql_exception $e) { 
	var_dump($e);
	exit; 
}
return  $this->getData($sql);




	}
	

	public function getIncomeByDateLimit( $order_date_from,$order_date_to){
		echo "<script>console.log('Inside function: ' );</script>";
		try{
			
		$wheres = [];
		if(!empty($order_date_from)){
			$wheres[] = 'DATE(date) BETWEEN "'.$order_date_from.'"';	
		}
		if(!empty($order_date_to)){
			$wheres[] = '"'.$order_date_to.'"';	
		}
		
		
		$wheres = implode(" AND ", $wheres);
			$sql = "SELECT * FROM ".$this->incomeTable." WHERE $wheres";
			echo "<script>console.log('Query: ".$sql."' );</script>";
	
} catch (mysqli_sql_exception $e) { 
	var_dump($e);
	exit; 
}
return  $this->getData($sql);




	}



	public function getExpenseByDateLimit( $order_date_from,$order_date_to){
		echo "<script>console.log('Inside function: ' );</script>";
		try{
			
		$wheres = [];
		if(!empty($order_date_from)){
			$wheres[] = 'DATE(date) BETWEEN "'.$order_date_from.'"';	
		}
		if(!empty($order_date_to)){
			$wheres[] = '"'.$order_date_to.'"';	
		}
		
		
		$wheres = implode(" AND ", $wheres);
			$sql = "SELECT * FROM ".$this->expenseTable." WHERE $wheres";
			echo "<script>console.log('Query: ".$sql."' );</script>";
	
} catch (mysqli_sql_exception $e) { 
	var_dump($e);
	exit; 
}
return  $this->getData($sql);




	}
	



	public function getInvoice($invoiceId){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." 
			WHERE user_id = '".$_SESSION['userid']."' AND order_id = '$invoiceId'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}	
	public function getPerson($personId){
		$sqlQuery = "
			SELECT * FROM ".$this->memberTable." 
			WHERE keyu = '".$personId."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}	

	public function updatePerson($POST) {
		if($POST['personId']) {	
			$sqlInsert = "
				UPDATE ".$this->memberTable." 
				SET fname = '".$POST['firstName']."', sname= '".$POST['middleName']."', lname = '".$POST['lastName']."', Gender = '".$POST['gender']."', Birthday = '".$POST['dob']."', housename = '".$POST['houseName']."', housenumber = '".$POST['houseNumber']."', zone = '".$POST['zone']."', mobile = '".$POST['mobileNumber']."' ,email= '".$POST['email']."', password = '".$POST['password']."', id = '".$POST['mobileNumber']."'
				WHERE keyu = '".$POST['personId']."'";		
			mysqli_query($this->dbConnect, $sqlInsert);	
			$action = "Updated person " . $_POST['firstName'] . ' ' . $_POST['middleName'] . ' ' . $_POST['lastName'] . '-HNo.' . $_POST['houseNumber'];
			$this->activity_log($_SESSION['username'],$action);
		}		
		      	
	}	
	public function getSambhavanaInvoice($invoiceId){
		$sqlQuery = "
			SELECT * FROM ".$this->eventsInvoiceOrderTable." 
			WHERE sambhavanaId = '$invoiceId'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}	


	public function getSambhavanaPaymentStatus($invoiceId,$eventId){
		$sqlQuery = "
			SELECT * FROM ".$this->auditTable." 
			WHERE sambhavanaId = '$invoiceId' AND eventid = '$eventId'";
			return  $this->getData($sqlQuery);
	}	
	
	public function getInvoiceItems($invoiceId){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '$invoiceId'";
		return  $this->getData($sqlQuery);	
	}
	public function getAllInvoiceItems(){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderItemTable." ";
		return  $this->getData($sqlQuery);	
	}
	public function getAllSambhavanaItems(){
		$sqlQuery = "
			SELECT * FROM ".$this->sambhavanaOrderItemTable."";
		return  $this->getData($sqlQuery);	
	}
	public function getSambhavanaByID($invoiceId){
		$sqlQuery = "
			SELECT * FROM ".$this->sambhavanaOrderItemTable."
			WHERE order_id = '$invoiceId'";
		return  $this->getData($sqlQuery);	
	}


	public function getItems(){
		$sqlQuery = "
			SELECT * FROM ".$this->itemsTable." ";
		return  $this->getData($sqlQuery);	
	}


	public function getIncomeItemsOfThisMonth(){
		$sqlQuery = "
			SELECT * FROM ".$this->incomeTable." 
			WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())";
		return  $this->getData($sqlQuery);	
	}

	public function getExpenseItemsOfThisMonth(){
		$sqlQuery = "
			SELECT * FROM ".$this->expenseTable." 
			WHERE MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())";
		return  $this->getData($sqlQuery);	
	}

	public function getIncomeItems(){
		$sqlQuery = "
			SELECT * FROM ".$this->incomeTable." ";
		return  $this->getData($sqlQuery);	
	}

	public function getExpenseItems(){
		$sqlQuery = "
			SELECT * FROM ".$this->expenseTable." ";
		return  $this->getData($sqlQuery);	
	}

	public function getUserLog(){
		$sqlQuery = "
			SELECT * FROM ".$this->logTable." ";
		return  $this->getData($sqlQuery);	
	}

	public function getActivityLog(){
		$sqlQuery = "
			SELECT * FROM ".$this->activityTable." ";
		return  $this->getData($sqlQuery);	
	}

	public function getSambhavanaItems(){
		$sqlQuery = "
			SELECT * FROM ".$this->sambhavanaItemsTable." ";
		return  $this->getData($sqlQuery);	
	}

	public function getEvents(){
		$sqlQuery = "
			SELECT * FROM ".$this->eventsTable." ";
		return  $this->getData($sqlQuery);	
	}

	public function getActiveEvents(){
		$sqlQuery = "
			SELECT * FROM ".$this->eventsTable."
			WHERE isactive = 1";
		return  $this->getData($sqlQuery);	
	}
	public function getEvent($id){
		$sqlQuery = "
			SELECT * FROM ".$this->eventsTable." WHERE id = '$id'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return  $row;
	}

	public function updateEvent($POST){
		
		$sqlInsert = "
			UPDATE ".$this->eventsTable." 
			SET Title = '".$POST['eventName']."', Date= '".$POST['date']."', content = '".$POST['eventDescription']."', isactive = '".$POST['active']."' 
			WHERE id = '".$POST['eventId']."'";		
		mysqli_query($this->dbConnect, $sqlInsert);	
		$action = "Updated event " . $_POST['eventName'] . ' ' . $_POST['date'] . ' ' . $_POST['eventDescription'] . '-Active.' . $_POST['active'];
			$this->activity_log($_SESSION['username'],$action);
	
}

	public function getMobileNumbers(){
		$sqlQuery = "
			SELECT mobile FROM ".$this->memberTable." ";
			$result = mysqli_query($this->dbConnect, $sqlQuery);
		
		// $data= array();
		// while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		// 	$data[]=$row;            
		// }
		return $result;
		// return  $this->getData($sqlQuery);	
	}




	public function deleteInvoiceItems($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);	
		$action = "Deleted Invoice Items ".$invoiceId;
			$this->activity_log($_SESSION['username'],$action);			
	}

	public function deleteSambhavanaInvoiceItems($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->sambhavanaOrderItemTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);	
		$action = "Deleted Sambhavana invoice ".$invoiceId;
			$this->activity_log($_SESSION['username'],$action);	

	}
	
	public function deleteInvoice($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->invoiceOrderTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);	
		$this->deleteInvoiceItems($invoiceId);	
		$action = "Deleted Invoice ".$invoiceId;
			$this->activity_log($_SESSION['username'],$action);	
		return 1;

	}
	public function saveEvent($POST) {	
		
		$sqlInsert = "
			INSERT INTO ".$this->eventsTable."(Title,Date,content,isactive) 
			VALUES ('".$POST['eventName']."', '".$POST['date']."', '".$POST['eventDescription']."','".$POST['active']."')";		
		mysqli_query($this->dbConnect, $sqlInsert);
		$action = "Event saved" . $_POST['eventName'] . ' ' . $_POST['date'] . ' ' . $_POST['eventDescription'] . '-Active.' . $_POST['active'];
			$this->activity_log($_SESSION['username'],$action);
		
		      	
	}	

	
}
?>