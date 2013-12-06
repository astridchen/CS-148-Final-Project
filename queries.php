<?php

function getSigils($db){
	$query="select pkSigilId, fldDescription, fldSigilName, fkAlphabet, pkImageId, fldImageName from tblSigils s
				left join tblSigilImages si on si.fkSigilId=s.pkSigilId
				left join tblImages i on i.pkImageId=si.fkImageId
			";
				
	$results=$db->query($query);
	
	$results=$results->fetchAll();
	
	return $results;

}
function putSigils($name, $desc, $alphabet, $db)
{
	$sql = "INSERT INTO `tblSigils` VALUES (NULL ,  '$name',  '$desc',  '$alphabet')";
	$stmt = $db->prepare($sql);			
	$stmt->execute();
	return $db->lastInsertId();
}

function postImage($filename, $db){
	$sql = "INSERT INTO `tblImages` set 
				fldImageName='$filename'";
	$stmt = $db->prepare($sql);			
	$stmt->execute();
	return $db->lastInsertId();

}


function putSigilPurpose($sigil_id, $purpose, $db)
{
	$sql = "INSERT INTO `tblSigilPurpose` VALUES (NULL ,  '$sigil_id',  '$purpose')";
	$stmt = $db->prepare($sql);			
	$stmt->execute();
	return $db->lastInsertId();
}


function putSigilImages($sigil_id, $image_id, $db)
{
	$sql = "INSERT INTO `tblSigilImages` SET
				fkSigilId='$sigil_id',  
				fkImageId='$image_id'";
	$stmt = $db->prepare($sql);			
	$stmt->execute();
}

function postUser($FirstName, $email, $db)
{
	$sql = "INSERT INTO `tblUser` VALUES (NULL ,  '$FirstName',  '$email')";
	$stmt = $db->prepare($sql);			
	$stmt->execute();
	return $db->lastInsertId();
}



?>