<?
$alert_msg = $skin_setup['grant_mrbt_guide'];
$alert_msg = str_replace("<br>","\\n",$alert_msg);

if($data[ismember]==$member[no] || ($member[no] && $member[level] <= $skin_setup[mrbt_passLevel]) ||($member[no] && $member[is_admin] < 3)) $limit_menu="";
else $limit_menu="ondragstart=\"return false\" oncontextmenu=\"return copyrightAlert()\"";

if($limit_menu) $memo = preg_replace("/(\<img)(.*)(\>?)/i","\\1 $limit_menu \\2 \\3", $memo);
?>

<script>var copyrightAlertMsg = "<?=$alert_msg?>";</script>
