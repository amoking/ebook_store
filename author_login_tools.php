<?php
function load($page='author_login.php')#Loads the login page
{
	$url = 'http://'.$_SERVER['HTTP_HOST'].
						dirname($_SERVER['PHP_SELF']);
	$url= rtrim($url,'/\\');
	$url .='/'.$page;
	exit();
	header("Location:$url");
	exit();
}
function validate($dbc, $email ='',$pwd='')#Validates login attempts.
{
	$errors =array();
	if(empty($email))
	{$errors[]='Enter your email address.';}
	else
	{$e= mysqli_real_escape_string($dbc, trim($email));}
	if (empty($pwd))
	{$errors[]= 'Enter your password.';}
	else
	{$p= mysqli_real_escape_string($dbc, trim($pwd));}
	if (empty ($errors))
	{
		$q= "SELECT author_id,first_name,last_name
		FROM authors 
		WHERE email='$e'
		AND password= SHA1('$p')";
		$r= mysqli_query($dbc,$q);
		if(mysqli_num_rows($r)==1)
		{
			$row = mysqli_fetch_array($r,MYSQLI_ASSOC);
			return array(true,$row);
		}
		else{$errors[]= 'Email address and password not found';}
		return array(false,$errors);
	}

}

?>