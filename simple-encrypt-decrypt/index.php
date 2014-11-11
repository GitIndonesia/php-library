<?php include "class_encrypt_decrypt.php"; ?>
<form method="post" action="">
<input type='text' name='user' placeholder='ecrypt' style='width: 160'>
 <button type="submit" name="submit" value="submit" class="btn btn-large">Submit</button>
<?php
  if(isset($_POST['submit'])) {
  	$user = encrypt($_POST['user']);
	$pass = decrypt($user);
  }
  
  $encrypt = isset($user) ? $user : "";
  $decrypt = isset($pass) ? $pass : "";
  
  echo "</br></br>";
  echo "Encrypt : ".$encrypt;
  echo "<br>";
  echo "Decrypt : ".$decrypt;
  
?>
</form>