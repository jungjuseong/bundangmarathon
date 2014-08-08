<?
$MStart=explode(" ",microtime());
//Ip 블럭에 관한 설정 항목
$deltaReleaseTime=120;		 	//블럭 리스트에서 아이피 제거를 실행하는 주기
$deltaIpReleaseTime=40; 		//아이피를 블럭시키는 시간
$deltaCountCheckTime=5*60;		//카운터를 0으로 갱신시키는 주기 
$deltaMaxCount=1000;			//카운터 주기동안 받아들일수있는 최대양 
$deltaReleaseBlockTime=10*60;		// 블럭감시 장치 해제 시간
$deltaMaxLoadPage=100; 			//블럭감시중 허용되는 최대 페이지 로딩수 
$REMOTE_ADDR=$HTTP_SERVER_VARS[REMOTE_ADDR];
$UniqId=$HTTP_POST_VARS[UniqId];
$FileName=$HTTP_POST_VARS[FileName];
$InputPass=$HTTP_POST_VARS[InputPass];
?>

<?
IpTest(); //Dos공격 방지용 언제나 앞에 있어야한다.
?>

<?
//$EMail에 이메일값을 대입하십시오'
	require("./bmauth.php");
	require("./bmconfig.php");

	$dbquery="select email from member where userid='$UniqId'";
//echo "dbquery=$dbquery ";
	$result = mysql_query($dbquery) or die("mysql_query error");
	if($row=mysql_fetch_array($result)){
		$EMail = $row[0];
	}
?>
<html>
<head>
<title>이메일 주소 확인</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<style type="text/css">
td, body, input, select {font-size:9pt;color:#666666;font-family:굴림,verdana,arial;line-height:17px}
form {margin:0px}
.s {font-size:10px;font-family:verdana;line-height:12px;letter-spacing: -1px;}
a:link {COLOR:#0033CC;text-decoration:none;}
</style>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="180" border="0" cellspacing="2" cellpadding="0" bgcolor="#3988D1">
  <tr>
    <td bgcolor="#FFFFFF">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td background="antispam/bg_blue.gif" align="center" height="25"> <b><font color="#FFFFFF">이메일 주소 확인</font></b></td>
        </tr>
        <tr> 
          <td height="30"></td>
        </tr>
            <tr> 
          <td background="./antispam/form_bg.gif" height="90" align=center> 
          <table width="85%" border="0" cellspacing="0" cellpadding="4"><tr>
	<td align="center">
	<?Start()?><a href='#'>          
       <img src="./antispam/btn2.gif" hspace='7' onclick='window.close()' border='0' width="39" height="18"></a></td>
        </tr>
        <tr>
          <td align='right' height='22' valign='bottom'>[스팸 예방 정책]&nbsp;</td>
        </tr>
        <tr> 
          <td align='center' bgcolor=#DFDFDF height='1'> 
          </td>
        </tr>
        <tr>
          <td height="2"></td>
        </tr>
        <tr> 
          <td align="center"><a href='http://www.neverspam.or.kr' target=_blank><img src='antispam/logo.gif' width='113' height='33' border='0'></a></td>
        </tr>
        <tr>
          <td height="3"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>

<?

function Start()
{
 global $InputPass;
 global $EMail;
 global $FileName;
 global $UniqId;
 $str="./antispambmp/".$FileName;
 if (!file_exists($str))
 {
 echo("입력시간이 지났습니다</tr>
            </table>
          </td>
        </tr>
        <tr> 
          <td  height='53' align='center'>"); 	
return;
 }
 	
 $im=fopen($str,"r");
 $PassCode=fread($im,4);
 $Temp=explode('_',fread($im,filesize($str)-6));
 $PassCode=$Temp[0];
 $UId=$Temp[1];
 fclose($im);
 if (strcmp($PassCode,$InputPass)!=0 || strcmp($UId,$UniqId)!=0) 
 {
 echo("잘못 입력하셨습니다
 	</tr>
            </table>
          </td>
        </tr>
        <tr> 
          <td  height='53' align='center'><a href='#'><img onclick='window.history.go(-1)' src='./antispam/btn_back.gif' hspace='7' border='0'></a>
	");
return;
 }
echo("문의하신 이메일은<br>
<a style='word-break:break-all;width:150' href='mailto:${EMail}'>$EMail</a><br>
       입니다.</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr> 
          <td  height='53' align='center'>");
}

?>

<?

function IpTest()
{
 	global $REMOTE_ADDR;
 	global $MStart;
 	global $deltaReleaseTime;
 	global $deltaIpReleaseTime;
 	$im=fopen("./antispam/releasetime.txt","rb");
 	$RTime=fread($im,10);
 	fclose($im);
 	
 	if (time()-$RTime>$deltaReleaseTime)  //블럭된 ip를 체크하여 시간이 만료한 ip는 해제시켜준다.
 	{
 	BlockIpRelease();
 	$im=fopen("./antispam/releasetime.txt","w");
 	fwrite($im,time());
 	fclose($im);
	}
	
 	$im=fopen("./antispam/blockiplist.txt","rb");
 	$Ip=fread($im,filesize("./antispam/blockiplist.txt"));
 	fclose($im);
 	$IpList=explode("_",$Ip);
 	for ($i=0;$i<sizeof($IpList);$i++)
 	{
 		if(strcmp($IpList[$i],$REMOTE_ADDR)==0)
 		{
 			echo("Dos 공격으로 의심되는바 ip를 블럭합니다<BR> $deltaIpReleaseTime ~ ");
 			echo($deltaIpReleaseTime+$deltaReleaseTime);
 			echo(' 초후 블럭은 해제됩니다.<BR>');
 			$MEnd=explode(" ",microtime());
			$MO=$MEnd[0]-$MStart[0];
			echo("로딩시간 : $MO");
 			exit();
 		}
 	}
 	
	BlockIf();

}


function BlockIpRelease()
{
	global $deltaIpReleaseTime;
	$im=fopen("./antispam/blockiplist.txt","r");
	$Ip=fread($im,filesize("./antispam/blockiplist.txt"));
	$IpList=explode("_",$Ip);
	fclose($im);
	$im=fopen("./antispam/blockiptime.txt","r");
	$Ip=fread($im,filesize("./antispam/blockiptime.txt"));
	$IpTime=explode("_",$Ip);
	fclose($im);
	$NowTime=time();
	$im=fopen("./antispam/blockiplist.txt","w");
	$im2=fopen("./antispam/blockiptime.txt","w");
	for ($i=0;$i<sizeof($IpList);$i++)
	{
		if($NowTime-$IpTime[$i]<$deltaIpReleaseTime)   //블럭 기간
		{
			
			fwrite($im,$IpList[$i]);
			fwrite($im,"_");
			fwrite($im2,$IpTime[$i]);
			fwrite($im2,"_");
		}
	}
	fclose($im);
	fclose($im2);
}

function BlockIf()
{
	global $deltaCountCheckTime;
	global $deltaMaxCount;
	$im=fopen("./antispam/count.txt","rb");
	$str=fread($im,filesize("./antispam/count.txt"));
	$Block=explode("_",$str);
	fclose($im);
	if ($Block[0]==1)
	BlockIpList();
	else
	{
		if (time()-$Block[2]>$deltaCountCheckTime)    //카운터를 0으로 갱신시키는 주기
		{
		$Block[1]=0;
		$Block[2]=time();
		}
		else
		{
		$Block[1]++;
		}
		if ($Block[1]>$deltaMaxCount)  //주기동안 받아들일수있는 최대양 
		{
		$Block[0]=1;
		$im2=fopen("./antispam/blocktime.txt","wb");
		fwrite($im2,$Block[2],10);
		fclose($im2);
		}
		$im=fopen("./antispam/count.txt","wb");
		fwrite($im,$Block[0]);
		fwrite($im,"_");
		fwrite($im,$Block[1]);
		fwrite($im,"_");
		fwrite($im,$Block[2]);
		fclose($im);
	}
}

function BlockIpList()
{
	global $REMOTE_ADDR;
	global $deltaReleaseBlockTime;
	global $deltaMaxLoadPage;
	$im=fopen("./antispam/blocktime.txt","rb");
	$OldTime=fread($im,10);
	fclose($im);
	if (time()-$OldTime>$deltaReleaseBlockTime)// 10분후 상황 해제
	{
	 $im=fopen("./antispam/count.txt","wb");
	 fwrite($im,"0",1);
	 fclose($im);
//	 unlink("./antispam/iplist.txt");
//	 unlink("./antispam/ipcount.txt");
	 $im=fopen("./antispam/iplist.txt","w");
	 fclose($im);
	 $im=fopen("./antispam/ipcount.txt","w");
	 fclose($im);
	}		
	else
	{
	 $im=fopen("./antispam/iplist.txt","r");//ip검색하고 추가한후 저장하기
	 $Ip=fread($im,filesize("./antispam/iplist.txt"));
	 $IpList=explode("_",$Ip);
	 fclose($im);
	 $im=fopen("./antispam/ipcount.txt","r");
	 $Ip=fread($im,filesize("./antispam/ipcount.txt"));
	 $IpCount=explode("_",$Ip);
	 fclose($im);
	 for($i=0;$i<sizeof($IpList);$i++)
	 {
	  if (strcmp($IpList[$i],$REMOTE_ADDR)==0)
	     {
	      
	       	$IpCount[$i]=$IpCount[$i]+1;
	       
	     	if ($IpCount[$i]>$deltaMaxLoadPage) //상황 진행중 ip블럭 기준이 되는 접속양 :50번
	     	{
	     	  
	     	   $IpCount[$i]=0;
	     	   $im=fopen("./antispam/blockiplist.txt","a");
	     	   
	     	   fwrite($im,$REMOTE_ADDR);
	     	   fwrite($im,"_");
	     	   fclose($im);
	     	   $im=fopen("./antispam/blockiptime.txt","a");
	     	  
	     	   fwrite($im,time());
	     	    fwrite($im,"_");
	     	   fclose($im);
	     	}
	       	$im=fopen("./antispam/ipcount.txt","w");
	     	
	     	
	     	for($t=0;$t<sizeof($IpCount);$t++)
	     	{
	     		
	     		fwrite($im,$IpCount[$t]);
	     		fwrite($im,"_");
	     		
	     	}
	     	fclose($im);
	    
	     	return;	     	
	     }
	     
	 }
	$im=fopen("./antispam/iplist.txt","a");
	
	fwrite($im,$REMOTE_ADDR);
	fwrite($im,"_");
	fclose($im);
	$im=fopen("./antispam/ipcount.txt","a");
	fwrite($im,"1_");
	fclose($im);
	}
}
?>