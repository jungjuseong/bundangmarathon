<?
// register_globals가 off일때를 위해 변수 재 정의
	@extract($HTTP_GET_VARS); 
	@extract($HTTP_POST_VARS); 
	@extract($HTTP_SERVER_VARS); 
	@extract($HTTP_ENV_VARS);

// 제로보드 라이브러리 가져옴
	$_zb_path = realpath("../../")."/";
	include $_zb_path."lib.php";

// DB 연결정보와 회원정보 가져옴
	$connect = dbConn();
	$member  = member_info();

// 게시판 설정을 가져옴
	$setup=get_table_attrib($id);
	if(!$setup[no]) error("존제하지 않는 게시판 입니다.","window.close");

// 회원인지 검사
	if(!$member[no]) Error("관리자만 접근 가능합니다.","window.close");

// 관리권한이 있는지 검사
	if($member[is_admin]>=3&&!$member[board_name]) Error("관리자만 접근 가능합니다.","window.close");
	elseif($member[is_admin]>=3&&!check_board_master($member,$setup[no])) error("관리자만 접근 가능합니다.","window.close");

// 스킨 환경설정 읽어옴
	include "get_config.php";
	//$css = 'css/white/';

	$_put_css = "1";

// 검사
	$_mbPic_config_file = $_SKIN_config_dir."member_picture_config_".$setup[group_no].".php";
	if(!file_exists($_mbPic_config_file)) {
		copy("skinconfig_mbpic_default.php",$_mbPic_config_file);
		chmod ($_mbPic_config_file, 0707);
		include $_mbPic_config_file;
	}
?>
<html>
<head>
<title>레볼루션 환경설정</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel=StyleSheet HREF=css/config.css type=text/css title=style>
</head>

<script language="JavaScript">
function go_convert() {
	ret = confirm("레볼루션 0.93 이전 버전에서 추가필드를 이용하여 업로드한 DB데이터와\n\n강화된 추천기능을 이용한 추천 데이터를 변환하는 작업입니다.\n\n변환 과정에서 발생한 문제에 대해서 제작자는 일체의 책임을 지지 않습니다.\n\n반드시 전체 DB를 미리 백업받은 후 진행하시기 바랍니다.\n\n\n\n위 내용을 읽었으며 변환 작업을 계속 하시겠습니까?");
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

// 엔진 가져오기
	$_inclib_01 = "./include/dq_thumb_engine2.";
	if(file_exists($_inclib_01.'php') && filesize($_inclib_01.'php')) include_once $_inclib_01.'php';
	else include_once $_inclib_01.'zend';

// 서버환경 알아냄 (OS는 exif프로그램 구동확인을 위해, GD는 썸네일 생성기능을 위해)
	$server_os  = get_serverOS();
	$_gd_version = get_gdVersion(1);
	$gd_version = get_gdVersion();

// 스킨 버전 가져오기
	include 'skin_version.php';

// 플러그인 검사
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

// PHP 버전에 따른 설정
	$_phpversion = substr(phpversion(),0,5);
	if($_phpversion >= '4.2.0') $_auto_resize = 1;

// 설정
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
			<td height=35 class="line2" style="font-size:13pt;font-weight:bold;">&nbsp;&nbsp;레/볼/루/션/ 환경설정 ver 1.3</td>
		  </tr>
		  <tr>
		    <td class=line2 style="padding:5px">
			  <table width="100%"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="18" width="100" align="right" class="line2"><b>서버OS</b></td>
                <td>:
                    <?=$server_os?></td>
              </tr>
              <tr>
                <td height="18" width="100" align="right" class="line2"><b>PHP버전</b></td>
                <td>: <?=phpversion()?></td>
              </tr>
              <tr>
                <td height="18" align="right" valign="top"><b>GD버전</b></td>
                <td>:
                    <?if($_gd_version) echo $_gd_version; else echo "<font class=han2>서버에 GD라이브러리가 설치되어 있지 않습니다. 썸네일을 생성하지 않고 원본을 보여줍니다.</font><br>&nbsp;&nbsp;원본을 사용할 경우 썸네일 퀄리티가 좋지 않으며 트래픽 문제가 생길수도 있습니다."?>
					<?if(get_gdVersion()<2) echo "&nbsp;&nbsp;GD 1.x 버전은 썸네일 퀄리티가 좋지 않습니다. 썸네일에서 보이는 계단현상은 정상입니다."?>
				</td>
              </tr>
              <tr>
                <td height="18" align="right"><b>스킨버전</b></td>
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
		    <a href="http://www.dqstyle.com/revolution/register.php" target="_blank"><b>-사용자 등록 </b></a>&nbsp;&nbsp;<a href="http://www.dqstyle.com/revolution/version_chk_bbs.php?version=<?=$skin_version?>" target="_blank"><b>-업데이트 검사</b></a>&nbsp;&nbsp; <a href="javascript:go_convert()"><b>-업로드데이터 변환</b></a>&nbsp;&nbsp;			</td>
		  </tr>
		  <tr><td class="lined" style="height:1px"><img src="t.gif" height="1"></td></tr>
		  <tr>
		    <td class="han2" style="padding:10 5 10 5">
			  <table width="100%"  border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed">
              <tr>
                <td width="100" align="left" valign="top"><b>기본설정</b></td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <div  onClick="showhide2(this,gen)" style="cursor:pointer;padding:0 0 5 10;">+ CSS테마, 언어묶음, 설정파일 관리와 같은 전반적인 기능과 관련된 설정들</div>
				  <div id='gen' style='display:<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                  <col width="10" style="padding-top:0px">
                  <col width="150" style="padding-top:4px;">
                  <col width="">
                  <tr>
                    <td>&nbsp;</td>
                    <td>스타일시트(CSS) 선택 </td>
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
                    <td>언어묶음 선택 </td>
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
                    <td>설정 가져오기 </td>
                    <td><select name=copy_file id="copy_file">
                        <option value="">가져오지 않음</option>
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
      이 설정에서 &nbsp;&nbsp;<input type="radio" name="cfg_link" value="1"<?if($cfg_linkCheck) echo " checked"?>>
      연결하기 &nbsp;&nbsp;<input type="radio" name="cfg_link" value="2"<?if(!$cfg_linkCheck) echo " checked"?>>가져오기</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                        <input name="save_as" type="checkbox" id="save_as" value="1" onClick=showhide(this,show_save)>
      다른이름으로 저장 <span name="show_save" id="show_save" style="display:none">
      <input name="save_file" type="text" class="input" id="save_file" size="20" maxlength="40">
      <input name="submit4" type="submit" class="submit" value="저장" style="width:50px;">
    </span> </td>
                  </tr>
                  <tr>
                    <td>&nbsp;&nbsp;*</td>
                    <td>게시판 배경색 지정 </td>
                    <td><input name="board_bgColor" type="text" class="input" id="board_bgColor" value="<?=$setup[bg_color]?>" size="20" maxlength="20">
      현재 CSS와 어울리는 배경색 : <font id=match_css class=han2><?
					  include $skin_setup['css_dir']."css_info.php";
					  echo "$match_bgColor";
					?></font>&nbsp;&nbsp<span style="cursor:pointer;" onClick="board_bgColor.value=match_css.innerHTML">[바꾸기]</span> </td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="using_pGallery" value="1"<?if(!$plug_PG) echo " disabled"?><?if($skin_setup[using_pGallery]) echo " checked"?>></td>
                    <td colspan="2">개인갤러리
                        사용<?if(!$plug_PG) echo " <font class=han2>(플러그인이 설치되지 않음)</font>"?></td>
                  </tr>
<!--
                  <tr>
                    <td><input name="using_slideshow" type="checkbox" id="using_slideshow" value="1"<?if(!$plug_SV) echo" disabled"?><?if($skin_setup[using_slideshow]) echo " checked"?>></td>
                    <td>연작사진의 슬라이드 재생 </td>
                    <td><select name="using_slideshow2"<?if(!$skin_setup[using_slideshow]) echo" disabled"?>>
                        <option value="random"<?if($skin_setup[using_slideshow2]=="random") echo " selected"?>>랜덤</option>
                        <option value="fadeInOut"<?if($skin_setup[using_slideshow2]=="fadeInOut") echo " selected"?>>페이드인 - 아웃</option>
                        <option value="bwChange"<?if($skin_setup[using_slideshow2]=="bwChange") echo " selected"?>>흑백에서 컬러로 전환</option>
                        <option value="hCross"<?if($skin_setup[using_slideshow2]=="hCross") echo " selected"?>>가로방향 겹침</option>
                        <option value="vCross"<?if($skin_setup[using_slideshow2]=="vCross") echo " selected"?>>세로방향 겹침</option>
                        <option value="crossFading"<?if($skin_setup[using_slideshow2]=="crossFading") echo " selected"?>>크로스페이딩</option>
                      </select>
                        <?if(!$plug_SV) echo " <font class=han2>(플러그인이 설치되지 않음)</font>"?></td>
                  </tr>
-->
                  <tr>
                    <td><input type="checkbox" name="using_memberPicture" value="1"<?if($skin_setup[using_memberPicture]) echo " checked"?>></td>
                    <td>회원사진 사용 </td>
                    <td>*회원사진 크기 - 가로방향:
                      <input name="member_picture_x" type="text" class="input" id="member_picture_x" value="<?=$skin_setup[member_picture_x]?>" size="5" maxlength="5">
픽셀, 세로방향:
<input name="member_picture_y" type="text" class="input" id="member_picture_y" value="<?=$skin_setup[member_picture_y]?>" size="5" maxlength="5">
픽셀 </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="설정 저장" style="width:100px;">&nbsp;&nbsp;<input name="cancel52" type="button" class="button" value="취소(닫기)" style="width:100px;" onClick="window.close()">&nbsp;&nbsp;&nbsp;</td>
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
                <td width="100" align="left" valign="top"><b>썸네일 출력</b></td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <div  onClick="showhide2(this,thumbnail)" style="cursor:pointer;padding:0 0 10 10;">+ 썸네일 생성과 관련된 설정</div>
				  <div id=thumbnail style='display:<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                    <col width="10" style="padding-top:0px">
                    <col width="150" style="padding-top:4px;">
                    <col width="">
                    <tr>
                      <td><input name="using_urlImg" type="checkbox" id="using_urlImg" value="1"<?if($skin_setup[using_urlImg]) echo " checked"?>></td>
                      <td colspan="2">외부링크에서 썸네일 생성 (HTML 태그를 분석하여 썸네일을 생성) </td>
                      </tr>
                      <td>&nbsp;</td>
                      <td>가로방향 개수</td>
                      <td><input name="thumb_hcount" type="text" class="input" id="thumb_hcount" value="<?=$skin_setup[thumb_hcount]?>" size="2" maxlength="2">
                        개</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>세로방향 개수 </td>
                      <td><input name="thumb_vcount" type="text" class="input" id="thumb_vcount" value="<?=$skin_setup[thumb_vcount]?>" size="2" maxlength="2">
                        개</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>X축 최대 크기</td>
                      <td><input name="thumb_imagex" type="text" class="input" value="<?=$skin_setup[thumb_imagex]?>" size="4" maxlength="4">
                        픽셀</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>Y축 최대 크기</td>
                      <td><input name="thumb_imagey" type="text" class="input" value="<?=$skin_setup[thumb_imagey]?>" size="4" maxlength="4">
                        픽셀</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>가로 정렬</td>
                      <td><input type="radio" name="thumb_align" value="left"<?if($skin_setup[thumb_align]=="left") echo " checked"?>>
                        왼쪽
                          <input type="radio" name="thumb_align" value="center"<?if($skin_setup[thumb_align]=="center") echo " checked"?>>
                          가운데
                          <input type="radio" name="thumb_align" value="right"<?if($skin_setup[thumb_align]=="right") echo " checked"?>>
                          오른쪽 </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>세로 정렬 </td>
                      <td><input type="radio" name="thumb_valign" value="top"<?if($skin_setup[thumb_valign]=="top") echo " checked"?>>
                        위
                          <input type="radio" name="thumb_valign" value="middle"<?if($skin_setup[thumb_valign]=="middle") echo " checked"?>>
                          가운데
                          <input type="radio" name="thumb_valign" value="bottom"<?if($skin_setup[thumb_valign]=="bottom") echo " checked"?>>
                          아래</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>섬네일 목록의 좌측 여백 </td>
                      <td><input name="thumb_aMargin1" type="text" class="input" id="thumb_aMargin1" value="<?=$skin_setup[thumb_aMargin1]?>" size="4" maxlength="4">
                        픽셀</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>섬네일 목록의 우측 여백 </td>
                      <td><input name="thumb_aMargin2" type="text" class="input" id="thumb_aMargin2" value="<?=$skin_setup[thumb_aMargin2]?>" size="4" maxlength="4">
                        픽셀</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>리사이즈 방식 </td>
                      <td><input type="radio" name="thumb_resize" value="0"<?if($skin_setup[thumb_resize]=="0") echo " checked"?>>원본비율 유지함
  <input type="radio" name="thumb_resize" value="1"<?if($skin_setup[thumb_resize]=="1") echo " checked"?>>원본비율 유지하지 않음
<input type="radio" name="thumb_resize" value="2"<?if($skin_setup[thumb_resize]=="2") echo " checked"?>>원본비율 유지하면서 Crop </td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><input name="using_usm" type="checkbox" id="using_usm" value="1"<?if($skin_setup[using_usm]) echo " checked"?><?=draw_usm(0)?>></td>
                      <td>UnSharp Mask 사용 </td>
                      <td><?if($gd_version >= 2) {?>
      Amount:
        <input name="usm_option1" type="text" class="input" id="usm_option1" value="<?=$skin_setup[usm_option1]?>" size="4" maxlength="4"<?=draw_usm(0)?>>
      Radius:
      <input name="usm_option2" type="text" class="input" id="usm_option2" value="<?=$skin_setup[usm_option2]?>" size="4" maxlength="4"<?=draw_usm(0)?>>
      Threshold:
      <input name="usm_option3" type="text" class="input" id="usm_option3" value="<?=$skin_setup[usm_option3]?>" size="4" maxlength="4"<?=draw_usm(0)?>>
      <?} else echo "<font class=han2>2.0 이상의 GD가 필요합니다.</font>"?></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="설정 저장" style="width:100px;">
                  &nbsp;&nbsp;
                        <input name="cancel52" type="button" class="button" value="취소(닫기)" style="width:100px;" onClick="window.close()">
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
                <td width="100" align="left" valign="top"><b>썸네일 하단</b></td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <div  onClick="showhide2(this,thumbinfo)" style="cursor:pointer;padding:0 0 5 10;">+ 게시물 목록의 썸네일 출력물의 하단 출력을 설정 </div>
                    <div id=thumbinfo style='display:<?=$tabshow?>'>
                      <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                        <col width="10" style="padding-top:0px">
                        <col width="150" style="padding-top:4px;">
                        <col width="">
                        <tr>
                          <td><input name="show_thumbInfo" type="checkbox" id="show_thumbInfo" value="1"<?if($skin_setup[show_thumbInfo]) echo " checked"?>></td>
                          <td>섬네일 하단 정보 보여줌 </td>
                          <td valign="bottom" style="padding:0px;">:: 내용편집기</td>
                        </tr>
                        <tr>
                          <td rowspan="5">&nbsp;</td>
                          <td rowspan="5" valign="top">번호 [no] <br>
      제목 [subj]<br>
      카테고리 [cate]<br>
      이름 [name]<br>
      ---- info1_start ----<br>
      조회 [hit]<br>
      추천 [vote]<br>
      코멘트 [comment]<br>
      게시물 점수 [point]<br>
      ---- info1_end -----<br>
      년도[y] - 월 [month]<br>
      일 [day] - 시간 [time]<br>
      음표 [bgm]<br>
      관리자 바구니 [admin]<br>
      5픽셀공백 [spacer] </td>
                          <td valign="top"><textarea name="thumb_info" cols="100" rows="11" wrap="VIRTUAL" class="textarea" id="thumb_info" style="width:99%"><?=stripslashes($skin_setup[thumb_info])?></textarea></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">[info1]에 포함되는 항목의 값이 없을때의 기본 출력내용
                              <input name="info_emptyValue" type="text" class="input" id="info_emptyValue" value="<?=$skin_setup[info_emptyValue]?>" size="8" maxlength="255"></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="설정 저장" style="width:100px;">
                      &nbsp;&nbsp;
                            <input name="cancel52" type="button" class="button" value="취소(닫기)" style="width:100px;" onClick="window.close()">
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
                <td width="100" align="left" valign="top"><b>본문 내용 #1</td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <div  onClick="showhide2(this,body1)" style="cursor:pointer;padding:0 0 5 10;">+ 게시물보기를 했을때 나오는 본문 내용중 게시물 정보와 관련된 설정, 내용편집기 설정</div>
				  <div id=body1 style='display:<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                  <col width="10" style="padding-top:0px">
                  <col width="150" style="padding-top:4px;">
                  <col width="">
                  <tr>
                    <td><input name="show_articleInfo" type="checkbox" id="show_articleInfo" value="1"<?if($skin_setup[show_articleInfo]) echo " checked"?>></td>
                    <td>게시물 정보 보여줌 </td>
                    <td valign="bottom" style="padding:0px;">:: 내용편집기</td>
                  </tr>
                  <tr>
                    <td rowspan="5">&nbsp;</td>
                    <td rowspan="5" valign="top"><p>
						제목 [subj]<br>
						카테고리 [cate]<br>
						이름 [name]<br>
						---- info1_start ----<br>
						조회 [hit]<br>
						추천 [vote]<br>
						코멘트 [comment]<br>
						게시물 점수 [point]<br>
						---- info1_end -----<br>
						등록시간 [regdate] <br>
						등록파일 [file]<br>
						링크 [link]<br>
						추천인 목록 [vote_user] <br>
						5픽셀공백 [spacer]</p></td>
                    <td valign="top"><textarea name="article_info" cols="100" rows="11" wrap="VIRTUAL" class="textarea" id="textarea2" style="width:99%"><?=stripslashes($skin_setup[article_info])?></textarea></td>
                  </tr>
                  <tr>
                    <td valign="top"><input name="show_subj" type="checkbox" id="show_subj" value="1"<?if($skin_setup[show_subj]) echo " checked"?>>사진 상단(최상단) 에 제목 보여줌 </td>
                  </tr>
                  <tr>
                    <td valign="top"><input name="using_bmode" type="checkbox" id="using_bmode" value="1"<?if($skin_setup[using_bmode]) echo " checked"?>>게시물 정보를 글 보기 화면 최상단에 배치 / 해제시 하단으로 이동 </td>
                  </tr>
                  <tr>
                    <td valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="설정 저장" style="width:100px;">&nbsp;&nbsp;<input name="cancel52" type="button" class="button" value="취소(닫기)" style="width:100px;" onClick="window.close()">&nbsp;&nbsp;&nbsp;</td>
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
                <td width="100" align="left" valign="top"><b>본문 내용 #2</td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <span  onClick="showhide2(this,body2)" style="cursor:pointer;padding:0 0 5 10;">+ 본문내용 볼때의 정렬, 이미지 보호와 리사이즈 등의 세부설정</span>
				  <div id=body2 style='display:<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                  <col width="10" style="padding-top:0px">
                  <col width="150" style="padding-top:4px;">
                  <col width="">
                  <tr>
                    <td><input type="checkbox" name="using_autoResize" value="1"<?if($_auto_resize && $skin_setup[using_autoResize]) echo " checked"?><?if(!$_auto_resize) echo " disabled"?>></td>
                    <td colspan="2"><?if(!$_auto_resize) echo "사진크기 자동조절 - <font class=han2>PHP 4.2.0 이상에서만 사용할 수 있습니다.</font>"; else {?>
      사진크기 자동조절 - 가로방향
        <input name="pic_overLimit1" type="text" class="input" id="pic_overLimit1" value="<?=$skin_setup[pic_overLimit1]?>" size="4" maxlength="4">
      픽셀 이상의 크기일 경우 가로방향 크기를
      <input name="pic_overLimit2" type="text" class="input" id="pic_overLimit2" value="<?=$skin_setup[pic_overLimit2]?>" size="4" maxlength="4">
      픽셀로 리사이즈
      <? } ?>
                    </td>
                  </tr>
                  <tr>
                    <td><input name="mrbt_clickLimit" type="checkbox" id="mrbt_clickLimit" value="1"<?if(!file_exists("plug-ins/limit_mrbt.php")) echo " disabled"; elseif($skin_setup[mrbt_clickLimit]) echo " checked"?>></td>
                    <td colspan="2" > ImageLimit (마우스 우측버튼 클릭차단) 사용</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2" >게시물 주인과 관리자, 그리고 레벨
                      <input name="mrbt_passLevel" type="text" class="input" id="mrbt_passLevel" value="<?=$skin_setup[mrbt_passLevel]?>" size="1" maxlength="2">
이상의 회원은 'ImageLimit' 작동안함 </td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="using_exif" value="1"<?if(!$plug_EX) echo " disabled"; elseif($skin_setup[using_exif]) echo " checked"?>></td>
                    <td colspan="2">Exif 출력
                        <?if(!$plug_EX) echo "(<span class=han2>실행모듈이 없거나 동작하지 않습니다. 제작자 홈페이지의 FAQ를 참고하세요.</span>)"?>
                    </td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="using_newWindow" value="1"<?if($skin_setup[using_newWindow]) echo " checked"?>></td>
                    <td colspan="2">새 창을 열어서 보여줌 </td>
                    </tr>
                  <tr>
                    <td><input name="using_shutter" type="checkbox" id="using_shutter" value="1"<?if($skin_setup[using_shutter]) echo " checked"?>></td>
                    <td colspan="2">셔터 효과음 사용 </td>
                    </tr>
                  <tr>
                    <td><input name="using_bodyBtTool2" type="checkbox" id="using_bodyBtTool2" value="1"<?if($skin_setup[using_bodyBtTool2]) echo " checked"?>></td>
                    <td colspan="2">페이지 하단의 버튼모음 사용 </td>
                  </tr>
                  <tr>
                    <td><input name="using_HTMLSeparator" type="checkbox" id="using_HTMLSeparator" value="1"<?if($skin_setup[using_HTMLSeparator]) echo " checked"?>></td>
                    <td colspan="2">HTML 태그에서 &lt;IMG&gt;태그와 텍스트를 분할</td>
                  </tr>
                  <tr>
                    <td><input name="using_newspaperMode" type="checkbox" id="using_newspaperMode" value="1"<?if($skin_setup[using_newspaperMode]) echo " checked"?>></td>
                    <td colspan="2">첫번째 이미지를 글내용 왼편에 배치 (신문기사 보기 형태) </td>
                  </tr>
                  <tr>
                    <td><input name="using_newspaperMode2" type="checkbox" id="using_newspaperMode2" value="1"<?if($skin_setup[using_newspaperMode2]) echo " checked"?>></td>
                    <td colspan="2">이미지 설명이 있을때 이미지를 설명글 왼편에 배치 (신문기사 보기 형태)</td>
                  </tr>
                  <tr>
                    <td><input name="using_picBorder" type="checkbox" id="using_picBorder" value="1"<?if($skin_setup[using_picBorder]) echo " checked"?>></td>
                    <td colspan="2">사진 테두리 사용 </td>
                  </tr>
                  <tr>
                    <td><input name="using_bgmPlayer" type="checkbox" id="using_bgmPlayer" value="1"<?if($skin_setup['using_bgmPlayer']) echo " checked"?>></td>
                    <td colspan="2">BGM플레이어 제어기 사용</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">레벨
                      <input name="bgmPlayerLevel" type="text" class="input" id="bgmPlayerLevel" value="<?=$skin_setup[bgmPlayerLevel]?>" size="2" maxlength="2">
                      이상의 회원만 음악 재생 가능 </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>사진 정렬</td>
                    <td><input type="radio" name="pic_align" value="left"<?if($skin_setup[pic_align]=="left") echo " checked"?>>
      왼쪽
        <input type="radio" name="pic_align" value="center"<?if($skin_setup[pic_align]=="center") echo " checked"?>>
      가운데
      <input type="radio" name="pic_align" value="right"<?if($skin_setup[pic_align]=="right") echo " checked"?>>
      오른쪽 </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>사진 출력공간 가로폭 </td>
                    <td><input name="pic_width" type="text" class="input" id="pic_width" value="<?=$skin_setup[pic_width]?>" size="5" maxlength="5">
      픽셀(100 보다 작으면 %로 인식, 0이면 게시판설정 적용) </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>사진 사이의 세로방향 간격 </td>
                    <td><input name="pic_vSpace" type="text" class="input" id="pic_vSpace" value="<?=$skin_setup[pic_vSpace]?>" size="5" maxlength="5">
      픽셀</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>본문글 정렬 </td>
                    <td><input type="radio" name="memo_align" value="left"<?if($skin_setup[memo_align]=="left") echo " checked"?>>
      왼쪽
        <input type="radio" name="memo_align" value="center"<?if($skin_setup[memo_align]=="center") echo " checked"?>>
      가운데
      <input type="radio" name="memo_align" value="right"<?if($skin_setup[memo_align]=="right") echo " checked"?>>
      오른쪽 </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>본문글 가로폭 </td>
                    <td><input name="memo_width" type="text" class="input" id="memo_width" value="<?=$skin_setup[memo_width]?>" size="5" maxlength="5">
      픽셀(100 보다 작으면 %로 인식, 0이면 글 수에 따라 자동) </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>좌측 여백 </td>
                    <td><input name="view_lSwidth" type="text" class="input" id="view_lSwidth" value="<?=$skin_setup[view_lSwidth]?>" size="5" maxlength="5">
      픽셀</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>우측 여백 </td>
                    <td><input name="view_rSwidth" type="text" class="input" id="view_rSwidth" value="<?=$skin_setup[view_rSwidth]?>" size="5" maxlength="5">
      픽셀</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="설정 저장" style="width:100px;">&nbsp;&nbsp;<input name="cancel52" type="button" class="button" value="취소(닫기)" style="width:100px;" onClick="window.close()">&nbsp;&nbsp;&nbsp;</td>
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
                <td width="100" align="left" valign="top"><b>글(게시물) 등록</b></td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <span  onClick="showhide2(this,posting)" style="cursor:pointer;padding:0 0 5 10;">+ 글쓰기 기능과 관련된 설정들</span>
				  <div id=posting style='display:<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                  <col width="10" style="padding-top:0px">
                  <col width="150" style="padding-top:4px;">
                  <col width="">
                  <tr>
                    <td>*</td>
                    <td colspan="2" >업로드 필드 추가: 기본 업로드 필드 +
                      <input name="upload_number" type="text" class="input" value="<?=$skin_setup[upload_number]?>" size="2" maxlength="2">
개 까지 추가가능(최대 99개)</td>
                  </tr>
                  <tr>
                    <td><input name="using_upload2" type="checkbox" id="using_upload2" value="1"<?if($skin_setup[using_upload2]) echo " checked"?>></td>
                    <td colspan="2" >업로드2 필드 사용 (업로드2 필드는 &quot;제로보드의 두번째 업로드 필드&quot;다. 호환성 유지용) </td>
                  </tr>
                  <tr>
                    <td><input name="using_writeLimit" type="checkbox" id="using_writeLimit" value="1"<?if($skin_setup[using_writeLimit]) echo " checked"?>></td>
                    <td>게시물 등록 제한</td>
                    <td><input name="upload_limit1" type="text" class="input" value="<?=$skin_setup[upload_limit1]?>" size="4" maxlength="4">
      분에
        <input name="upload_limit2" type="text" class="input" value="<?=$skin_setup[upload_limit2]?>" size="4" maxlength="4">
      개 까지 (1일: 60분x24=1440분) </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>게시물 등록 무제한 회원</td>
                    <td><input name="admin_upLimit_Pass" type="checkbox" id="admin_upLimit_Pass" value="1"<?if($skin_setup[admin_upLimit_Pass]) echo " checked"?>>
      관리자, 레벨
        <input name="upLimit_Pass_Level" type="text" class="input" id="upLimit_Pass_Level" value="<?=$skin_setup[upLimit_Pass_Level]?>" size="2" maxlength="2">
      이상의 회원</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>게시물 등록 제한 시간 </td>
                    <td>게시물 등록후
                        <input name="upload_limit3" type="text" class="input" value="<?=$skin_setup[upload_limit3]?>" size="4" maxlength="4">
      분이 지나야 다음 게시물 등록 가능 </td>
                  </tr>
                  <tr>
                    <td><input name="ImgUpLimit" type="checkbox" id="ImgUpLimit" value="1"<?if($skin_setup[ImgUpLimit]) echo " checked"?>></td>
                    <td>이미지 크기 제한 </td>
                    <td><input name="ImgUpLimit2" type="text" class="input" id="ImgUpLimit2" value="<?=$skin_setup[ImgUpLimit2]?>" size="4" maxlength="4">
                      만 화소 이상은 업로드를 제한함 </td>
                  </tr>
                  <tr>
                    <td>&nbsp;&nbsp;*</td>
                    <td>글쓰기 버튼 표기 </td>
                    <td><input name="write_buttonName" type="text" class="input" value="<?=$skin_setup[write_buttonName]?>" size="30" maxlength="30"></td>
                  </tr>
                  <tr>
                    <td><input name="using_emptyArticle" type="checkbox" id="using_emptyArticle" value="1"<?if($skin_setup[using_emptyArticle]) echo " checked"?>></td>
                    <td colspan="2">&quot;제목, 내용&quot; 없이 게시물 등록가능</td>
                  </tr>
                  <tr>
                    <td><input name="using_secretonly" type="checkbox" id="using_secretonly" value="1"<?if($skin_setup[using_secretonly]) echo " checked"?><?=draw_is_active()?>></td>
                    <td colspan="2">비밀글로만 등록 </td>
                  </tr>
                  <tr>
                    <td><input name="write_nopoint" type="checkbox" id="write_nopoint" value="1"<?if($skin_setup[write_nopoint]) echo " checked"?>></td>
                    <td colspan="2">글작성시 얻는 회원 점수를 적용하지 않음</td>
                  </tr>
                  <tr>
                    <td><input name="using_attacguard" type="checkbox" id="using_attacguard" value="1"<?if($skin_setup[using_attacguard]) echo " checked"?>></td>
                    <td colspan="2">도배방지, 중복글 방지 </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="설정 저장" style="width:100px;">&nbsp;&nbsp;<input name="cancel52" type="button" class="button" value="취소(닫기)" style="width:100px;" onClick="window.close()">&nbsp;&nbsp;&nbsp;</td>
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
                <td width="100" align="left" valign="top"><b>짧은답글<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;+<br>
                  추천기능</b></td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <span  onClick="showhide2(this,comment)" style="cursor:pointer;padding:0 0 5 10;">+ 짧은답글(코멘트)과 추천 기능에 관련된 설정들</span>
				  <div id=comment style='display:<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                  <col width="10" style="padding-top:0px">
                  <col width="150" style="padding-top:4px;">
                  <col width="">
                  <tr>
                    <td><input name="using_comment" type="checkbox" id="using_comment" value="1"<?if($skin_setup[using_comment]) echo " checked"?>></td>
                    <td colspan="2">코멘트 기능 사용</td>
                    </tr>
                  <tr>
                    <td><input name="using_commentEditor" type="checkbox" id="using_commentEditor" value="1"<?if($skin_setup[using_commentEditor]) echo " checked"?><?=draw_is_active()?>></td>
                    <td colspan="2">작성한후
                      <input name="using_commentEditor2" type="text" class="input" id="using_commentEditor2" value="<?=$skin_setup[using_commentEditor2]?>" size="3" maxlength="8"<?=draw_is_active()?>>분을 경과하지 않은 짧은답글은 수정할수 있음 </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2" >작성글 내용의 글자수가 
                      <input name="comment_nopoint2" type="text" class="input" id="comment_nopoint2" value="<?=$skin_setup[comment_nopoint2]?>" size="3" maxlength="5">
                      자 보다 많을때만 점수 추가됨 (영문기준, 한글은 2자로 인식) </td>
                    </tr>
                  <tr>
                    <td><input name="using_vote" type="checkbox" id="using_vote" value="1"<?if($skin_setup[using_vote]) echo " checked"?> onClick="showhide(this,votetype)"></td>
                    <td>추천 기능 사용 </td>
                    <td><div id=votetype<?if(!$skin_setup[using_vote]) echo " style='display:none'"?>><input type="radio" name="vote_type" value="1"<?if($skin_setup[vote_type]=="1") echo " checked"?>>
일반 추천
  <input type="radio" name="vote_type" value="2"<?if($skin_setup[vote_type]=="2") echo " checked"?>>
강화된 추천(주의! 비회원은 추천버튼 안보임)</div></td>
                  </tr>
                  <tr>
                    <td><input name="poll_day" type="checkbox" id="poll_day" value="1"<?if($skin_setup[poll_day]) echo " checked"?><?=draw_is_active()?>></td>
                    <td colspan="2">투표(추천) 기간 : 
						<select name="poll_day1" id="poll_day1"<?=draw_is_active()?>>
						<?
						$day = date('Y')-1;
						while($day <= (date('Y')+10)) {
							$select = ($day == $skin_setup['poll_day1'])? 'selected' : '';
							echo "<option value='$day' $select>$day</option>\n";
							$day++;
						}
						?>
						</select>년 
						<select name="poll_day2" id="poll_day2"<?=draw_is_active()?>>
						<?
						$day = 1;
						while($day <= 12) {
							$select = ($day == $skin_setup['poll_day2'])? 'selected' : '';
							echo "<option value='$day' $select>$day</option>\n";
							$day++;
						}
						?>
						</select>월 
						<select name="poll_day3" id="poll_day3"<?=draw_is_active()?>>
						<?
						$day = 1;
						while($day <= 31) {
							$select = ($day == $skin_setup['poll_day3'])? 'selected' : '';
							echo "<option value='$day' $select>$day</option>\n";
							$day++;
						}
						?>
						</select>일 ~ 
						<select name="poll_day4" id="poll_day4"<?=draw_is_active()?>>
						<?
						$day = date('Y');
						while($day <= (date('Y')+10)) {
							$select = ($day == $skin_setup['poll_day4'])? 'selected' : '';
							echo "<option value='$day' $select>$day</option>\n";
							$day++;
						}
						?>
						</select>년
						<select name="poll_day5" id="poll_day5"<?=draw_is_active()?>>
						<?
						$day = 1;
						while($day <= 12) {
							$select = ($day == $skin_setup['poll_day5'])? 'selected' : '';
							echo "<option value='$day' $select>$day</option>\n";
							$day++;
						}
						?>
						</select>월
						<select name="poll_day6" id="poll_day6"<?=draw_is_active()?>>
						<?
						$day = 1;
						while($day <= 31) {
							$select = ($day == $skin_setup['poll_day6'])? 'selected' : '';
							echo "<option value='$day' $select>$day</option>\n";
							$day++;
						}
						?>
						</select>일 까지 </td>
                    </tr>
                  <tr>
                    <td>
                      <input name="move_vote" type="checkbox" id="move_vote" value="1"<?if($skin_setup[move_vote]) echo " checked"?><?=draw_is_active()?>></td>
                    <td colspan="2">추천수가 
					  <input name="move_vote2" type="text" class="input" id="move_vote2" value="<?=$skin_setup[move_vote2]?>" size="4" maxlength="4"<?=draw_is_active()?>> 
                      이상이면 
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
                      게시판으로 
                      <select name="move_vote4" id="move_vote4"<?=draw_is_active()?>>
                        <option value="copy_all"<?if($skin_setup['move_vote4']=='copy_all') echo " selected"?>>복사</option>
                        <option value="move_all"<?if($skin_setup['move_vote4']=='move_all') echo " selected"?>>이동</option>
                      </select></td>
                  </tr>
                  <tr>
                    <td><input name="using_limitComment" type="checkbox" id="using_limitComment" value="1"<?if($skin_setup[using_limitComment]) echo " checked"?> onClick="onoff_chk(this,using_sendCommentMemo)"></td>
                    <td colspan="2">글 작성 기간이 
                      <input name="using_limitComment2" type="text" class="input" id="using_limitComment2" value="<?=$skin_setup[using_limitComment2]?>" size="3" maxlength="3">
                      일 이상 지났을 경우 짧은답글과 추천을 남길 수 없음 </td>
                  </tr>
                  <tr>
                    <td><input name="using_sendCommentMemo" type="checkbox" id="using_sendCommentMemo" value="1"<?if($skin_setup[using_sendCommentMemo]) echo " checked"?> onClick="onoff_chk(this,using_limitComment)"></td>
                    <td colspan="2">글 작성 기간이 
                      <input name="using_sendCommentMemo2" type="text" class="input" id="using_sendCommentMemo2" value="<?=$skin_setup[using_sendCommentMemo2]?>" size="3" maxlength="3">
                      일 이상 지났을 경우 답글 내용을 글 주인(본문 작성자)에게 쪽지로 알림 </td>
                  </tr>
                  <tr>
                    <td><input name="using_noticecomment" type="checkbox" id="using_noticecomment" value="1"<?if($skin_setup[using_noticecomment]) echo " checked"?>></td>
                    <td colspan="2">공지 게시물에 코멘트 작성할 수 있음</td>
                  </tr>
                  <tr>
                    <td><input name="using_cmOwnerOnly" type="checkbox" id="using_cmOwnerOnly" value="1"<?if($skin_setup[using_cmOwnerOnly]) echo " checked"?>></td>
                    <td colspan="2">자신이 작성한 글이 아니면 코멘트 남길수 없음 (관리자는 영향받지 않음) </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="설정 저장" style="width:100px;">&nbsp;&nbsp;<input name="cancel52" type="button" class="button" value="취소(닫기)" style="width:100px;" onClick="window.close()">&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                </table></div></td>
              </tr>
            </table></td>
		  </tr>
		  
		  <tr><td class="lined" style="height:1px"><img src="t.gif" height="1"></td></tr>
		  <tr>
		    <td class="han2" style="padding:10 5 10 5"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
			  <tr>
                <td width="100" align="left"><b>네비게이션<br>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+
                  <br> 
                  &nbsp;&nbsp;글목록</b></td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <span  onClick="showhide2(this,navi)" style="cursor:pointer;padding:0 0 5 10;">+ 글 목록 볼때의 인터페이스 설정과 전체 네비게이션 설정</span>
				  <div id=navi style='display:<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                  <col width="10" style="padding-top:0px">
                  <col width="150" style="padding-top:4px;">
                  <col width="">
                  <tr>
                    <td><input name="using_pageNumber" type="checkbox" id="using_pageNumber" value="1"<?if($skin_setup[using_pageNumber]) echo " checked"?>></td>
                    <td>페이지 번호 사용 </td>
                    <td>정렬방법:
                        <input type="radio" name="pageNum_align" value="left"<?if($skin_setup[pageNum_align]=="left") echo " checked"?>>
      왼쪽
      <input type="radio" name="pageNum_align" value="center"<?if($skin_setup[pageNum_align]=="center") echo " checked"?>>
      가운데
      <input type="radio" name="pageNum_align" value="right"<?if($skin_setup[pageNum_align]=="right") echo " checked"?>>
      오른쪽</td>
                  </tr>
                  <tr>
                    <td><input name="using_pageNavi" type="checkbox" id="using_pageNavi" value="1"<?if($skin_setup[using_pageNavi]) echo " checked"?>></td>
                    <td>페이지 이동버튼 사용 </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input name="using_search" type="checkbox" id="using_search" value="1"<?if($skin_setup[using_search]) echo " checked"?>></td>
                    <td>검색창 사용 </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input name="using_category" type="checkbox" id="using_category" value="1"<?if($skin_setup[using_category]) echo " checked"?>></td>
                    <td>카테고리 출력함</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">카테고리 출력 가로 개수가
                        <input name="cate_limit" type="text" class="input" id="cate_limit" value="<?=$skin_setup[cate_limit]?>" size="2" maxlength="2">
      개 이상이면 다음줄로 넘어감 </td>
                  </tr>
                  <tr>
                    <td><input name="using_sort" type="checkbox" id="using_sort" value="1"<?if($skin_setup[using_sort]) echo " checked"?>></td>
                    <td>정렬옵션 사용 </td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><input name="using_keyNavi" type="checkbox" id="using_keyNavi" value="1"<?if($skin_setup[using_keyNavi]) echo " checked"?>></td>
                    <td>키보드 네비게이션 사용</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="right" valign="top"><input name="submit2" type="submit" class="submit" value="설정 저장" style="width:100px;">&nbsp;&nbsp;<input name="cancel52" type="button" class="button" value="취소(닫기)" style="width:100px;" onClick="window.close()">&nbsp;&nbsp;&nbsp;</td>
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
                <td width="100" align="left" valign="top"><b>안내 멘트 </b></td>
                <td width=1 class=line2></td>
                <td width=1 class=line1></td>
                <td valign="top" style="padding:2px;">
				  <span  onClick="showhide2(this,guide)" style="cursor:pointer;padding:0 0 5 10;">+ 각종 안내문구의 내용 설정</span>
				  <div id=guide style=display:'<?=$tabshow?>'>
				  <table width="100%"  border="0" cellpadding="3" cellspacing="0">
                  <col width="170" style="padding-top:0px">
                  <col>
				  <tr><td height=1><img src="t.gif" width=170 height=1></td><td></td>
				  </tr>
                  <tr>
                    <td colspan="2">글쓰기 안내 <br>(글쓰기 화면 상단)</td>
                    <td><textarea name="write_guide" cols="100" rows="5" wrap="VIRTUAL" class="textarea" style="width:99%"><?=trim(stripslashes($skin_setup[write_guide]))?></textarea></td>
                  </tr>
                  <tr>
                    <td colspan="2">게시물 등록 약관<br><input name="using_wAgreement" type="checkbox" id="using_wAgreement" value="1"<?if($skin_setup[using_wAgreement]) echo " checked"?><?=draw_wAgreement(0)?>>사용함</td>
                    <td><textarea name="write_agreement" cols="100" rows="5" wrap="VIRTUAL" class="textarea" style="width:99%"<?=draw_wAgreement(0)?>><?=trim(stripslashes($skin_setup[write_agreement]))?></textarea></td>
                  </tr>
                  <tr>
                    <td colspan="2">마우스우측버튼 클릭시 경고<br>(*주의. 편집시 엔터가 들어가면<br>자바 런타임에러 납니다.)</td>
                    <td><textarea name="grant_mrbt_guide" cols="100" rows="5" class="textarea" style="width:99%"><?=trim(stripslashes($skin_setup[grant_mrbt_guide]))?></textarea></td>
                  </tr>
                  <tr>
                    <td colspan="2">코멘트 제한 안내<br>(코멘트 레벨제한시)</td>
                    <td><textarea name="comment_grant_guide" cols="100" rows="2" class="textarea" style="width:99%"><?=trim(stripslashes($skin_setup[comment_grant_guide]))?></textarea></td>
                  </tr>
                  <tr>
                    <td colspan="2">코멘트 달기 안내 </td>
                    <td><textarea name="comment_guide" cols="100" rows="2" class="textarea" style="width:99%"><?=trim(stripslashes($skin_setup[comment_guide]))?></textarea></td>
                  </tr>
                  <tr>
                    <td colspan="2">글쓰기 양식 미리 작성하기<br>(장터, Q&amp;A 게시판에 적합함) </td>
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
				<br><input type="submit" class="submit" value="설정 저장" style="width:100px;">&nbsp;&nbsp;<input name="cancel52" type="button" class="button" value="취소(닫기)" style="width:100px;" onClick="window.close()">&nbsp;&nbsp;&nbsp;</td>
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
//폼값이 전송되기 전의 스크롤 위치로 되돌려 주는 스크립트
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
} //수정모드
	
// if($mode == "copy") $mode = "write";
if($mode == "write") {

	include "include/write_config.php";

	if($save_as && $save_file) $_SKIN_config_file = $_SKIN_config_dir."cfg_".str_replace(" ","_",$save_file).".php";

	$fp = fopen($_SKIN_config_file, "w");
	fwrite($fp, $_CONFIG_STR);
	fclose($fp);
	//chmod($_SKIN_config_file, 0707);

	//회원사진 설정 저장
	$_SKIN_config_file = $_SKIN_config_dir."member_picture_config_".$setup[group_no].".php";
	$fp = fopen($_SKIN_config_file, "w");
	fwrite($fp, $_CONFIG_MBPIC_STR);
	fclose($fp);
	//chmod($_SKIN_config_file, 0707);

	if($board_bgColor) {
		@mysql_query("update zetyx_admin_table set bg_color='$board_bgColor' where no='$setup[no]'") or die("제로보드DB수정중 요류발생<br>게시판 배경색 설정에서 발생했습니다.");
	}
	if($thumb_vcount) {
		$thumb_total = $thumb_hcount*$thumb_vcount;
		@mysql_query("update zetyx_admin_table set memo_num='$thumb_total' where no='$setup[no]'") or die("제로보드DB수정중 요류발생<br>페이지당 게시물 수 설정에서 발생했습니다.");
	}
?>
<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=skin_config.php?id=<?=$id?>&mode=modify&pos=<?=$pos?>">

<?
}
?>

</body>
</html>
