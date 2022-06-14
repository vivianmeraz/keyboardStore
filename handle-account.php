<?php
	class Account
	{
		private $pdo;
		
		function __construct($pdo) {
			$this->pdo = $pdo;
		}

		public function createUniqueUserID($firstName, $lastName)
		{
			// initialize userID
			$userID = '';

			// all uppercase letters
			strtoupper($firstName);
			strtoupper($lastName);

			// // append first name with zeroes if user's name has less than 3 letters
			// if (strlen($firstName) < 3)
			// {
			// 	while (strlen($firstName) < 3)
			// 		$firstName .= "0";
			// }
			// else
			// {
			// 	$firstName = substr($firstName, 0, 3);
			// }

			// // append last name with zeroes if user's name has less than 3 letters
			// if (strlen($lastName) < 3)
			// {				
			// 	while (strlen($lastName) < 3)
			// 		$lastName .= "0";
			// }
			// else
			// 	$lastName = substr($lastName, strlen($lastName) - 3, 3);

			//get row count
			$sql = "SELECT `AUTO_INCREMENT` FROM `USER_TABLE`";
			$query = $this->pdo->prepare($sql);

			// assign three-digit # to user
			$rows = $query->rowCount();
			$rows++;

			// create unique userID
			$userID .= $firstName . $lastName . strval($rows) . strval(1);

			$query->last_insert_id;
			
			return $this->stringToNumbers($userID) + $rows;
		}

		public function stringToNumbers($string)
		{
			if($string)
			{
				return ord(strtolower($string));
			}
			else
				return 0;
		}

		public function Register($firstName, $lastName, $email, $password,
								 $billingAddress, $billingCity, $billingState, $billingZipcode,
								 $shippingAddress, $shippingCity, $shippingState, $shippingZipcode)
		{
			// create unique userID
			$userID = $this->createUniqueUserID($firstName, $lastName);

			// hash password
			$password_encrypted = password_hash($password, PASSWORD_DEFAULT);
			
			// create insert query

			$sql = "INSERT INTO `USER_TABLE` (`user_ID`, `user_FirstName`, `user_LastName`, `user_Email`, `user_Password`, `user_BillingAddress`, `user_BillingCity`, `user_BillingState`, `user_BillingZipcode`, `user_ShippingAddress`, `user_ShippingCity`, `user_ShippingState`, `user_ShippingZipcode`, `user_Comments`, `user_PaymentCardNo`, `user_PaymentCardholderName`, `user_PaymentCardExpMM`, `user_PaymentCardExpYY`, `user_PaymentCardCVV`) VALUES ('0', '$firstName', '$lastName', '$email', '$password_encrypted', '$billingAddress', '$billingCity', '$billingState', '$billingZipcode', '$shippingAddress', '$shippingCity', '$shippingState', '$shippingZipcode', '', '', '', '', '', '')";

			return $this->pdo->exec($sql);

		}

		public function Login($email, $password)
		{
			$sql = "SELECT `user_ID`, `user_Email`, `user_Password`, `admin_flag` FROM `USER_TABLE` WHERE `user_Email` = '$email'";

			$query = $this->pdo->prepare($sql);
			$query->execute();
			$accInfo = $query->fetch(PDO::FETCH_ASSOC);

			// if password is correct
			if (password_verify($password, $accInfo['user_Password']))
			{	
					return $accInfo;
			}
			else
				return false;
		}

		
		public function doesEmailExist($email)
		{
			// $pdo = pdo_connect_mysql();

			$sql = "SELECT `user_ID` FROM `USER_TABLE` WHERE `user_Email` = '$email'";
			$query = $this->pdo->prepare($sql);
			$query->execute();

			if ($query->rowCount() > 0)
				return true;
			else
				return false;
		}

		public function passwordValidation($password)
		{
			$uppercase = preg_match('@[A-Z]@', $password);
			$lowercase = preg_match('@[a-z]@', $password);
			$number    = preg_match('@[0-9]@', $password);

			if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
				return false;
			}
			else
				return true;

			// $regex = '^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]{8,}$';
			// if (preg_match($regex, $password))
			// 	return true;
			// else
			// 	return false;
		}

		public function getAccountDetails($userID)
		{
			$sql = "SELECT * FROM `USER_TABLE` WHERE `user_ID` = '$userID'";

			$query = $this->pdo->prepare($sql);
			$query->execute();

			return $query->fetch(PDO::FETCH_ASSOC);
		}

		public function getTransactions($userID)
		{
			$sql = "SELECT * FROM `ORDER_TABLE` WHERE `user_ID` = '$userID' ORDER BY `order_Date` ASC";
			$query = $this->pdo->prepare($sql);
			$query->execute();
			
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}


		public function updateAccountInfo($userID, $firstName, $lastName, $email)
		{
			$sql = "UPDATE `USER_TABLE` SET `user_ID` = '$userID', `user_FirstName` = '$firstName', `user_LastName` = '$lastName', `user_Email` = '$email' WHERE `user_ID` = '$userID'";

			$this->pdo->prepare($sql);

			return $this->pdo->exec($sql);
		}

		public function resetPassword($userID, $attemptedPassword)
		{
			
		}

		public function updateBillingAddress($userID, $billingAddress, $billingCity, $billingState, $billingZipcode)
		{
			$sql = "UPDATE `USER_TABLE` SET `user_BillingAddress` = '$billingAddress', `user_BillingCity` = '$billingCity', `user_BillingState` = '$billingState', `user_BillingZipcode` = '$billingZipcode' WHERE `USER_TABLE`.`user_ID` = '$userID'";
			$this->pdo->prepare($sql);

			return $this->pdo->exec($sql);
		}

		public function updateShippingAddress($userID, $shippingAddress, $shippingCity, $shippingState, $shippingZipcode)
		{
			$sql = "UPDATE `USER_TABLE` SET `user_ShippingAddress` = '$shippingAddress', `user_ShippingCity` = '$shippingCity', `user_ShippingState` = '$shippingState', `user_ShippingZipcode` = '$shippingZipcode' WHERE `user_ID` = '$userID'";

			return $this->pdo->exec($sql);
		}
		
		public function updateSameBillingShipping($userID, $billingAddress, $billingCity, $billingState, $billingZipcode)
		{
			$sql = "UPDATE `USER_TABLE` SET `user_BillingAddress` = '$billingAddress', `user_BillingCity` = '$billingCity', `user_BillingState` = '$billingState', `user_BillingZipcode` = '$billingZipcode', `user_ShippingAddress` = '$billingAddress', `user_ShippingCity` = '$billingCity', `user_ShippingState` = '$billingState', `user_ShippingZipcode` = '$billingZipcode' WHERE `user_ID` = '$userID'";

			return $this->pdo->exec($sql);
		}	

		public function updatePaymentInfo($userID, $paymentCardNo, $paymentCardholderName, $paymentCardExpMM, $paymentCardExpYY, $paymentCardCVV)
		{
			$sql = "UPDATE `USER_TABLE` SET `user_PaymentCardNo` = '$paymentCardNo', `user_PaymentCardholderName` = '$paymentCardholderName', `user_PaymentCardExpMM` = '$paymentCardExpMM', `user_PaymentCardExpYY` = '$paymentCardExpYY', `user_PaymentCardCVV` = '$paymentCardCVV' WHERE `user_ID` = '$userID'";

			return $this->pdo->exec($sql);
		}

		function redactPaymentCardNo($card)
		{
			$redacted = substr($card, -4);
			
			while (strlen($redacted) < 12)
				$redacted = 'X' . $redacted;
	
			echo htmlentities($redacted);
		}


	}

?>