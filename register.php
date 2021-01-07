<?php

	if(isset($_POST['register'])) {
		$errMsg = '';

		// Get data from FROM
		$fullname = $_POST['fullname'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];

		if($fullname == '')
			$errMsg = 'Name';
		if($username == '')
			$errMsg = 'Username';
		if($password == '')
			$errMsg = 'Password';
		if($email == '')
			$errMsg = 'Email';

		if($errMsg == ''){
			try {
				$stmt = $pdo->prepare('INSERT INTO users (fullname, username, password, email) VALUES (:fullname, :username, :password, :email)');
				$stmt->execute(array(
					':fullname' => $fullname,
					':username' => $username,
					':password' => $password,
					':email' => $email
					));
                                header('Location: index.php?page=login');
				exit;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
	}

?>

<?=template_header('Register')?>
<style><!--
#container{width:400px; margin: 0 auto;}
--></style>
<script type="text/javascript" language="javascript">
function submitreg() {
    var form = document.reg;
    if(form.name.value == ""){
        alert( "Type your name." );
        return false;
    }
    else if(form.uname.value == ""){
        alert( "Type tour username." );
        return false;
    }
    else if(form.upass.value == ""){
        alert( "Type your password." );
        return false;
    }
    else if(form.uemail.value == ""){
        alert( "Type your email." );
        return false;
    }
}
</script>
<div id="container">
<h1>New User</h1>
<form action="" method="post" name="reg">
<table>
<tbody>
<tr>
<th>FULL NAME:</th>
<td><input type="text" name="fullname" required="" value="<?php if(isset($_POST['fullname'])) echo $_POST['fullname'] ?>" /></td>
</tr>
<tr>
<th>USERNAME:</th>
<td><input type="text" name="username" required="" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>"/></td>
</tr>
<tr>
<th>Email:</th>
<td><input type="text" name="email" required="" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>"/></td>
</tr>
<tr>
<th>PASSWORD:</th>
<td><input type="password" name="password" required="" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" /></td>
</tr>
<tr>
<td></td>
<td><input onclick="return(submitreg());" type="submit" name="register" value="Register" /></td>
</tr>
<tr>
<td></td>
<td><a href="index.php?page=login">This user already exist! Click here!</a></td>
</tr>
</tbody>
</table>
</form></div>
<?=template_footer()?>
