<?
function MakeImg($Num,$FileName)
{
include("gdnumfont.inc");

$MStart=explode(" ",microtime());
$im = @imagecreate (96, 50);
  
$background_color = imagecolorallocate ($im, 255, 255, 255);
$text_color = imagecolorallocate ($im, 4,5,4);
$x2=$x=10;
$y=10;
for ($n=0;$n<4;$n++)
{
switch ($Num[$n])
{
	case (0):
	for ($i=0;$i<$CNum0*2;$i=$i+2)
	{
	ImageSetPixel($im,$FNum0[$i]+$x,50-($FNum0[$i+1]+$y),$text_color);
	if ($i%17==0)
	$x=$x+rand()%3-1;
	}
	break;
	case (1):
	for ($i=0;$i<$CNum1*2;$i=$i+2)
	{
	ImageSetPixel($im,$FNum1[$i]+$x,50-($FNum1[$i+1]+$y),$text_color);
	if ($i%17==0)
	$x=$x+rand()%3-1;
	}
	break;
	case (2):
	{
	for ($i=0;$i<$CNum2*2;$i=$i+2)
	ImageSetPixel($im,$FNum2[$i]+$x,50-($FNum2[$i+1]+$y),$text_color);
	if ($i%17==0)
	$x=$x+rand()%3-1;	
	}
	break;
	case (3):
	for ($i=0;$i<$CNum3*2;$i=$i+2)
	{
	ImageSetPixel($im,$FNum3[$i]+$x,50-($FNum3[$i+1]+$y),$text_color);
	if ($i%17==0)
	$x=$x+rand()%3-1;
	}
	break;
	case (4):
	for ($i=0;$i<$CNum4*2;$i=$i+2)
	{
	ImageSetPixel($im,$FNum4[$i]+$x,50-($FNum4[$i+1]+$y),$text_color);
	if ($i%17==0)
	$x=$x+rand()%3-1;
	}
	break;
	case (5):
	for ($i=0;$i<$CNum5*2;$i=$i+2)
	{
	ImageSetPixel($im,$FNum5[$i]+$x,50-($FNum5[$i+1]+$y),$text_color);
	if ($i%17==0)
	$x=$x+rand()%3-1;
	}
	break;
	case (6):
	for ($i=0;$i<$CNum6*2;$i=$i+2)
	{
	ImageSetPixel($im,$FNum6[$i]+$x,50-($FNum6[$i+1]+$y),$text_color);
	if ($i%17==0)
	$x=$x+rand()%3-1;
	}
	break;
	case (7):
	for ($i=0;$i<$CNum7*2;$i=$i+2)
	{
	ImageSetPixel($im,$FNum7[$i]+$x,50-($FNum7[$i+1]+$y),$text_color);
	if ($i%17==0)
	$x=$x+rand()%3-1;
	}
	break;
	case (8):
	for ($i=0;$i<$CNum8*2;$i=$i+2)
	{
	ImageSetPixel($im,$FNum8[$i]+$x,50-($FNum8[$i+1]+$y),$text_color);
	if ($i%17==0)
	$x=$x+rand()%3-1;
	}
	break;
	case (9):
	for ($i=0;$i<$CNum9*2;$i=$i+2)
	{
	ImageSetPixel($im,$FNum9[$i]+$x,50-($FNum9[$i+1]+$y),$text_color);
	if ($i%17==0)
	$x=$x+rand()%3-1;
	}
	break;
}
$x2=$x2+rand()%3+17;
$y=$y+rand()%4-2;
$x=$x2;
}

for ($i=0;$i<800;$i++)
{
ImageSetPixel($im,rand()%96,rand()%50,$text_color);

}


imagepng ($im,$FileName);
imageDestroy($im);
}
$MEnd=explode(" ",microtime());
echo("<!--$MEnd[0]-$MStart[0]---!>");
?>
