<?php
include('queries.php');
//?q=email

$email=$_GET['q'];

confirmEmail($email);

include("top.php");
include("nav.php");

?>

<p><center>Thanks for confirming the email <?php echo $email ?>!</center></p>

<?php


include("footer.php");





?>