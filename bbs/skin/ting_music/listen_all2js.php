<script language="javascript">

function changeBox(cbox) { 
box = eval(cbox); 
box.checked = !box.checked; 
} 

function changeall() //checkbox를 두어 모두선택/모두취소 하는 버튼
{
 var obj=document.list.cart
   if (document.list.changebox.checked==true)
     {
      for(var i=0; i<obj.length; i++)
        {
        if( obj[i].disabled == true ) continue;
         obj[i].checked=true;
        }
     }
   else
     {
      for(var i=0; i<obj.length; i++)
        {
         obj[i].checked=false;
        }
     }
}

function changeall2() //checkbox를 두어 모두선택/모두취소 하는 버튼
{
 var obj=document.list.mvcart
   if (document.list.mvchangebox.checked==true)
     {
      for(var i=0; i<obj.length; i++)
        {
        if( obj[i].disabled == true ) continue;
         obj[i].checked=true;
        }
     }
   else
     {
      for(var i=0; i<obj.length; i++)
        {
         obj[i].checked=false;
        }
     }
}


 function listen_all() {
  var i, chked=0;
    for(i=0;i<document.list.length;i++)
  {
   if(document.list[i].type=='checkbox')
   {
    if(document.list[i].name=='cart')
      {
    if(document.list[i].checked) chked=1;
    }
   }
   }
  if(chked)
  {
    document.list.selected.value='';
    document.list.exec.value='dasom';
    for(i=0;i<document.list.length;i++)
    {
     if(document.list[i].type=='checkbox')
     {
     if(document.list[i].name=='cart')
      {
      if(document.list[i].checked)
      {
       document.list.selected.value = document.list[i].value+','+document.list.selected.value;
       }
      }
     }
    }
 music=dasommusicIT('listen_all.php?id='+musicid+'&selected='+document.list.selected.value, 10, 10, null, null, 'music');
  }
  else {alert('음악을 선택해 주세요');}
 }

 function listen_all2() {
  var i, chked=0;
    for(i=0;i<document.list.length;i++)
  {
   if(document.list[i].type=='checkbox')
   {
    if(document.list[i].name=='mvcart')
      {
    if(document.list[i].checked) chked=1;
    }
   }
   }
  if(chked)
  {
    document.list.selected.value='';
    document.list.exec.value='dasom';
    for(i=0;i<document.list.length;i++)
    {
     if(document.list[i].type=='checkbox')
     {
     if(document.list[i].name=='mvcart')
      {
      if(document.list[i].checked)
      {
       document.list.selected.value = document.list[i].value+','+document.list.selected.value;
       }
      }
     }
    }
 music=dasommusicIT('listen_all2.php?id='+musicid+'&selected='+document.list.selected.value, 360, 450, null, null, 'music');
  }
  else {alert('음악을 선택해 주세요');}
 }

</script>

