<script language="javascript">

function changeBox(cbox) {
box = eval(cbox);
box.checked = !box.checked;
}

function changeall() //checkbox�� �ξ� ��μ���/������ �ϴ� ��ư
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

function changeall2() //checkbox�� �ξ� ��μ���/������ �ϴ� ��ư
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
 window.open('<?=$dir?>/listen_all.php?id=<?=$id?>&selected='+document.list.selected.value, 'yhkimdasommusicIT', 'scrollbars=no,resizable=no height=215 width=375 top=50 left=50');
  }
  else {alert('������ ������ �ּ���');}
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
 music=dasommusicIT('<?=$dir?>/listen_all2.php?id=<?=$id?>&selected='+document.list.selected.value, 360, 450, null, null, 'music');
  }
  else {alert('������ ������ �ּ���');}
 }

</script>

