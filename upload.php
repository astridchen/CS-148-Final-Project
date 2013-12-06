<?php
  $debug=false; 
  require_once("connect.php");
  include("queries.php");
  include("top.php");

  echo '<body id="form">';
  include("header.php");
  include("nav.php");
  echo "<pre>"; print_r($_POST); echo "</pre>";
  echo "<pre>"; print_r($_FILES); echo "</pre>";

$sigil_location = "/users/i/c/icarter/public_html/cs148/assignment7.1/uploaded_sigils/";
# Variables
$sigilName = "";
$description = "";
$magic = false;
$astrology = false;
$alchemy = false;
$alphabet = false;
$purpose = '';

# Error Variables
$sigilNameERROR = false;
$descriptionERROR = false;
$butuploadERROR = false;

if (isset($_POST["butsubmit"])){
  # Check to see if someone's trying to hack us
  #if(getenv("http_referer") != "https://www.uvm.edu/~icarter/cs148/assignment7.1/upload.php"){
  #  die("<p>Sorry you cannot access this page.</p>");
  #} 
    
  # Convert $_POST to PHP Variables
  $sigilName = htmlentities($_POST["txtsigilName"], ENT_QUOTES,"UTF-8");
  $description = htmlentities($_POST["txtdescription"], ENT_QUOTES,"UTF-8");
  $alphabet = htmlentities($_POST["lstalphabetType"], ENT_QUOTES, "UTF-8");

  if (isset($_POST["chkMagic"])) {
    $magic = true;
  }
    
  if (isset($_POST["chkAstrology"])) {
    $astrology = true;
  }

	if (isset($_POST["chkAlchemy"])) {
    $alchemy = true;
  }

  include ("validation_functions.php"); // you need to create this file (see link in lecture notes)    
  $errorMsg=array();
  $dataRecord=array();
  
  if(empty($sigilName)){
    $errorMsg[]="Please enter a sigil name!";
    $sigilNameERROR = true;
  } else {
    $valid = verifyAlphaNum($sigilName); /* test for non-valid  data */
    if (!$valid){ 
      $errorMsg[]="Sigil name must be letter characters.";
      $sigilNameERROR = true;
    }
  }

  if(empty($description)){
    $errorMsg[]="Please fill in a proper description";
    $descriptionERROR = true;
  } else {
    $valid = verifyAlphaNum ($description); /* test for non-valid  data */
    if (!$valid){ 
      $errorMsg[]="Description must be letters and numbers only.";
      $descriptionERROR = true;
    }
  }

  if ($FILES['butupload']['error'] != 0)
  {
    $errorMsg[] = "Please upload an image!";
    $butuploadERROR = true;
  }

  # If we found no errors, put the info into the database.
  if(!$errorMsg){    
    $new_sigil_id = putSigils($sigilName, $description, $alphabet, $db);
    if ($magic)
    {
      putSigilPurpose($new_sigil_id, 'magic', $db);
    }
    if ($astrology)
    {
      putSigilPurpose($new_sigil_id, 'astrology', $db);
    }
    if ($alchemy)
    {
      putSigilPurpose($new_sigil_id, 'alchemy', $db);
    }
    
		#$sql2 = 'INSERT INTO tblSigilPurpose SET fkPurposeId="' .$foreignKeySigilPurposeId . '"';
		#$stmt2 = $db->prepare($sql4);
		#$stmt2->execute();
		#$sql3 = 'INSERT INTO tblAlphabets SET fldType="' . $type . '"';
		#$stmt3 = $db->prepare($sql2);
		#$stmt3->execute();
		#$primaryKeyAlphabet = $db->lastInsertId();
    #$sql4 = 'INSERT INTO tblSigilImages SET fkImageId="' . $foriegnKeySigilImageId . '"';
    #$stmt4 = $db->prepare($sql2);
    #$stmt4->execute();
    #$primaryKeyAlphabet = $db->lastInsertId();
	

    if ($_FILES['butupload']['error'] == 0)
    {
    $s = preg_split('/\//', $_FILES['butupload']['type']);
    $ext = $s[1];

    $filename=$_FILES["butupload"]["name"];
    $parts = explode(".", $filename);
    $file = $parts[0];
    $extension =$parts[1];

    $tempname=$file;


    $i=0;
    while(file_exists($sigil_location.$tempname.".".$extension)){
      $tempname=$file."_".$i;
      $i++;
    }

    $filename=$tempname.".".$extension;

    move_uploaded_file($_FILES['butupload']['tmp_name'], $sigil_location .$filename);

    //Insert image name into database and get image id back (tblImages)
    $image_id=postImage($filename, $db);

    //insert image id and sigil id in tblSigilImages 
    putSigilImages($new_sigil_id, $image_id, $db);

    }

  } // no errors      
} // ends if form was submitted. We will be adding more information ABOVE this



if (isset($_POST["butsubmit"]) AND empty($errorMsg)){ 
  print "<h1>Your submission was successful</h1>";
} 

if($errorMsg){
  echo "<h1>ERRORS!</h1><ol>\n";
  foreach($errorMsg as $err){
    echo "<li>" . $err . "</li>\n";
  }
  echo "</ol>\n";
} 

?>

<p><img src="Eye.JPG" alt="" height="70" width="70">UPL&#216;AD A SIGIL T&#216; THE SITE </p>
<form action="<? print $_SERVER['PHP_SELF']; ?>" 
      method="post"
      id="frmRegister"
      enctype="multipart/form-data">
            
<fieldset class="wrapper">
  <p><span class='required'></span></p>

<fieldset class="intro">
<legend>Please c&#248;mplete the f&#248;ll&#248;wing f&#248;rm</legend>

<fieldset class="Definition of the Sigil">
<legend></legend> 
                   
    <label for="txtSigilName" class="required">Sigil Name</label>
      <input type="text" id="txtsigilName" name="txtsigilName" value="<?php echo $sigilName; ?>"
            tabindex="100" maxlength="25" placeholder="Enter Sigil Name" autofocus onfocus="this.select()" >
            
    <label for="txtdescription" class="required">Description</label>
      <input type="text" id="txtdescription" name="txtdescription" value="<?php echo $description; ?>"
            tabindex="110" maxlength="45" placeholder="Enter a valid definition" onfocus="this.select()" >
</fieldset>                    

<fieldset class="checkbox">
    <legend>What is this sigil used f&#248;r?</legend>
      <label><input type="checkbox" id="chkMagic" name="chkMagic" value="Magic" tabindex="221" 
            <?php if($Magic) echo ' checked ';?>> Magic</label>
            
    <label><input type="checkbox" id="chkAstrology" name="chkAstrology" value="Astrology" tabindex="223" 
            <?php if($Astrology) echo ' checked ';?>> Astrology</label>
            
    <label><input type="checkbox" id="chkAlchemy" name="chkAlchemy" value="Alchemy" tabindex="223" 
            <?php if($Alchemy) echo ' checked ';?>> Alchemy</label> 

</fieldset>

<fieldset class="lists">    
    <legend>Alphabet</legend>
    <select id="lstalphabetType" name="lstalphabetType" tabindex="281" size="1">
        <option value="Theban" <?php if($type=="Theban") echo ' selected="selected" ';?>>Theban</option>
        <option value="Runic" <?php if($type=="Runic") echo ' selected="selected" ';?>>Runic</option>
        <option value="Hermetic" <?php if($type=="Hermetic") echo ' selected="selected" ';?>>Hermetic</option>
    </select>
</fieldset>

<fieldset class="buttons">
    <legend></legend>                
    <input type="file" name="butupload" value="upload" class="button">
	<input type="submit" name="butsubmit" value="submit" class="button">
</fieldset>                    

</fieldset>
</fieldset>
</form>

<?php
include("footer.php");
?>

</body>
</html>