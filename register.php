<?php 
include('validation_functions.php');
require_once("connect.php");
include('queries.php');
include('mailer.php');


$errMsg=array();
$is_valid= true;

if (isset($_POST["butsubmit"])){
    $userName = htmlentities($_POST["txtFirstName"], ENT_QUOTES,"UTF-8");
    $email = htmlentities($_POST["txtEmail"], ENT_QUOTES,"UTF-8");
    
    

    if ($userName ==""){
      $is_valid = false;
      $errMsg[]="Please enter a first name!";

    }
    if (verifyEmail($email)==false){
    $is_valid = false;
    $errMsg[]="Please enter a valid email!";
    }
  
    if($is_valid){

        postUser($userName, $email, $db);
        
        $subject="Thanks for registering!";
        $message="Thank you ".$userName." for registering to the site.";

        sendMail($email, $subject, $message);
       // header("Location: thanks.php");
    }
}

include("top.php"); ?>

<body id="register">

<?php
include("header.php");

include("nav.php");

?>

<?php
  if($is_valid==false){

    $html="";
    $html.="<div id=\"errors\">";

    foreach($errMsg as $error){
      $html.=$error."<br />";
    }

    $html.="</div>";

    echo $html;
  }
//<div id="errors"></div>
?>    
<form action="/~icarter/cs148/assignment7.1/register.php" 
      method="post"
      id="frmRegister">
			
<fieldset class="wrapper">
  <legend>J&#216;IN THE &#216;CCULTISTS &#216;NLINE DICTI&#216;NARY</legend>
  <p><span class='required'></span></p>

<fieldset class="intro">
<legend>Please c&#248;mplete the f&#248;ll&#248;wing f&#248;rm</legend>

<fieldset class="contact">
<legend>C&#248;ntact Inf&#248;rmation</legend>					
	<label for="txtFirstName" class="required">First Name</label>
  	<input type="text" id="txtFirstName" name="txtFirstName" 
                              value="" 
    		tabindex="100" maxlength="25" placeholder="enter your first name" autofocus onfocus="this.select()" >
				
	<label for="txtEmail" class="required">Email</label>
  	<input type="email" id="txtEmail" name="txtEmail" value="icarter@uvm.edu"
    		tabindex="110" maxlength="45" placeholder="enter a valid email address" onfocus="this.select()" >

</fieldset>		

<fieldset class="buttons">
    <legend></legend>                
    <input type="submit" id="butsubmit" name="butsubmit" value="submit" tabindex="991" class="button" onclick="reSetForm()">
  <input type="reset" id="butreset" name="butreset" value="reset" tabindex="993" class="button" onclick="reSetForm()" >
</fieldset>  
<img src="Manuscript.JPG" alt="">
</form>

<?php include("footer.php");?>
			


</body>
</html>
