<HTML>
<HEAD>
<TITLE>나만의 앨범</TITLE>

</head>
<BODY background=images/cartbg.gif oncontextmenu="return false"  ondragstart="return false" onkeydown="return false" topmargin=0 leftmargin=19 marginwidth=0 marginheight=0 >
<link rel=StyleSheet HREF=styles.css type=text/css title=style>

<script>

function SetCookie( name, value, expire )
{
  var exp = new Date();
  var exptime = "99999999";

  if( expire == null )
    expire = 99999999;

  if( expire <= 0 )
  {
    if( expire < 0 )
      value = "";
    exptime = "";
  }
  else
  {
    exp.setTime( exp.getTime() + (1000 * expire) );
    exptime = "expires=" + exp.toGMTString() + ";";
  }

//  document.cookie = name + '=' + escape(value) + "; " + exptime;
//  document.cookie = name + '=' + value + "; " + exptime;
  document.cookie = name + '=' +value + "; path=/; " + exptime;
}
function DelCookie( name )
{
//  document.cookie = name + "=; expires=Thu, 01-Jan-70 00:00:01 GMT;";
  document.cookie = name + "=; path=/; expires=Thu, 01-Jan-70 00:00:01 GMT;";
}
function GetCookie( name )
{
  var cname = name + "=";
  var dc = document.cookie;
  if( dc.length > 0 )
  {
    begin = dc.indexOf( cname );
    if( begin >= 0 )
    {
      begin += cname.length;
      end = dc.indexOf( ";", begin );
      if( end == -1 )
        end = dc.length;
      return  unescape( dc.substring(begin, end) );
      return  dc.substring( begin, end );
    }
  }
  return  null;
}
</script>
<? if ($mode == "cart"){ ?>
<script>
 c_code = GetCookie("c_code");
 if (c_code){
  c_mx = GetCookie("c_mx");
  count = 0;
  document.write("<FORM NAME=music METHOD=post ACTION='cart.php'>");
  document.write("<input type=hidden name=id value=<?=$id?>>");
  document.write("<input type=hidden name=mode value=cart2>");
  document.write("<input type=hidden name=max value="+c_mx+">");
  document.write("<input type=hidden name=selected value="+c_code+">");
  document.write("</form>");
  music.submit();
 }else{
  check = GetCookie("cchk");
  if ( check ){
   alert("담겨진 곡이 없습니다.");
  } else {
   alert("쿠키를 생성할 수 없습니다. Internet Explorer 6이상 버전이라면 [인터넷 옵션]에 [개인 정보]를 [낮음]으로 설정해 주세요.");
  }
 window.close();
 }
</script>
<? } else { ?>
<script>
var c_code=GetCookie("c_code");
c_code = c_code.split(",");

function CookieDel(){
    DelCookie("c_code");
    DelCookie("c_mx");
    CartWindow();
}

function Open_Player(){
window.open('($path.main)?db=($par.db)&action=forward&dbf=0','tab_music','width=10,height=10,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0');
}

function songplay(dbf){
 var temp='',chked=0,upload='',count=0,dbfs='';
 form = document.forms["SelForm"];
 if (dbf){
   window.open('listen_all.php?id=<?=$id?>&selected='+dbf+',', 'yhkimdasommusicIT', 'scrollbars=no,resizable=no height=275 width=375 top=50 left=410');
 }else{
   if ( !form.selnum ){
    alert("목록이 없습니다.");
   }else{
    if (!form.selnum.length){
      if(form.selnum.checked == true){
        chked=1;
        count++;
        dbfs=form.selnum.value+",";
      }
    } else if ( form.selnum.length >= 0 )
    {
     for (i = 0; i < form.selnum.length; i++ ){
      if( form.selnum[i].checked == true){
       chked=1;
       count++;
       temp = form.selnum[i].value;
       dbfs = dbfs + temp + ",";
      }
     }
    }
   }
     if ( chked == "1"){
      window.open('listen_all.php?id=<?=$id?>&selected='+dbfs, 'yhkimdasommusicIT', 'scrollbars=no,resizable=no height=215 width=375 top=50 left=410');
     } else {
	     alert("선택해주세요");
     }
 }
}

function Delcart(dbf){
	  form = document.forms["SelForm"];
    if (dbf){
        cc = form.elements["c"+dbf].value;
        document.all["l"+cc].innerHTML="";

    }else{
        var chked,temp2='';
        if (! form.selnum ){
            alert("목록이 없습니다.");
        }else{
        if (!form.selnum.length) {
            if(form.selnum.checked == true){
                chked=1;
                temp=form.selnum.value;
                document.all["l"+temp].innerHTML=="";
            }
        }else if ( form.selnum.length >= 0 )
        {
            for (i = 0; i < form.selnum.length; i++ ){
                if( form.selnum[i].checked == true){
                    chked=1;
                    temp = form.selnum[i].value;
                    temp2 = temp2 + form.elements["c"+temp].value + ",";
                }
            }
        }
            if ( chked == "1"){
                temp2 = temp2.split(",");
                for (i=0; i < temp2.length-1;i++){
                    document.all["l"+temp2[i]].innerHTML="";
                }
            }else{
                alert("선택해주세요");
            }
        }
    }
}

function Up(dbf){
    form = document.forms["SelForm"];
    og = form.elements["c"+dbf].value;
    for (i=0;i<c_code.length-1;i++){
        if ( form.elements["chk"+c_code[i]] ){
            form.elements["chk"+c_code[i]].value = ""
        }
    }
    form.elements["chk"+dbf].value="chk";
    tg = Number(og) - 1;
    if ( tg != 0 ){
        for (i = 0; i < form.length; i++ ){
            if ( form[i].value == "chk" ){
                tbd = form[ i - 1 ].value;
            }
        }
        tgv = Gettgv("up");
        if ( tgv ){
            document.all["l"+tg].innerHTML = document.all["l"+og].innerHTML;
            document.all["l"+og].innerHTML = tgv;
            form.elements["c"+dbf].value = tg;
            form.elements["c"+tbd].value=og;
        }
    }
}

function Down(dbf){
    form = document.forms["SelForm"];
    og = form.elements["c"+dbf].value;
    for (i=0;i<c_code.length-1;i++){
        if ( form.elements["chk"+c_code[i]] ){
            form.elements["chk"+c_code[i]].value = ""
        }
    }
    form.elements["chk"+dbf].value="chk";
    tg = Number(og) + 1;
    for (i = 0; i < form.length; i++ ){
        if ( form[i].value == "chk" ){
            if ( form[ i + 7 ] ){
                tbd = form[ i + 7 ].value;
            }else{
                tbd = "";
            }
        }
    }
    if ( tbd ){
        tgv = Gettgv("down");
        if ( tgv ){
            document.all["l"+tg].innerHTML = document.all["l"+og].innerHTML;
            document.all["l"+og].innerHTML = tgv;
            form.elements["c"+dbf].value = tg;
            form.elements["c"+tbd].value=og;
        }
    }
}

function Gettgv(mode){
    tgv = document.all["l"+tg].innerHTML;
    if ( !tgv ){
        if ( mode == "up"){
            tg = Number(tg) - 1;
            if ( tg == 0 ){
                return false;
            }else{
                if ( document.all["l"+tg].innerHTML ){
                    return document.all["l"+tg].innerHTML;
                }else{
                    return Gettgv("up");
                }
            }
        }else{
            tg = Number(tg) + 1;
            if ( tg == 0 ){
                return false;
            }else{
                if ( document.all["l"+tg].innerHTML ){
                    return document.all["l"+tg].innerHTML;
                }else{
                    return Gettgv("down");
                }
            }
         }
    }
    return tgv;
}

function Cart(){
    var temp='',chked=0,upload='',count=0,c_code='',c_mx='0';
    form = document.forms["SelForm"];
    var carted='',count2=0
    if (! form.selnum ){
        CookieDel();
    }else{
        if ( form.selnum.length >= 0 )
        {
	        for (i = 0; i < form.selnum.length; i++ ){
	            chked=1;
	            count++
	            temp = form.selnum[i].value;
	            c_mx++;
	            c_code = c_code + temp + ",";
	        }
            SetCookie("c_code",c_code);
            SetCookie("c_mx",c_mx);
        }
    }
    CartWindow();
}

function CartWindow(){
   window.open('cart.php?id=<?=$id?>&mode=cart','tab_cart','scrollbars=no,resizable=no height=512 width=350 top=50 left=50');
}

function SelectAll()
{
  var   i, form = document.forms["SelForm"].selnum;

  if( !form ) return;
  if( form.length >= 0 )
  {
    for( i = 0; i < form.length; i++ )
    {
      if( form[i].type != "checkbox" ) continue;
      form[i].checked = !form[i].checked;
    }
  }
  else
    form.checked = !form.checked;
}

</script>

<table  border="0" cellpadding="0" cellspacing="0" width=100% class=mt>
    <tr>
        <td align="center" valign="top">

            <table border="0" cellpadding="0" cellspacing="0" width="100%">

<FORM NAME=SelForm>

                <tr>
                    <td height="22" align="center" nowrap>

                            <tr>
                                <td class=bg2>
                                    <p>&nbsp;&nbsp;&nbsp;<A onfocus=blur() HREF='JavaScript:SelectAll();'><img src=images/all.gif border=0 ></a><a onfocus=blur() href='javascript:songplay();'><img src=images/song.gif border=0></a><a onfocus=blur() href=javascript:Delcart();><img src=images/del.gif border=0></a><a onfocus=blur() href='javascript:Cart();'><img src=images/save.gif border=0></a><a onfocus=blur() href=javascript:CartWindow();><img src=images/back.gif border=0></a></p>
                                </td>
                            </tr>

                    </td>

                <tr>
                    <td align="center" nowrap>
<DIV ID=s1 STYLE='width:311; height:436; overflow:auto; margin-left:1px; margin-right:19px;'>
<?
require "./dbconn.php";
$connect=mysql_connect($host_name,$user_name,$db_password);
mysql_select_db($db_name, $connect);
$checked_song=explode(",",$selected);
$array_cnt=count($checked_song);
$count=1;
for($i=0;$i<$array_cnt-1;$i++)
{
$temp=mysql_fetch_array(mysql_query("select subject, name, sitelink1, sitelink2, file_name1, file_name2, memo from zetyx_board_$id where no='$checked_song[$i]'", $connect));
$subject[$i]=stripslashes($temp[subject]);
?>
<span id='l<?=$count?>'><table border=0 cellpadding=0 cellspacing=0 width=100%><tr class=bg1><td width=40 nowrap><input type=hidden name='chk<?=$checked_song[$i]?>' value=''><input type=hidden name='c<?=$checked_song[$i]?>' value='<?=$count?>'><input type=hidden name='f<?=$checked_song[$i]?>' value=''><input type=checkbox name='selnum' value='<?=$checked_song[$i]?>'><a href=javascript:Up("<?=$checked_song[$i]?>");>↑</a><a href=javascript:Down("<?=$checked_song[$i]?>");>↓</a></td><td title='<?=$subject[$i]?>'><a href='javascript:songplay("<?=$checked_song[$i]?>");'><?=$subject[$i]?></a></td><td width=13><a href=javascript:Delcart("<?=$checked_song[$i]?>");>X</a></td></tr><tr><td colspan=3 background=images/dot.gif></td></tr></table></span>
<?
$count++;
}
mysql_close($connect);

?>
                </td>

            </tr>
                <tr>

                    </td>
                </tr>

                <tr>

                                    </td>
                </tr>
                </form>
            </table>

        </td>
    </tr>
</table>
<script>
window.focus();
</script>
<? }?>
<div style='position:absolute;left:110px; top:484px;'>
<a onfocus=blur() href="http://tnb.na.fm" target="_blank"><img src=images/by.gif border=0>
</div>
</body>
</html>
