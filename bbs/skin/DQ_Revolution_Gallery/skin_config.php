<?
// register_globals�� off�϶��� ���� ���� �� ����
	@extract($HTTP_GET_VARS); 
	@extract($HTTP_POST_VARS); 
	@extract($HTTP_SERVER_VARS); 
	@extract($HTTP_ENV_VARS);

// ���κ��� ���̺귯�� ������
	$_zb_path = realpath("../../")."/";
	include $_zb_path."lib.php";

// DB ���������� ȸ������ ������
	$connect = dbConn();
	$member  = member_info();

// �Խ��� ������ ������
	$setup=get_table_attrib($id);
	if(!$setup[no]) error("�������� �ʴ� �Խ��� �Դϴ�.","window.close");

// ȸ������ �˻�
	if(!$member[no]) Error("�����ڸ� ���� �����մϴ�.","window.close");

// ���������� �ִ��� �˻�
	if($member[is_admin]>=3&&!$member[board_name]) Error("�����ڸ� ���� �����մϴ�.","window.close");
	elseif($member[is_admin]>=3&&!check_board_master($member,$setup[no])) error("�����ڸ� ���� �����մϴ�.","window.close");

// ��Ų ȯ�漳�� �о��
	include "get_config.php";
	//$css = 'css/white/';

	$_put_css = "1";

// �˻�
	$_mbPic_config_file = $_SKIN_config_dir."member_picture_config_".$setup[group_no].".php";
	if(!file_exists($_mbPic_config_file)) {
		copy("skinconfig_mbpic_default.php",$_mbPic_config_file);
		chmod ($_mbPic_config_file, 0707);
		include $_mbPic_config_file;
	}
?>
<html>
<head>
<title>������� ȯ�漳��</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel=StyleSheet HREF=css/config.css type=text/css title=style>
</head>

<script language="JavaScript">
function go_convert() {
	ret = confirm("������� 0.93 ���� �������� �߰��ʵ带 �̿��Ͽ� ���ε��� DB�����Ϳ�\n\n��ȭ�� ��õ����� �̿��� ��õ �����͸� ��ȯ�ϴ� �۾��Դϴ�.\n\n��ȯ �������� �߻��� ������ ���ؼ� �����ڴ� ��ü�� å���� ���� �ʽ��ϴ�.\n\n�ݵ�� ��ü DB�� �̸� ������� �� �����Ͻñ� �ٶ��ϴ�.\n\n\n\n�� ������ �о����� ��ȯ �۾��� ��� �Ͻðڽ��ϱ�?");
	if(ret==1) document.location.href="<?=$PHP_SELF?>?id=<?=$id?>&mode=convert";

}

function onoff_chk(obj1, obj2) {
	if(obj1.checked) obj2.checked = '';
	if(obj1.checked) obj2.disabled = '1'; else obj2.disabled = '';
}

function showhide2(obj1, obj2) {
	obj2.style.display = (obj2.style.display == 'none')? '' : 'none';
	obj1.innerHTML = (obj2.style.display == 'none')? obj1.innerHTML.replace('-','+') : obj1.innerHTML.replace('+','-');
}

function showhide(obj1,obj2) {
	obj2.style.display = (!obj1.checked)? 'none': '';
}
</script>

<body style="margin:0;" class="info_bg">

<?
if($mode=="convert") include "include/convert.php";

if($mode=="modify") {

// ���� ��������
	$_inclib_01 = "./include/dq_thumb_engine2.";
	if(file_exists($_inclib_01.'php') && filesize($_inclib_01.'php')) include_once $_inclib_01.'php';
	else include_once $_inclib_01.'zend';

// ����ȯ�� �˾Ƴ� (OS�� exif���α׷� ����Ȯ���� ����, GD�� ����� ��������� ����)
	$server_os  = get_serverOS();
	$_gd_version = get_gdVersion(1);
	$gd_version = get_gdVersion();

// ��Ų ���� ��������
	include 'skin_version.php';

// �÷����� �˻�
	if(file_exists("plug-ins/pgallery_header.php")) $plug_PG = 1;
	if(file_exists("plug-ins/mrbt_limit.php")) $plug_ML = 1;
	if(file_exists("plug-ins/exif_info.php")) {
		if(eregi('win',$server_os)) $exif_run_file = $_LIBS_include_dir.'exiflist.exe';
		else $exif_run_file = $_LIBS_include_dir.'exiflist';
		if(file_exists($exif_run_file) && eregi('win',$server_os)) $plug_EX = 1;
		elseif(file_exists($exif_run_file) && is_executable($exif_run_file)) $plug_EX = 1;
	}
	if(file_exists($_LIBS_include_dir."slide_view.php")) $plug_SV = 1;
	if(file_exists($_LIBS_include_dir."vote_ex_run.php")) $plug_VE = 1;

	if($gd_version != 2) $skin_setup[using_usm] = '';

// PHP ������ ���� ����
	$_phpversion = substr(phpversion(),0,5);
	if($_phpversion >= '4.2.0') $_auto_resize = 1;

// ����
	$tabshow = 'none';
?>
	<IFRAME name=get_css scrolling=no frameborder=0 width=0 height=0 src="get_cssconfig.php?id=<?=$skin_setup[css_dir]?>&mode=css"></IFRAME>
	<table width="100%" height="100%"  border="0" cellpadding="5" cellspacing="0" class=info_bg>
	  <form action="<?=$PHP_SELF."?id=$id&mode=write&pos=$pos"?>" onSubmit="javascript:getScroll_pos()" method="post" enctype="multipart/form-data" name="config" id="config">
	  <input type=hidden name=pos id=pos value=<?=$pos?>>
	  <input type=hidden name=gd_version id=gd_version value=<?=$gd_version?>>
	  <tr>
		<td valign="top" class="info_bg" style="padding:5px;">
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td height=35 class="line2" style="font-size:13pt;font-weight:bold;">&nbsp;&nbsp;��/��/��/��/ ȯ�漳�� ver 1.3</td>
		  </tr>
		  <tr>
		    <td class=line2 style="padding:5px">
			  <table width="100%"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="18" width="100" align="right" class="line2"><b>����OS</b></td>
                <td>:
                    <?=$server_os?></td>
              </tr>
              <tr>
                <td height="18" width="100" align="right" class="line2"><b>PHP����</b></td>
                <td>: <?=phpversion()?></td>
              </tr>
              <tr>
                <td height="18" align="right" valign="top"><b>GD����</b></td>
                <td>:
                    <?if($_gd_version) echo $_gd_version; else echo "<font class=han2>������ GD���̺귯���� ��ġ�Ǿ� ���� �ʽ��ϴ�. ������� �������� �ʰ� ������ �����ݴϴ�.</font><br>&nbsp;&nbsp;������ ����� ��� ����� ����Ƽ�� ���� ������ Ʈ���� ������ ������� �ֽ��ϴ�."?>
					<?if(get_gdVersion()<2) echo "&nbsp;&nbsp;GD 1.x ������ ����� ����Ƽ�� ���� �ʽ��ϴ�. ����Ͽ��� ���̴� ��������� �����Դϴ�."?>
				</td>
              </tr>
              <tr>
                <td height="18" align="right"><b>��Ų����</b></td>
                <td>:
                    <?=$skin_version?></td>
              </tr>
              <tr>
                <td height="5" align="right"></td>
                <td></td>
              </tr>
            </table></td>
		  </tr>
		  <tr>
			<td align="right" class="han2" style="padding:10px;">
		    <a href="http://www.dqstyle.com/revolution/register.php" target="_blank"><b>-����� ��� </b></a>&nbsp;&nbsp;<a href="http://www.dqstyle.com/revolution/version_chk_bbs.php?version=<?=$skin_version?>" target="_blank"><b>-������Ʈ �˻�</b></a>&nbsp;&nbsp; <a href="javascript:go_convert()"><b>-���ε嵥���� ��ȯ</b></a>&nbsp;&nbsp;			</td>
		  </tr>
		  <tr><td class="lined" style="height:1px"><img src="t.gif" height="1"></td></tr>
		  <tr>
		    <td class="han2" style="padding:10 5 10 5">
			  <table width="100%"  border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed">
              <tr>
                <td width="100" align="left" valign="top"><b>�⺻����</b></td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <div  onClick="showhide2(this,gen)" style="cursor:pointer;padding:0 0 5 10;">+ CSS�׸�, ����, �������� ������ ���� �������� ��ɰ� ���õ� ������</div>
				  <div id='gen' style='display:<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                  <col width="10" style="padding-top:0px">
                  <col width="150" style="padding-top:4px;">
                  <col width="">
                  <tr>
                    <td>&nbsp;</td>
                    <td>��Ÿ�Ͻ�Ʈ(CSS) ���� </td>
                    <td><input type=hidden name=css_sel id=css_sel value="">
                        <SCRIPT LANGUAGE="JavaScript">
				<!--
				function chk_css (obj) {
					<?include $skin_setup['css_dir']."css_info.php";?>
					var myindex=obj.selectedIndex;
					get_css.location="get_cssconfig.php?id="+obj.options[myindex].value+"&mode=css";
				}
				//-->
			      </SCRIPT>
                        <select name=css_dir onChange=chk_css(this)>
                          <?
	 $css_dir="./css/";
	 $handle=opendir($css_dir);
	 while ($css_info = readdir($handle)) {
	   if(!ereg("\.",$css_info)) {
		 $css_info = "css/".$css_info."/";
		 if($css_info==$skin_setup[css_dir]) $select="selected"; else $select="";
		 include $css_info."css_info.php";
		 echo "<option value=$css_info $select>$css_name</option>";
	   }
	 }
	 closedir($handle);
	?>
                        </select>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>���� ���� </td>
                    <td><input type=hidden name=lang_sel id=lang_sel value="">
                        <select name=language_dir>
                          <?
	 $lang_dir="./language/";
	 $handle=opendir($lang_dir);
	 while ($lang_info = readdir($handle)) {
	   if(!ereg("\.",$lang_info)) {
		 $lang_info = "language/".$lang_info."/";
		 if($lang_info==$skin_setup[language_dir]) $select="selected"; else $select="";
		 include $lang_info."lang_info.php";
		 echo "<option value=$lang_info $select>$lang_name</option>";
	   }
	 }
	 closedir($handle);
	?>
                      </select></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>���� �������� </td>
                    <td><select name=copy_file id="copy_file">
                        <option value="">�������� ����</option>
                        <?
	 $handle=opendir($_SKIN_config_dir);
	 while ($cfg_file = readdir($handle)) {
	   if(substr($cfg_file,0,4)=="cfg_" && $cfg_file!="cfg_$id".".php") {
		 $cfg_file_id = substr($cfg_file,4,strlen($cfg_file)-8);

		 $ftmp = file($_SKIN_config_dir.$cfg_file);
		 $is_linkCfg = false;
		 for($i=0; $i<=count($ftmp); $i++) {
			 if(eregi("cfg_linkFile",$ftmp[$i])) {
				 $is_linkCfg = true;
				 break;
			 }
		 }

		 if(!$is_linkCfg) {
			 if($cfg_file==$cfg_linkFile) {
				 $select=" selected";
				 $cfg_linkCheck = true;
			 } else $select="";
			 echo "<option value=$cfg_file $select>$cfg_file_id</option>";
		 }
	   }
	 }
	 closedir($handle);
	?>
                      </select>
      �� �������� &nbsp;&nbsp;<input type="radio" name="cfg_link" value="1"<?if($cfg_linkCheck) echo " checked"?>>
      �����ϱ� &nbsp;&nbsp;<input type="radio" name="cfg_link" value="2"<?if(!$cfg_linkCheck) echo " checked"?>>��������</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                        <input name="save_as" type="checkbox" id="save_as" value="1" onClick=showhide(this,show_save)>
      �ٸ��̸����� ���� <span name="show_save" id="show_save" style="display:none">
      <input name="save_file" type="text" class="input" id="save_file" size="20" maxlength="40">
      <input name="submit4" type="submit" class="submit" value="����" style="width:50px;">
    </span> </td>
                  </tr>
                  <tr>
                    <td>&nbsp;&nbsp;*</td>
                    <td>�Խ��� ���� ���� </td>
                    <td><input name="board_bgColor" type="text" class="input" id="board_bgColor" value="<?=$setup[bg_color]?>" size="20" maxlength="20">
      ���� CSS�� ��︮�� ���� : <font id=match_css class=han2><?
					  include $skin_setup['css_dir']."css_info.php";
					  echo "$match_bgColor";
					?></font>&nbsp;&nbsp<span style="cursor:pointer;" onClick="board_bgColor.value=match_css.innerHTML">[�ٲٱ�]</span> </td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="using_pGallery" value="1"<?if(!$plug_PG) echo " disabled"?><?if($skin_setup[using_pGallery]) echo " checked"?>></td>
                    <td colspan="2">���ΰ�����
                        ���<?if(!$plug_PG) echo " <font class=han2>(�÷������� ��ġ���� ����)</font>"?></td>
                  </tr>
<!--
                  <tr>
                    <td><input name="using_slideshow" type="checkbox" id="using_slideshow" value="1"<?if(!$plug_SV) echo" disabled"?><?if($skin_setup[using_slideshow]) echo " checked"?>></td>
                    <td>���ۻ����� �����̵� ��� </td>
                    <td><select name="using_slideshow2"<?if(!$skin_setup[using_slideshow]) echo" disabled"?>>
                        <option value="random"<?if($skin_setup[using_slideshow2]=="random") echo " selected"?>>����</option>
                        <option value="fadeInOut"<?if($skin_setup[using_slideshow2]=="fadeInOut") echo " selected"?>>���̵��� - �ƿ�</option>
                        <option value="bwChange"<?if($skin_setup[using_slideshow2]=="bwChange") echo " selected"?>>��鿡�� �÷��� ��ȯ</option>
                        <option value="hCross"<?if($skin_setup[using_slideshow2]=="hCross") echo " selected"?>>���ι��� ��ħ</option>
                        <option value="vCross"<?if($skin_setup[using_slideshow2]=="vCross") echo " selected"?>>���ι��� ��ħ</option>
                        <option value="crossFading"<?if($skin_setup[using_slideshow2]=="crossFading") echo " selected"?>>ũ�ν����̵�</option>
                      </select>
                        <?if(!$plug_SV) echo " <font class=han2>(�÷������� ��ġ���� ����)</font>"?></td>
                  </tr>
-->
                  <tr>
                    <td><input type="checkbox" name="using_memberPicture" value="1"<?if($skin_setup[using_memberPicture]) echo " checked"?>></td>
                    <td>ȸ������ ��� </td>
                    <td>*ȸ������ ũ�� - ���ι���:
                      <input name="member_picture_x" type="text" class="input" id="member_picture_x" value="<?=$skin_setup[member_picture_x]?>" size="5" maxlength="5">
�ȼ�, ���ι���:
<input name="member_picture_y" type="text" class="input" id="member_picture_y" value="<?=$skin_setup[member_picture_y]?>" size="5" maxlength="5">
�ȼ� </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="���� ����" style="width:100px;">&nbsp;&nbsp;<input name="cancel52" type="button" class="button" value="���(�ݱ�)" style="width:100px;" onClick="window.close()">&nbsp;&nbsp;&nbsp;</td>
                </table>
				  </span></td>
              </tr>
            </table></td>
		  </tr>

		  
		  <tr><td class="lined" style="height:1px"><img src="t.gif" height="1"></td></tr>
		  <tr>
		    <td class="han2" style="padding:10 5 10 5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <col width=100>
              <col>
              <tr>
                <td width="100" align="left" valign="top"><b>����� ���</b></td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <div  onClick="showhide2(this,thumbnail)" style="cursor:pointer;padding:0 0 10 10;">+ ����� ������ ���õ� ����</div>
				  <div id=thumbnail style='display:<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                    <col width="10" style="padding-top:0px">
                    <col width="150" style="padding-top:4px;">
                    <col width="">
                    <tr>
                      <td><input name="using_urlImg" type="checkbox" id="using_urlImg" value="1"<?if($skin_setup[using_urlImg]) echo " checked"?>></td>
                      <td colspan="2">�ܺθ�ũ���� ����� ���� (HTML �±׸� �м��Ͽ� ������� ����) </td>
                      </tr>
                      <td>&nbsp;</td>
                      <td>���ι��� ����</td>
                      <td><input name="thumb_hcount" type="text" class="input" id="thumb_hcount" value="<?=$skin_setup[thumb_hcount]?>" size="2" maxlength="2">
                        ��</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>���ι��� ���� </td>
                      <td><input name="thumb_vcount" type="text" class="input" id="thumb_vcount" value="<?=$skin_setup[thumb_vcount]?>" size="2" maxlength="2">
                        ��</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>X�� �ִ� ũ��</td>
                      <td><input name="thumb_imagex" type="text" class="input" value="<?=$skin_setup[thumb_imagex]?>" size="4" maxlength="4">
                        �ȼ�</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Y�� �ִ� ũ��</td>
                      <td><input name="thumb_imagey" type="text" class="input" value="<?=$skin_setup[thumb_imagey]?>" size="4" maxlength="4">
                        �ȼ�</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>���� ����</td>
                      <td><input type="radio" name="thumb_align" value="left"<?if($skin_setup[thumb_align]=="left") echo " checked"?>>
                        ����
                          <input type="radio" name="thumb_align" value="center"<?if($skin_setup[thumb_align]=="center") echo " checked"?>>
                          ���
                          <input type="radio" name="thumb_align" value="right"<?if($skin_setup[thumb_align]=="right") echo " checked"?>>
                          ������ </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>���� ���� </td>
                      <td><input type="radio" name="thumb_valign" value="top"<?if($skin_setup[thumb_valign]=="top") echo " checked"?>>
                        ��
                          <input type="radio" name="thumb_valign" value="middle"<?if($skin_setup[thumb_valign]=="middle") echo " checked"?>>
                          ���
                          <input type="radio" name="thumb_valign" value="bottom"<?if($skin_setup[thumb_valign]=="bottom") echo " checked"?>>
                          �Ʒ�</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>������ ����� ���� ���� </td>
                      <td><input name="thumb_aMargin1" type="text" class="input" id="thumb_aMargin1" value="<?=$skin_setup[thumb_aMargin1]?>" size="4" maxlength="4">
                        �ȼ�</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>������ ����� ���� ���� </td>
                      <td><input name="thumb_aMargin2" type="text" class="input" id="thumb_aMargin2" value="<?=$skin_setup[thumb_aMargin2]?>" size="4" maxlength="4">
                        �ȼ�</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>�������� ��� </td>
                      <td><input type="radio" name="thumb_resize" value="0"<?if($skin_setup[thumb_resize]=="0") echo " checked"?>>�������� ������
  <input type="radio" name="thumb_resize" value="1"<?if($skin_setup[thumb_resize]=="1") echo " checked"?>>�������� �������� ����
<input type="radio" name="thumb_resize" value="2"<?if($skin_setup[thumb_resize]=="2") echo " checked"?>>�������� �����ϸ鼭 Crop </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><input name="using_usm" type="checkbox" id="using_usm" value="1"<?if($skin_setup[using_usm]) echo " checked"?><?=draw_usm(0)?>></td>
                      <td>UnSharp Mask ��� </td>
                      <td><?if($gd_version >= 2) {?>
      Amount:
        <input name="usm_option1" type="text" class="input" id="usm_option1" value="<?=$skin_setup[usm_option1]?>" size="4" maxlength="4"<?=draw_usm(0)?>>
      Radius:
      <input name="usm_option2" type="text" class="input" id="usm_option2" value="<?=$skin_setup[usm_option2]?>" size="4" maxlength="4"<?=draw_usm(0)?>>
      Threshold:
      <input name="usm_option3" type="text" class="input" id="usm_option3" value="<?=$skin_setup[usm_option3]?>" size="4" maxlength="4"<?=draw_usm(0)?>>
      <?} else echo "<font class=han2>2.0 �̻��� GD�� �ʿ��մϴ�.</font>"?></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="���� ����" style="width:100px;">
                  &nbsp;&nbsp;
                        <input name="cancel52" type="button" class="button" value="���(�ݱ�)" style="width:100px;" onClick="window.close()">
                  &nbsp;&nbsp;&nbsp;</td>
                    </tr>
                  </table>
				  </div></td>
              </tr>
            </table></td>
		  </tr>

		  
		  <tr><td class="lined" style="height:1px"><img src="t.gif" height="1"></td></tr>
		  <tr>
		    <td class="han2" style="padding:10 5 10 5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="100" align="left" valign="top"><b>����� �ϴ�</b></td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <div  onClick="showhide2(this,thumbinfo)" style="cursor:pointer;padding:0 0 5 10;">+ �Խù� ����� ����� ��¹��� �ϴ� ����� ���� </div>
                    <div id=thumbinfo style='display:<?=$tabshow?>'>
                      <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                        <col width="10" style="padding-top:0px">
                        <col width="150" style="padding-top:4px;">
                        <col width="">
                        <tr>
                          <td><input name="show_thumbInfo" type="checkbox" id="show_thumbInfo" value="1"<?if($skin_setup[show_thumbInfo]) echo " checked"?>></td>
                          <td>������ �ϴ� ���� ������ </td>
                          <td valign="bottom" style="padding:0px;">:: ����������</td>
                        </tr>
                        <tr>
                          <td rowspan="5">&nbsp;</td>
                          <td rowspan="5" valign="top">��ȣ [no] <br>
      ���� [subj]<br>
      ī�װ� [cate]<br>
      �̸� [name]<br>
      ---- info1_start ----<br>
      ��ȸ [hit]<br>
      ��õ [vote]<br>
      �ڸ�Ʈ [comment]<br>
      �Խù� ���� [point]<br>
      ---- info1_end -----<br>
      �⵵[y] - �� [month]<br>
      �� [day] - �ð� [time]<br>
      ��ǥ [bgm]<br>
      ������ �ٱ��� [admin]<br>
      5�ȼ����� [spacer] </td>
                          <td valign="top"><textarea name="thumb_info" cols="100" rows="11" wrap="VIRTUAL" class="textarea" id="thumb_info" style="width:99%"><?=stripslashes($skin_setup[thumb_info])?></textarea></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">[info1]�� ���ԵǴ� �׸��� ���� �������� �⺻ ��³���
                              <input name="info_emptyValue" type="text" class="input" id="info_emptyValue" value="<?=$skin_setup[info_emptyValue]?>" size="8" maxlength="255"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="���� ����" style="width:100px;">
                      &nbsp;&nbsp;
                            <input name="cancel52" type="button" class="button" value="���(�ݱ�)" style="width:100px;" onClick="window.close()">
                      &nbsp;&nbsp;&nbsp;</td>
                        </tr>
                      </table>
                    </div></td>
              </tr>
            </table>

		  <tr><td class="lined" style="height:1px"><img src="t.gif" height="1"></td></tr>
		  <tr>
		    <td class="han2" style="padding:10 5 10 5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="100" align="left" valign="top"><b>���� ���� #1</td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <div  onClick="showhide2(this,body1)" style="cursor:pointer;padding:0 0 5 10;">+ �Խù����⸦ ������ ������ ���� ������ �Խù� ������ ���õ� ����, ���������� ����</div>
				  <div id=body1 style='display:<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                  <col width="10" style="padding-top:0px">
                  <col width="150" style="padding-top:4px;">
                  <col width="">
                  <tr>
                    <td><input name="show_articleInfo" type="checkbox" id="show_articleInfo" value="1"<?if($skin_setup[show_articleInfo]) echo " checked"?>></td>
                    <td>�Խù� ���� ������ </td>
                    <td valign="bottom" style="padding:0px;">:: ����������</td>
                  </tr>
                  <tr>
                    <td rowspan="5">&nbsp;</td>
                    <td rowspan="5" valign="top"><p>
						���� [subj]<br>
						ī�װ� [cate]<br>
						�̸� [name]<br>
						---- info1_start ----<br>
						��ȸ [hit]<br>
						��õ [vote]<br>
						�ڸ�Ʈ [comment]<br>
						�Խù� ���� [point]<br>
						---- info1_end -----<br>
						��Ͻð� [regdate] <br>
						������� [file]<br>
						��ũ [link]<br>
						��õ�� ��� [vote_user] <br>
						5�ȼ����� [spacer]</p></td>
                    <td valign="top"><textarea name="article_info" cols="100" rows="11" wrap="VIRTUAL" class="textarea" id="textarea2" style="width:99%"><?=stripslashes($skin_setup[article_info])?></textarea></td>
                  </tr>
                  <tr>
                    <td valign="top"><input name="show_subj" type="checkbox" id="show_subj" value="1"<?if($skin_setup[show_subj]) echo " checked"?>>���� ���(�ֻ��) �� ���� ������ </td>
                  </tr>
                  <tr>
                    <td valign="top"><input name="using_bmode" type="checkbox" id="using_bmode" value="1"<?if($skin_setup[using_bmode]) echo " checked"?>>�Խù� ������ �� ���� ȭ�� �ֻ�ܿ� ��ġ / ������ �ϴ����� �̵� </td>
                  </tr>
                  <tr>
                    <td valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="���� ����" style="width:100px;">&nbsp;&nbsp;<input name="cancel52" type="button" class="button" value="���(�ݱ�)" style="width:100px;" onClick="window.close()">&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                </table>
				  </div></td>
              </tr>
            </table></td>
		  </tr>

		  
		  <tr><td class="lined" style="height:1px"><img src="t.gif" height="1"></td></tr>
		  <tr>
		    <td class="han2" style="padding:10 5 10 5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  <tr>
                <td width="100" align="left" valign="top"><b>���� ���� #2</td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <span  onClick="showhide2(this,body2)" style="cursor:pointer;padding:0 0 5 10;">+ �������� ������ ����, �̹��� ��ȣ�� �������� ���� ���μ���</span>
				  <div id=body2 style='display:<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                  <col width="10" style="padding-top:0px">
                  <col width="150" style="padding-top:4px;">
                  <col width="">
                  <tr>
                    <td><input type="checkbox" name="using_autoResize" value="1"<?if($_auto_resize && $skin_setup[using_autoResize]) echo " checked"?><?if(!$_auto_resize) echo " disabled"?>></td>
                    <td colspan="2"><?if(!$_auto_resize) echo "����ũ�� �ڵ����� - <font class=han2>PHP 4.2.0 �̻󿡼��� ����� �� �ֽ��ϴ�.</font>"; else {?>
      ����ũ�� �ڵ����� - ���ι���
        <input name="pic_overLimit1" type="text" class="input" id="pic_overLimit1" value="<?=$skin_setup[pic_overLimit1]?>" size="4" maxlength="4">
      �ȼ� �̻��� ũ���� ��� ���ι��� ũ�⸦
      <input name="pic_overLimit2" type="text" class="input" id="pic_overLimit2" value="<?=$skin_setup[pic_overLimit2]?>" size="4" maxlength="4">
      �ȼ��� ��������
      <? } ?>
                    </td>
                  </tr>
                  <tr>
                    <td><input name="mrbt_clickLimit" type="checkbox" id="mrbt_clickLimit" value="1"<?if(!file_exists("plug-ins/limit_mrbt.php")) echo " disabled"; elseif($skin_setup[mrbt_clickLimit]) echo " checked"?>></td>
                    <td colspan="2" > ImageLimit (���콺 ������ư Ŭ������) ���</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2" >�Խù� ���ΰ� ������, �׸��� ����
                      <input name="mrbt_passLevel" type="text" class="input" id="mrbt_passLevel" value="<?=$skin_setup[mrbt_passLevel]?>" size="1" maxlength="2">
�̻��� ȸ���� 'ImageLimit' �۵����� </td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="using_exif" value="1"<?if(!$plug_EX) echo " disabled"; elseif($skin_setup[using_exif]) echo " checked"?>></td>
                    <td colspan="2">Exif ���
                        <?if(!$plug_EX) echo "(<span class=han2>�������� ���ų� �������� �ʽ��ϴ�. ������ Ȩ�������� FAQ�� �����ϼ���.</span>)"?>
                    </td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="using_newWindow" value="1"<?if($skin_setup[using_newWindow]) echo " checked"?>></td>
                    <td colspan="2">�� â�� ��� ������ </td>
                    </tr>
                  <tr>
                    <td><input name="using_shutter" type="checkbox" id="using_shutter" value="1"<?if($skin_setup[using_shutter]) echo " checked"?>></td>
                    <td colspan="2">���� ȿ���� ��� </td>
                    </tr>
                  <tr>
                    <td><input name="using_bodyBtTool2" type="checkbox" id="using_bodyBtTool2" value="1"<?if($skin_setup[using_bodyBtTool2]) echo " checked"?>></td>
                    <td colspan="2">������ �ϴ��� ��ư���� ��� </td>
                  </tr>
                  <tr>
                    <td><input name="using_HTMLSeparator" type="checkbox" id="using_HTMLSeparator" value="1"<?if($skin_setup[using_HTMLSeparator]) echo " checked"?>></td>
                    <td colspan="2">HTML �±׿��� &lt;IMG&gt;�±׿� �ؽ�Ʈ�� ����</td>
                  </tr>
                  <tr>
                    <td><input name="using_newspaperMode" type="checkbox" id="using_newspaperMode" value="1"<?if($skin_setup[using_newspaperMode]) echo " checked"?>></td>
                    <td colspan="2">ù��° �̹����� �۳��� ���� ��ġ (�Ź���� ���� ����) </td>
                  </tr>
                  <tr>
                    <td><input name="using_newspaperMode2" type="checkbox" id="using_newspaperMode2" value="1"<?if($skin_setup[using_newspaperMode2]) echo " checked"?>></td>
                    <td colspan="2">�̹��� ������ ������ �̹����� ����� ���� ��ġ (�Ź���� ���� ����)</td>
                  </tr>
                  <tr>
                    <td><input name="using_picBorder" type="checkbox" id="using_picBorder" value="1"<?if($skin_setup[using_picBorder]) echo " checked"?>></td>
                    <td colspan="2">���� �׵θ� ��� </td>
                  </tr>
                  <tr>
                    <td><input name="using_bgmPlayer" type="checkbox" id="using_bgmPlayer" value="1"<?if($skin_setup['using_bgmPlayer']) echo " checked"?>></td>
                    <td colspan="2">BGM�÷��̾� ����� ���</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">����
                      <input name="bgmPlayerLevel" type="text" class="input" id="bgmPlayerLevel" value="<?=$skin_setup[bgmPlayerLevel]?>" size="2" maxlength="2">
                      �̻��� ȸ���� ���� ��� ���� </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>���� ����</td>
                    <td><input type="radio" name="pic_align" value="left"<?if($skin_setup[pic_align]=="left") echo " checked"?>>
      ����
        <input type="radio" name="pic_align" value="center"<?if($skin_setup[pic_align]=="center") echo " checked"?>>
      ���
      <input type="radio" name="pic_align" value="right"<?if($skin_setup[pic_align]=="right") echo " checked"?>>
      ������ </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>���� ��°��� ������ </td>
                    <td><input name="pic_width" type="text" class="input" id="pic_width" value="<?=$skin_setup[pic_width]?>" size="5" maxlength="5">
      �ȼ�(100 ���� ������ %�� �ν�, 0�̸� �Խ��Ǽ��� ����) </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>���� ������ ���ι��� ���� </td>
                    <td><input name="pic_vSpace" type="text" class="input" id="pic_vSpace" value="<?=$skin_setup[pic_vSpace]?>" size="5" maxlength="5">
      �ȼ�</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>������ ���� </td>
                    <td><input type="radio" name="memo_align" value="left"<?if($skin_setup[memo_align]=="left") echo " checked"?>>
      ����
        <input type="radio" name="memo_align" value="center"<?if($skin_setup[memo_align]=="center") echo " checked"?>>
      ���
      <input type="radio" name="memo_align" value="right"<?if($skin_setup[memo_align]=="right") echo " checked"?>>
      ������ </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>������ ������ </td>
                    <td><input name="memo_width" type="text" class="input" id="memo_width" value="<?=$skin_setup[memo_width]?>" size="5" maxlength="5">
      �ȼ�(100 ���� ������ %�� �ν�, 0�̸� �� ���� ���� �ڵ�) </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>���� ���� </td>
                    <td><input name="view_lSwidth" type="text" class="input" id="view_lSwidth" value="<?=$skin_setup[view_lSwidth]?>" size="5" maxlength="5">
      �ȼ�</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>���� ���� </td>
                    <td><input name="view_rSwidth" type="text" class="input" id="view_rSwidth" value="<?=$skin_setup[view_rSwidth]?>" size="5" maxlength="5">
      �ȼ�</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="���� ����" style="width:100px;">&nbsp;&nbsp;<input name="cancel52" type="button" class="button" value="���(�ݱ�)" style="width:100px;" onClick="window.close()">&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                </table>
				  </div></td>
              </tr>
            </table></td>
		  </tr>

		  
		  <tr><td class="lined" style="height:1px"><img src="t.gif" height="1"></td></tr>
		  <tr>
		    <td class="han2" style="padding:10 5 10 5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  <tr>
                <td width="100" align="left" valign="top"><b>��(�Խù�) ���</b></td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <span  onClick="showhide2(this,posting)" style="cursor:pointer;padding:0 0 5 10;">+ �۾��� ��ɰ� ���õ� ������</span>
				  <div id=posting style='display:<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                  <col width="10" style="padding-top:0px">
                  <col width="150" style="padding-top:4px;">
                  <col width="">
                  <tr>
                    <td>*</td>
                    <td colspan="2" >���ε� �ʵ� �߰�: �⺻ ���ε� �ʵ� +
                      <input name="upload_number" type="text" class="input" value="<?=$skin_setup[upload_number]?>" size="2" maxlength="2">
�� ���� �߰�����(�ִ� 99��)</td>
                  </tr>
                  <tr>
                    <td><input name="using_upload2" type="checkbox" id="using_upload2" value="1"<?if($skin_setup[using_upload2]) echo " checked"?>></td>
                    <td colspan="2" >���ε�2 �ʵ� ��� (���ε�2 �ʵ�� &quot;���κ����� �ι�° ���ε� �ʵ�&quot;��. ȣȯ�� ������) </td>
                  </tr>
                  <tr>
                    <td><input name="using_writeLimit" type="checkbox" id="using_writeLimit" value="1"<?if($skin_setup[using_writeLimit]) echo " checked"?>></td>
                    <td>�Խù� ��� ����</td>
                    <td><input name="upload_limit1" type="text" class="input" value="<?=$skin_setup[upload_limit1]?>" size="4" maxlength="4">
      �п�
        <input name="upload_limit2" type="text" class="input" value="<?=$skin_setup[upload_limit2]?>" size="4" maxlength="4">
      �� ���� (1��: 60��x24=1440��) </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>�Խù� ��� ������ ȸ��</td>
                    <td><input name="admin_upLimit_Pass" type="checkbox" id="admin_upLimit_Pass" value="1"<?if($skin_setup[admin_upLimit_Pass]) echo " checked"?>>
      ������, ����
        <input name="upLimit_Pass_Level" type="text" class="input" id="upLimit_Pass_Level" value="<?=$skin_setup[upLimit_Pass_Level]?>" size="2" maxlength="2">
      �̻��� ȸ��</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>�Խù� ��� ���� �ð� </td>
                    <td>�Խù� �����
                        <input name="upload_limit3" type="text" class="input" value="<?=$skin_setup[upload_limit3]?>" size="4" maxlength="4">
      ���� ������ ���� �Խù� ��� ���� </td>
                  </tr>
                  <tr>
                    <td><input name="ImgUpLimit" type="checkbox" id="ImgUpLimit" value="1"<?if($skin_setup[ImgUpLimit]) echo " checked"?>></td>
                    <td>�̹��� ũ�� ���� </td>
                    <td><input name="ImgUpLimit2" type="text" class="input" id="ImgUpLimit2" value="<?=$skin_setup[ImgUpLimit2]?>" size="4" maxlength="4">
                      �� ȭ�� �̻��� ���ε带 ������ </td>
                  </tr>
                  <tr>
                    <td>&nbsp;&nbsp;*</td>
                    <td>�۾��� ��ư ǥ�� </td>
                    <td><input name="write_buttonName" type="text" class="input" value="<?=$skin_setup[write_buttonName]?>" size="30" maxlength="30"></td>
                  </tr>
                  <tr>
                    <td><input name="using_emptyArticle" type="checkbox" id="using_emptyArticle" value="1"<?if($skin_setup[using_emptyArticle]) echo " checked"?>></td>
                    <td colspan="2">&quot;����, ����&quot; ���� �Խù� ��ϰ���</td>
                  </tr>
                  <tr>
                    <td><input name="using_secretonly" type="checkbox" id="using_secretonly" value="1"<?if($skin_setup[using_secretonly]) echo " checked"?><?=draw_is_active()?>></td>
                    <td colspan="2">��б۷θ� ��� </td>
                  </tr>
                  <tr>
                    <td><input name="write_nopoint" type="checkbox" id="write_nopoint" value="1"<?if($skin_setup[write_nopoint]) echo " checked"?>></td>
                    <td colspan="2">���ۼ��� ��� ȸ�� ������ �������� ����</td>
                  </tr>
                  <tr>
                    <td><input name="using_attacguard" type="checkbox" id="using_attacguard" value="1"<?if($skin_setup[using_attacguard]) echo " checked"?>></td>
                    <td colspan="2">�������, �ߺ��� ���� </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="���� ����" style="width:100px;">&nbsp;&nbsp;<input name="cancel52" type="button" class="button" value="���(�ݱ�)" style="width:100px;" onClick="window.close()">&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                </table>
				  </div></td>
              </tr>
            </table></td>
		  </tr>

		  <tr><td class="lined" style="height:1px"><img src="t.gif" height="1"></td></tr>
		  <tr>
		    <td class="han2" style="padding:10 5 10 5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  <tr>
                <td width="100" align="left" valign="top"><b>ª�����<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;+<br>
                  ��õ���</b></td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <span  onClick="showhide2(this,comment)" style="cursor:pointer;padding:0 0 5 10;">+ ª�����(�ڸ�Ʈ)�� ��õ ��ɿ� ���õ� ������</span>
				  <div id=comment style='display:<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                  <col width="10" style="padding-top:0px">
                  <col width="150" style="padding-top:4px;">
                  <col width="">
                  <tr>
                    <td><input name="using_comment" type="checkbox" id="using_comment" value="1"<?if($skin_setup[using_comment]) echo " checked"?>></td>
                    <td colspan="2">�ڸ�Ʈ ��� ���</td>
                    </tr>
                  <tr>
                    <td><input name="using_commentEditor" type="checkbox" id="using_commentEditor" value="1"<?if($skin_setup[using_commentEditor]) echo " checked"?><?=draw_is_active()?>></td>
                    <td colspan="2">�ۼ�����
                      <input name="using_commentEditor2" type="text" class="input" id="using_commentEditor2" value="<?=$skin_setup[using_commentEditor2]?>" size="3" maxlength="8"<?=draw_is_active()?>>���� ������� ���� ª������� �����Ҽ� ���� </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2" >�ۼ��� ������ ���ڼ��� 
                      <input name="comment_nopoint2" type="text" class="input" id="comment_nopoint2" value="<?=$skin_setup[comment_nopoint2]?>" size="3" maxlength="5">
                      �� ���� �������� ���� �߰��� (��������, �ѱ��� 2�ڷ� �ν�) </td>
                    </tr>
                  <tr>
                    <td><input name="using_vote" type="checkbox" id="using_vote" value="1"<?if($skin_setup[using_vote]) echo " checked"?> onClick="showhide(this,votetype)"></td>
                    <td>��õ ��� ��� </td>
                    <td><div id=votetype<?if(!$skin_setup[using_vote]) echo " style='display:none'"?>><input type="radio" name="vote_type" value="1"<?if($skin_setup[vote_type]=="1") echo " checked"?>>
�Ϲ� ��õ
  <input type="radio" name="vote_type" value="2"<?if($skin_setup[vote_type]=="2") echo " checked"?>>
��ȭ�� ��õ(����! ��ȸ���� ��õ��ư �Ⱥ���)</div></td>
                  </tr>
                  <tr>
                    <td><input name="poll_day" type="checkbox" id="poll_day" value="1"<?if($skin_setup[poll_day]) echo " checked"?><?=draw_is_active()?>></td>
                    <td colspan="2">��ǥ(��õ) �Ⱓ : 
						<select name="poll_day1" id="poll_day1"<?=draw_is_active()?>>
						<?
						$day = date('Y')-1;
						while($day <= (date('Y')+10)) {
							$select = ($day == $skin_setup['poll_day1'])? 'selected' : '';
							echo "<option value='$day' $select>$day</option>\n";
							$day++;
						}
						?>
						</select>�� 
						<select name="poll_day2" id="poll_day2"<?=draw_is_active()?>>
						<?
						$day = 1;
						while($day <= 12) {
							$select = ($day == $skin_setup['poll_day2'])? 'selected' : '';
							echo "<option value='$day' $select>$day</option>\n";
							$day++;
						}
						?>
						</select>�� 
						<select name="poll_day3" id="poll_day3"<?=draw_is_active()?>>
						<?
						$day = 1;
						while($day <= 31) {
							$select = ($day == $skin_setup['poll_day3'])? 'selected' : '';
							echo "<option value='$day' $select>$day</option>\n";
							$day++;
						}
						?>
						</select>�� ~ 
						<select name="poll_day4" id="poll_day4"<?=draw_is_active()?>>
						<?
						$day = date('Y');
						while($day <= (date('Y')+10)) {
							$select = ($day == $skin_setup['poll_day4'])? 'selected' : '';
							echo "<option value='$day' $select>$day</option>\n";
							$day++;
						}
						?>
						</select>��
						<select name="poll_day5" id="poll_day5"<?=draw_is_active()?>>
						<?
						$day = 1;
						while($day <= 12) {
							$select = ($day == $skin_setup['poll_day5'])? 'selected' : '';
							echo "<option value='$day' $select>$day</option>\n";
							$day++;
						}
						?>
						</select>��
						<select name="poll_day6" id="poll_day6"<?=draw_is_active()?>>
						<?
						$day = 1;
						while($day <= 31) {
							$select = ($day == $skin_setup['poll_day6'])? 'selected' : '';
							echo "<option value='$day' $select>$day</option>\n";
							$day++;
						}
						?>
						</select>�� ���� </td>
                    </tr>
                  <tr>
                    <td>
                      <input name="move_vote" type="checkbox" id="move_vote" value="1"<?if($skin_setup[move_vote]) echo " checked"?><?=draw_is_active()?>></td>
                    <td colspan="2">��õ���� 
					  <input name="move_vote2" type="text" class="input" id="move_vote2" value="<?=$skin_setup[move_vote2]?>" size="4" maxlength="4"<?=draw_is_active()?>> 
                      �̻��̸� 
                      <select name="move_vote3" id="move_vote3"<?=draw_is_active()?>>
<?
	$result=mysql_query("select name from $admin_table order by name");
	while($data=mysql_fetch_array($result)) {
		if($data[name] == $skin_setup['move_vote3']) $select=' selected';
		echo "<option value='$data[name]'$select>$data[name]</option>\n";
		$select="";
	}
?>
                      </select> 
                      �Խ������� 
                      <select name="move_vote4" id="move_vote4"<?=draw_is_active()?>>
                        <option value="copy_all"<?if($skin_setup['move_vote4']=='copy_all') echo " selected"?>>����</option>
                        <option value="move_all"<?if($skin_setup['move_vote4']=='move_all') echo " selected"?>>�̵�</option>
                      </select></td>
                  </tr>
                  <tr>
                    <td><input name="using_limitComment" type="checkbox" id="using_limitComment" value="1"<?if($skin_setup[using_limitComment]) echo " checked"?> onClick="onoff_chk(this,using_sendCommentMemo)"></td>
                    <td colspan="2">�� �ۼ� �Ⱓ�� 
                      <input name="using_limitComment2" type="text" class="input" id="using_limitComment2" value="<?=$skin_setup[using_limitComment2]?>" size="3" maxlength="3">
                      �� �̻� ������ ��� ª����۰� ��õ�� ���� �� ���� </td>
                  </tr>
                  <tr>
                    <td><input name="using_sendCommentMemo" type="checkbox" id="using_sendCommentMemo" value="1"<?if($skin_setup[using_sendCommentMemo]) echo " checked"?> onClick="onoff_chk(this,using_limitComment)"></td>
                    <td colspan="2">�� �ۼ� �Ⱓ�� 
                      <input name="using_sendCommentMemo2" type="text" class="input" id="using_sendCommentMemo2" value="<?=$skin_setup[using_sendCommentMemo2]?>" size="3" maxlength="3">
                      �� �̻� ������ ��� ��� ������ �� ����(���� �ۼ���)���� ������ �˸� </td>
                  </tr>
                  <tr>
                    <td><input name="using_noticecomment" type="checkbox" id="using_noticecomment" value="1"<?if($skin_setup[using_noticecomment]) echo " checked"?>></td>
                    <td colspan="2">���� �Խù��� �ڸ�Ʈ �ۼ��� �� ����</td>
                  </tr>
                  <tr>
                    <td><input name="using_cmOwnerOnly" type="checkbox" id="using_cmOwnerOnly" value="1"<?if($skin_setup[using_cmOwnerOnly]) echo " checked"?>></td>
                    <td colspan="2">�ڽ��� �ۼ��� ���� �ƴϸ� �ڸ�Ʈ ����� ���� (�����ڴ� ������� ����) </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="���� ����" style="width:100px;">&nbsp;&nbsp;<input name="cancel52" type="button" class="button" value="���(�ݱ�)" style="width:100px;" onClick="window.close()">&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                </table></div></td>
              </tr>
            </table></td>
		  </tr>
		  
		  <tr><td class="lined" style="height:1px"><img src="t.gif" height="1"></td></tr>
		  <tr>
		    <td class="han2" style="padding:10 5 10 5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  <tr>
                <td width="100" align="left"><b>�׺���̼�<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+
                  <br> 
                  &nbsp;&nbsp;�۸��</b></td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <span  onClick="showhide2(this,navi)" style="cursor:pointer;padding:0 0 5 10;">+ �� ��� ������ �������̽� ������ ��ü �׺���̼� ����</span>
				  <div id=navi style='display:<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                  <col width="10" style="padding-top:0px">
                  <col width="150" style="padding-top:4px;">
                  <col width="">
                  <tr>
                    <td><input name="using_pageNumber" type="checkbox" id="using_pageNumber" value="1"<?if($skin_setup[using_pageNumber]) echo " checked"?>></td>
                    <td>������ ��ȣ ��� </td>
                    <td>���Ĺ��:
                        <input type="radio" name="pageNum_align" value="left"<?if($skin_setup[pageNum_align]=="left") echo " checked"?>>
      ����
      <input type="radio" name="pageNum_align" value="center"<?if($skin_setup[pageNum_align]=="center") echo " checked"?>>
      ���
      <input type="radio" name="pageNum_align" value="right"<?if($skin_setup[pageNum_align]=="right") echo " checked"?>>
      ������</td>
                  </tr>
                  <tr>
                    <td><input name="using_pageNavi" type="checkbox" id="using_pageNavi" value="1"<?if($skin_setup[using_pageNavi]) echo " checked"?>></td>
                    <td>������ �̵���ư ��� </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input name="using_search" type="checkbox" id="using_search" value="1"<?if($skin_setup[using_search]) echo " checked"?>></td>
                    <td>�˻�â ��� </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input name="using_category" type="checkbox" id="using_category" value="1"<?if($skin_setup[using_category]) echo " checked"?>></td>
                    <td>ī�װ� �����</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">ī�װ� ��� ���� ������
                        <input name="cate_limit" type="text" class="input" id="cate_limit" value="<?=$skin_setup[cate_limit]?>" size="2" maxlength="2">
      �� �̻��̸� �����ٷ� �Ѿ </td>
                  </tr>
                  <tr>
                    <td><input name="using_sort" type="checkbox" id="using_sort" value="1"<?if($skin_setup[using_sort]) echo " checked"?>></td>
                    <td>���Ŀɼ� ��� </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input name="using_keyNavi" type="checkbox" id="using_keyNavi" value="1"<?if($skin_setup[using_keyNavi]) echo " checked"?>></td>
                    <td>Ű���� �׺���̼� ���</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="���� ����" style="width:100px;">&nbsp;&nbsp;<input name="cancel52" type="button" class="button" value="���(�ݱ�)" style="width:100px;" onClick="window.close()">&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                </table>
				  </div></td>
              </tr>
            </table></td>
		  </tr>

		  
		  <tr><td class="lined" style="height:1px"><img src="t.gif" height="1"></td></tr>
		  <tr>
		    <td class="han2" style="padding:10 5 10 5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  <tr>
                <td width="100" align="left" valign="top"><b>�ȳ� ��Ʈ </b></td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <span  onClick="showhide2(this,guide)" style="cursor:pointer;padding:0 0 5 10;">+ ���� �ȳ������� ���� ����</span>
				  <div id=guide style=display:'<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                  <col width="170" style="padding-top:0px">
                  <col>
				  <tr><td height=1><img src="t.gif" width=170 height=1></td><td></td>
				  </tr>
                  <tr>
                    <td colspan="2">�۾��� �ȳ� <br>(�۾��� ȭ�� ���)</td>
                    <td><textarea name="write_guide" cols="100" rows="5" wrap="VIRTUAL" class="textarea" style="width:99%"><?=trim(stripslashes($skin_setup[write_guide]))?></textarea></td>
                  </tr>
                  <tr>
                    <td colspan="2">�Խù� ��� ���<br><input name="using_wAgreement" type="checkbox" id="using_wAgreement" value="1"<?if($skin_setup[using_wAgreement]) echo " checked"?><?=draw_wAgreement(0)?>>�����</td>
                    <td><textarea name="write_agreement" cols="100" rows="5" wrap="VIRTUAL" class="textarea" style="width:99%"<?=draw_wAgreement(0)?>><?=trim(stripslashes($skin_setup[write_agreement]))?></textarea></td>
                  </tr>
                  <tr>
                    <td colspan="2">���콺������ư Ŭ���� ���<br>(*����. ������ ���Ͱ� ����<br>�ڹ� ��Ÿ�ӿ��� ���ϴ�.)</td>
                    <td><textarea name="grant_mrbt_guide" cols="100" rows="5" class="textarea" style="width:99%"><?=trim(stripslashes($skin_setup[grant_mrbt_guide]))?></textarea></td>
                  </tr>
                  <tr>
                    <td colspan="2">�ڸ�Ʈ ���� �ȳ�<br>(�ڸ�Ʈ �������ѽ�)</td>
                    <td><textarea name="comment_grant_guide" cols="100" rows="2" class="textarea" style="width:99%"><?=trim(stripslashes($skin_setup[comment_grant_guide]))?></textarea></td>
                  </tr>
                  <tr>
                    <td colspan="2">�ڸ�Ʈ �ޱ� �ȳ� </td>
                    <td><textarea name="comment_guide" cols="100" rows="2" class="textarea" style="width:99%"><?=trim(stripslashes($skin_setup[comment_guide]))?></textarea></td>
                  </tr>
                  <tr>
                    <td colspan="2">�۾��� ��� �̸� �ۼ��ϱ�<br>(����, Q&amp;A �Խ��ǿ� ������) </td>
                    <td><textarea name="write_form" cols="100" rows="5" wrap="VIRTUAL" class="textarea" id="write_form" style="width:99%"><?=$skin_setup[write_form]?></textarea></td>
                  </tr>
                </table></div></td>
			  </tr>
            </table></td>
		  </tr>

		  <tr><td class="lined" style="height:1px"><img src="t.gif" height="1"></td></tr>
		  <tr>
		    <td class="han2" style="padding:10 5 10 5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  <tr>
                <td width="100" align="left">&nbsp;</td>
                <td align="right" class=info_bg>
				<br><input type="submit" class="submit" value="���� ����" style="width:100px;">&nbsp;&nbsp;<input name="cancel52" type="button" class="button" value="���(�ݱ�)" style="width:100px;" onClick="window.close()">&nbsp;&nbsp;&nbsp;</td>
			  </tr>
            </table></td>
		  </tr>


		  </table>
	    </td>
	  </tr>
	  <tr><td height=10></td></tr>
	</form>
	</table>

<SCRIPT LANGUAGE="JavaScript">
<!--
//������ ���۵Ǳ� ���� ��ũ�� ��ġ�� �ǵ��� �ִ� ��ũ��Ʈ
	function getScroll_pos() {
	 var pos = document.body.scrollTop;
	 document.config.pos.value = pos;
	}

	if(document.config.pos.value) {
		window.scrollTo(0,document.config.pos.value);
		opener.document.location.reload();
		//opener.window.history.go(0);
	}
//-->
</SCRIPT>
<?
} //�������
	
// if($mode == "copy") $mode = "write";
if($mode == "write") {

	include "include/write_config.php";

	if($save_as && $save_file) $_SKIN_config_file = $_SKIN_config_dir."cfg_".str_replace(" ","_",$save_file).".php";

	$fp = fopen($_SKIN_config_file, "w");
	fwrite($fp, $_CONFIG_STR);
	fclose($fp);
	//chmod($_SKIN_config_file, 0707);

	//ȸ������ ���� ����
	$_SKIN_config_file = $_SKIN_config_dir."member_picture_config_".$setup[group_no].".php";
	$fp = fopen($_SKIN_config_file, "w");
	fwrite($fp, $_CONFIG_MBPIC_STR);
	fclose($fp);
	//chmod($_SKIN_config_file, 0707);

	if($board_bgColor) {
		@mysql_query("update zetyx_admin_table set bg_color='$board_bgColor' where no='$setup[no]'") or die("���κ���DB������ ����߻�<br>�Խ��� ���� �������� �߻��߽��ϴ�.");
	}
	if($thumb_vcount) {
		$thumb_total = $thumb_hcount*$thumb_vcount;
		@mysql_query("update zetyx_admin_table set memo_num='$thumb_total' where no='$setup[no]'") or die("���κ���DB������ ����߻�<br>�������� �Խù� �� �������� �߻��߽��ϴ�.");
	}
?>
<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=skin_config.php?id=<?=$id?>&mode=modify&pos=<?=$pos?>">

<?
}
?>

</body>
</html>
