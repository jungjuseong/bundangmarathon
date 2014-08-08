<?
$m_subject = "<a href=\"view_m.php?$href$sort&no=$data[no]\" $addShowComment rel='external'><span style='color:#000000;'>".$data[subject]."</span></a>";
$m_name = $name;

if($data['is_secret'] == 1) { $m_secret = '<span class="secret">ºñ¹Ð</span>';}
else{ $m_secret = '';}
$category_name = str_replace("&nbsp;","",$category_name);
if(trim($category_name) != "") { $m_category = '<span class=category>'.$category_name.'</span>';}
else {$m_category ="";}
$reg_date = substr($reg_date,-15);
?>
<li>
	<h3><? if($m_category || $m_secret){echo($m_category.$m_secret);}?><?=$reg_date?></h3>
	<h3><?=$m_subject?><?php echo($comment_num);?></h3>
</li>
