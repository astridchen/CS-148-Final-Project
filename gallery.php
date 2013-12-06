<?php 
require_once("connect.php");
include("queries.php");

$sigils = getSigils($db);

include("top.php");?>

<body id="gallery">

<?php include("header.php");?>

<?php include("nav.php");?>

<div id="contentwrapper">

<img src="header.JPG" alt="">

<p>ALPHABETS AN&#208; MANUSCRIPTS</p>

<img src="gallery4.JPG" alt="" width="250" height="300">
<img src="gallery5.JPG" alt="" width="250" height="300">
<img src="gallery7.JPG" alt="" width="250" height="300">
<img src="gallery8.JPG" alt="" width="250" height="300">
<img src="gallery9.JPG" alt="" width="250" height="300">
<img src="gallery10.JPG" alt=""width="250" height="300">
<img src="gallery11.JPG" alt=""width="250" height="300">
<img src="gallery12.JPG" alt=""width="250" height="300">
<br />
<?php 
	$html="";

	foreach($sigils as $sigil){ 
		$html.= '<hr />';
		$html.= '<p class="sigil_name">'.$sigil['fldSigilName'].'</p>';
		$html.= '<p class="sigil_description">'.$sigil['fldDescription'].'</p>';
		$html.= '<p class="sigil_alphabet">'.$sigil['fkAlphabet'].'</p>';
		$html.= '<img src="uploaded_sigils/'.$sigil['fldImageName'].'" alt=""width="250" height="300">';
	}
	echo $html;

?>

</div>

</body>
</html>

<?php include("footer.php");?>