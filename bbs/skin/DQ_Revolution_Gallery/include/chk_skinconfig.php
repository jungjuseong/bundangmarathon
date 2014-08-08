<?
$dqEngine['using_urlImg']	= isset($skin_setup['using_urlImg'])	? $skin_setup['using_urlImg']	: 1;
$dqEngine['using_socket']	= isset($skin_setup['using_socket'])	? $skin_setup['using_socket']	: 0;
$dqEngine['using_usm']		= isset($skin_setup['using_usm'])		? $skin_setup['using_usm']		: 1;
$dqEngine['usm_option1']	= isset($skin_setup['usm_option1'])		? $skin_setup['usm_option1']	: 60;
$dqEngine['usm_option2']	= isset($skin_setup['usm_option2'])		? $skin_setup['usm_option2']	: 0.5;
$dqEngine['usm_option3']	= isset($skin_setup['usm_option3'])		? $skin_setup['usm_option3']	: 1;
$dqEngine['using_thumbnail']= isset($skin_setup['using_thumbnail'])	? $skin_setup['using_thumbnail']: 1;
$dqEngine['thumb_cutpixel']	= isset($skin_setup['thumb_cutpixel'])	? $skin_setup['thumb_cutpixel'] : 5;
$dqEngine['using_secretImg']= isset($skin_setup['using_secretImg'])	? $skin_setup['using_secretImg']: 1;

//$dqEngine['using_urlenc'] = 0;

if(!$skin_setup['language_dir']) $skin_setup['language_dir'] = "language/kor/";
$skin_setup['using_gmode'] = '1';
$skin_setup['using_preview_img'] = '1';
$skin_setup['disable_login'] = '0';
$skin_setup['using_thumbNavi'] = '1';

//if(eregi("msie",getenv("HTTP_USER_AGENT"))) $skin_setup[using_bgmPlayer]=1; else $skin_setup[using_bgmPlayer]=0;
//if(empty($skin_setup['pic_vSpace']))	  $skin_setup['pic_vSpace']		= 25;
?>
