<?php

function nextimg($name)
{
	global $home;
	global $path2racephoto;

	//Create a variable containing the path
	//to the initial directory
	$path = $path2racephoto;

//echo "sub() path2racephoto=$path2racephoto ";
	//Create an array to hold the files
	$filesArray = array();

	//Pass the array by reference
	GetDirContFiles($path,&$filesArray,$name.".jpg");

	if(count($filesArray) > 1){
		rsort ($filesArray);
		reset ($filesArray);
		$imgnos = count($filesArray);
		echo "
<SCRIPT LANGUAGE='JavaScript'>
imgno = 0;
function nextimg(){
	if(imgno >= ($imgnos-1))
		imgno = 0;
	else
		imgno++;
	document.images[\"racephoto\"].src = arImageList[imgno].src;
	document.images[\"racephoto\"].alt = arImageList[imgno].alt;
	return false;
}
arImageList = new Array ();\n";
	for($i = 0, $j=0; $i < $imgnos; $i++){
		echo "
arImageList[$j] = new Image();
arImageList[$j].src = \"".$filesArray[$i]."\";
arImageList[$j].alt = \"".substr($filesArray[$i],strlen(substr($path2racephoto, strlen($home))))."\";\n";
		$j++;
	}
		echo "
</SCRIPT>
<p align='center'><a href='javascript:void(0);' onClick=\"return false;\" onMouseOver=\"nextimg();\">다음 사진</a>\n";
		echo "<br><img name=racephoto src='http://www.bundangmarathon.com$filesArray[0]' alt='".substr($filesArray[0],strlen(substr($path2racephoto, strlen($home))))."'>\n";
	}else if(count($filesArray) == 1){
		echo "<img src='$filesArray[0]' alt='".substr($filesArray[0],strlen(substr($path2racephoto, strlen($home))))."'>\n";
	}else{
		return(0);
	}
	return(1);
}

function GetDirContFiles($path,&$filesArray,$name)
{
 global $home;

//echo "path=$path ";

 $currentDir=openDir("$path");
 while($dirList = readDir($currentDir))
 {
/*
  if(($dirList!=".")&&($dirList!=".."))
  {
    $i=count(&$filesArray);
    $filesArray[$i] = $path."/".$dirList;
    $sPath =$filesArray[$i];

    if(is_dir($sPath))
    {
	GetDirContFiles($sPath,&$filesArray,$name);
    }
  }
*/
  if(($dirList!=".")&&($dirList!=".."))
  {
    $sPath = $path."/".$dirList;
    if($dirList == $name){
    	$i=count(&$filesArray);
	$filesArray[$i] = substr($sPath, strlen($home));
    }
    if(is_dir($sPath))
    {
	GetDirContFiles($sPath,&$filesArray,$name);
    }
  }
 }
}

?>
