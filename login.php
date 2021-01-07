<?php

	if(isset($_POST['login'])) {
		$errMsg = '';

		// Get data from FORM
		$username = $_POST['username'];
		$password = $_POST['password'];

		if($username == '')
			$errMsg = 'Type username';
		if($password == '')
			$errMsg = 'Type password';

		if($errMsg == '') {
			try {
				$stmt = $pdo->prepare('SELECT id, fullname, username, password, email FROM users WHERE username = :username');
				$stmt->execute(array(
					':username' => $username
					));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);

				if($data == false){
					$errMsg = "User $username not found.";
				}
				else {
					if($password == $data['password']) {
						$_SESSION['name'] = $data['fullname'];
						$_SESSION['username'] = $data['username'];
						$_SESSION['password'] = $data['password'];
						$_SESSION['email'] = $data['email'];

						header('Location: index.php?page=home');
						exit;
					}
					else
						$errMsg = 'Password not match.';
				}
			}
			catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}
	}

?>
<?=template_header('Login')?>
<style><!--#container{width:500px; margin: 0 auto;}--></style>
<span style="font-family: 'Courier 12, Courier, monospace; font-size: 12px; font-style: normal; line-height: 1;">
<div id="container"></span>
<h1>Login</h1>
<form action="" method="post">
<table>
<tbody>
<tr>
<th>User:</th>
<td><input type="text" name="username"  value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" /></td>
</tr>
<tr>
<th>Password:</th>
<td><input type="password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" /></td>
</tr>
<tr>
<td></td>
<td><input  type="submit" name="login" value="Login" /></td>
</tr>
<tr>
<td></td>
<td><a href="index.php?page=register">User Nou</a></td>
</tr>
</tbody>
</table>
</form></div>
<?=template_footer()?>
