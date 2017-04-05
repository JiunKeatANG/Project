<!--Name: Jiun Keat ANG
Main function : Login for existing member -->

<?php
ob_start();
session_start();
?>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="author" content="Chris Ang" />
	<title>Login System</title>
</head>

<body>
	<h1>Login Page</h1>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="off">
		<fieldset>
			<label>Customer Number: </label>
			<input type="text" name="cnumber"/>
			<br/><br/>
			<label>Password: </label>
			<input type="password" name="password"/>
			<br/><br/>
			<input type="submit" value="Login" name="login" />
		</fieldset>
	</form>

	<a href="shiponline.php">Home</a>
</body>

<?php
if(isset($_POST['login']) && isset($_POST['cnumber'])  && isset($_POST['password'])){
$dbconnect = mysqli_connect("localhost", "root", "root", "s4917413_db")
Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ". mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";

$cnumber = $_REQUEST['cnumber'];
$password = $_REQUEST['password'];



$select_cnumber = mysqli_query($dbconnect, "SELECT * FROM Register WHERE CustomerNumber='$cnumber'");
$row = mysqli_fetch_array($select_cnumber);
$customernumber = $row['CustomerNumber'];

$select_password = mysqli_query($dbconnect, "SELECT * FROM Register WHERE Password='$password'");
$row2 = mysqli_fetch_array($select_password);
$passwordd = $row2['Password'];





if (empty($cnumber) OR empty($password))
{
	echo "<p>Customer Number or Password cannot be blank!</p>";
}

elseif($customernumber != $cnumber OR $passwordd !=$password)
{
	echo "<p>Wrong Customer Number or Password!</p>";
}
	else
	{
		
		$_SESSION['cnumber']=$cnumber;
		$_SESSION['password']=$password;
		header("Location: http://www.google.com");
		die();
		//echo "<p>Successfully Login! Press the link to proceed <a href=Request.php>Request</a></p>";
	}

}

?>
</html>
<?php ob_end_flush(); ?>

