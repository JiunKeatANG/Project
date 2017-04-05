<!--Name: Jiun Keat ANG

Main function : New member to register -->
<html>
<head>
<style>.error {color: red}</style>
	<meta charset="utf-8" />
	<meta name="author" content="Chris Ang" />
	<link rel="stylesheet" href="register.css" type="text/css" />
	<title>Registration System</title>
</head>


<body>

<?php
$dbconnect = mysqli_connect("localhost", "root", "root", "s4917413_db")
Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ". mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";
$nameErr = $passErr = $cpassErr = $emailErr = $phoneErr = ""; 
$name = $password = $confrimpassword = $email = $phone = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["name"])) {
		$nameErr = "Please enter your name";
	} else {
		$name = test_input($_POST["name"]);
		if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
			$nameErr = "Only letters and white space allowed";
		}
	}
	
	
	if (empty($_POST["password"])) {
		$passErr = "Password cannot be empty";
	} else {
		$password = test_input($_POST["password"]);
		if (strlen($password)<6 OR strlen($password) > 15) {
		$passErr = "Password length can only be within 6-15";
	}
	}
	
	if (empty($_POST["confrimpassword"])) {
		$cpassErr = "Please enter the same password!";
	} else {
		$confrimpassword = test_input($_POST["confrimpassword"]);
		if ($confrimpassword != $password) {
		$cpassErr = "Please enter the same password!";
	}
	}
	
	if (empty($_POST["email"])) {
		$emailErr = "Email is required";
	} else {
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$emailErr = "Invalid email format";
	}
	}
	
	if (empty($_POST["phone"])) {
		$phoneErr = "Please enter your contact no.";
	} else {
		$phone = test_input($_POST["phone"]);
		if (preg_match("/^[a-zA-Z ]*$/",$phone)) {
		$phoneErr = "Please enter only number";
	}
		elseif(strlen($phone)<10){
			$phoneErr = "Please enter a valid phone number";
		}
	}
	$emailcheck = "SELECT EmailAddress FROM Customer WHERE EmailAddress='$email'";
	$email_check = mysqli_query($dbconnect, $emailcheck);
	$do_email_check = mysqli_num_rows($email_check);

	if($do_email_check>0){
		$emailErr= "Email is already in use!";
	}
}
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

	<h1><em>Registration</em>  Page</h1>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="form">
		<fieldset>
			
			<input type="text" name="name"  placeholder="Name" value="<?php echo $name;?>">
			<span class="error"><?php echo $nameErr;?></span>
			<br/><br/>
		
			<input type="password" name="password" placeholder="Password" value="<?php echo $password;?>">
			<span class="error"><?php echo $passErr;?></span>
			<br/><br/>
			
			<input type="password" name="confrimpassword" placeholder = "Confirm Password" value="<?php echo $confrimpassword;?>">
			<span class="error"><?php echo $cpassErr;?></span>
			<br/><br/>
			
			<input type="text" name="email" placeholder="E-mail Address" value="<?php echo $email;?>">
			<span class="error"><?php echo $emailErr;?></span>
			<br/><br/>									
			
			<input type="text" name="phone" placeholder="Contact Number" value="<?php echo $phone;?>">
			<span class="error"><?php echo $phoneErr;?></span>
			<br/><br/>
			<input type="submit" value="Register" name="submit"/>
		</fieldset>
	</form>

	
</body>

<?php
if(isset($_POST['submit']) && $nameErr=='' &&  $passErr=='' && $cpassErr=='' && $emailErr=='' && $phoneErr==''){
$dbconnect = mysqli_connect("localhost", "root", "root", "s4917413_db")
Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ". mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";


$name = mysqli_real_escape_string($dbconnect, $_POST['name']);
$password = mysqli_real_escape_string($dbconnect, $_POST['password']);
$email = mysqli_real_escape_string($dbconnect, $_POST['email']);
$phone = mysqli_real_escape_string($dbconnect, $_POST['phone']);
$name = $_POST['name'];

$sql = "INSERT INTO Register (Name, Password, EmailAddress, Contact)
VALUES ('$name', '$password', '$email', '$phone')";



if (!mysqli_query($dbconnect, $sql)) {
	die('Error: '. mysqli_error($dbconnect));
	}
	$select_cnumber = mysqli_query($dbconnect, "SELECT CustomerNumber FROM Register WHERE EmailAddress='$email'");
	$row = mysqli_fetch_array($select_cnumber);
	$customernumber = $row['CustomerNumber'];
	
	
	echo "<p>Dear $name, Successfully registered!  Your customer number is $customernumber</p>";
	//echo "<p>Press the link to login <a href=Login.php>Login</a></p>";
		mysqli_close($dbconnect);

}

?>
</html>