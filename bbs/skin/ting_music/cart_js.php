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
SetCookie("cchk","1");
db = GetCookie("mdb");
if ( db != '<?=$id?>' ){
SetCookie("mdb","<?=$id?>");
DelCookie("c_code");
DelCookie("c_mx");
}

function checkcart(dbf){
 var c_code=GetCookie("c_code"),check=0;
 if (c_code){
  c_code = c_code.split(",");
  for(j=0; j < c_code.length; j++){
   if ( c_code[j] == dbf ){return false;}
  }
 }
 return true;
}

function CartWindow(){
   window.open('<?=$dir?>/cart.php?id=<?=$id?>&mode=cart','tab_cart','scrollbars=no,resizable=no height=512 width=350 top=50 left=50');
}

function Cart(dbf){
 var temp='',chked=0,count=0,c_code=GetCookie("c_code"),c_mx=GetCookie("c_mx");
 if (!c_code){c_code='';}
 if (!c_mx){c_mx='';}
 form = document.forms["list"];
 if (dbf){
  if ( checkcart(dbf) ){
   c_code = c_code + dbf + ",";
   c_mx++
   if ( c_mx > 99 ){
    alert("담기는 99곡까지만 가능합니다.");
   }else{
    SetCookie("c_code",c_code);
    SetCookie("c_mx",c_mx);
    CartWindow();
   }
  }else{
   alert("이미 담겨져 있는 곡입니다.");
  }
 } else {
   var carted='',count2=0
   if (! form.cart ){
    alert("목록이 없습니다.");
   }else{
   if ( form.cart.length >= 0 )
   {
    for (i = 0; i < form.cart.length; i++ ){
     if( form.cart[i].checked == true){
      chked=1;
      count++
      temp = form.cart[i].value;
      if ( checkcart(temp) ){
       c_mx++;
       if ( c_mx > 99 ){
        alert("담기는 99곡까지만 가능합니다.");
        break;
       }else{
        c_code = c_code + temp + ",";
       }
      }else{
       count2++
       carted = carted + temp + ",";
      }
     }
    }
    if ( chked == "1"){
    SetCookie("c_code",c_code);
    SetCookie("c_mx",c_mx);
     if ( count != count2 ){
      if ( carted ){
       alert("게시물 번호 : "+carted+"은 이미 담겨져 있는 곡입니다.");
      }
      CartWindow();
     }else{
      alert("선택한 곡 모두 이미 담겨져 있는 곡입니다.");
     }
    }else{
     alert("선택해주세요");
    }
   }
   }
 }
}
</script>
