<form>
<br><br><br>
<table border=1 width=250>
<tr>
    <td align=center height=30>
      <br>
      <?echo $message;?>
      <br><br>
<?
  if(!$url)
  {
?>

  <br>
  <center><a href=# onclick=history.back() onfocus=blur()><img src="<?=$dir?>/btn_confirm.gif" border="0"></a>

<?
  }
  else
  {
?>

  <div align=center><a href=# onclick=location.href="<?echo $url;?>" onfocus=blur()><img src="<?=$dir?>/btn_confirm.gif" border="0"></a>

<?
  }
?>
   <br><br>
    </td>
</tr>
</form>
</table>
<br><br>
