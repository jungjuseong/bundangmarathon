function revolg_check_submit(use_category,member,using_empty) {

	if(document.check_attack.check.value==1) {
	   alert('�۾��� ��ư�� ������ �����ø� �ȵ˴ϴ�');
	   return false;
	}
	if(use_category == 1) {
	  var myindex=document.write.category[1].selectedIndex;
	  if (myindex<1)
	  {
	   alert('ī�װ��� �����Ͽ� �ֽʽÿ�');
	   return false;
	  }
	}

	if(write.agreement && !write.agreement.checked) {
		alert("�Խù� ��� ������ ���� �ϼž߸� �� �ۼ��� �Ϸ��� �� �ֽ��ϴ�.");
		return false;
	}		

	if(write.notice && write.notice.checked && using_secretonly == 1) write.is_secret.value = '0'

	if(member < 1) {
	  if(!document.write.password.value) {
	   alert('��ȣ�� �Է��Ͽ� �ּ���.\n\n��ȣ�� �Է��ϼž� ����/������ �Ҽ� �ֽ��ϴ�');
	   document.write.password.focus();
	   return false;
	  }

	  if(!document.write.name.value) {
	   alert('�̸��� �Է��Ͽ� �ּ���.');
	   document.write.name.focus();
	   return false;
	  }
	}

	if(using_empty != 1) {
		if(!document.write.subject.value) {
		   alert('������ �Է��Ͽ� �ּ���.');
		   document.write.subject.focus();
		   return false;
		}
	}

	if(using_empty != 1) {
	  if(!document.write.memo.value)  {
	   alert('������ �Է��Ͽ� �ּ���.');
	   document.write.memo.focus();
	   return false;
	  }
	}
	

    document.check_attack.check.value=1;
    show_waiting();
    hideImageBox();

    return true;
}

function showhide(obj,obj2) {
  if (obj.style.display=='none'){
	obj.style.display='';
	obj2.focus();
	obj2.select();
  }else {
	obj.style.display='none';
	}
}

var field_add = 0;

function add_upField(){
	if((total_image+start_image) <= max_image){
		var objTbl = document.getElementById('table_upload');
		var objRow = objTbl.insertRow(objTbl.rows.length);
		var cell_no = 0;
		var objCell = objRow.insertCell(cell_no);
		cell_no++;
		
		objCell.innerHTML += "<div width=\""+_leftframe_width+"\" align=\"right\" valign=\"top\" style=\"height:100%;padding:3 10 0 0;\">"+(total_image+start_image)+"</div>";
		objCell2 = objRow.insertCell(cell_no);
		cell_no++;
		objCell2.innerHTML += "<div align=center valign=top style=\"width:53px;height:100%;padding:2 3 0 0;\"><img src="+css_dir+"preview_write.jpg name=preview_image_"+total_image+"></div>";
		objCell2.vAlign='top';
		var objCell = objRow.insertCell(cell_no);
		objCell.vAlign='top';
		objCell.innerHTML += "<div valign=top style='padding:0 10 10 0;height:60'><input type=file id=upload_ex["+total_image+"] name=upload_ex["+total_image+"] cols="+cols_size+" maxlength=255 class=input2 style=width:100% onChange='image_preview(document.write.preview_image_"+total_image+",write.use_descript_"+total_image+"); imgLoad(this);'><span id=show_descript_"+total_image+" style='display:none'><textarea name=descript_"+total_image+" id=descript_"+total_image+" cols=90 rows=2 class=textarea style=width:100%></textarea></span><input type=checkbox name=use_descript_"+total_image+" value=1 onClick=showhide(show_descript_"+total_image+",descript_"+total_image+") onFocus=blur()>����÷��</div>";
	} else alert(max_image+"�� ���� ����Ҽ� �ֽ��ϴ�.");
	total_image++;
	objCell2.height = 60;
}

function add_upField2(){
	if(!total_image && (total_image+start_image) <= max_image){
		add_upField();
	}
	if(total_image == 1 && !write.use_thumbimg.checked) {
		var objTbl = document.getElementById('table_upload');
		var objRow = objTbl.deleteRow(objTbl.rows.length - 1);
		total_image = total_image - 1;
	}
}

var imageWidth = 50;
var imageHeight = 50;
var preview = new Image();
var preview_image = new Image();

function image_preview(get_previewimg,chkobj){
//global $member;
	var obj = event.srcElement;
	var ext = obj.value.toLowerCase();
	var image_load = 0;

	if(using_preview_img) preview_image = get_previewimg;
	if(using_preview_img) preview = new Image();

	if(ext.match(/(.jpg|.jpeg|.gif|.png|.bmp|.wmf)/)) {
		if(using_preview_img) preview.src = obj.value;
		chkobj.disabled = "";
		if(chkobj.name == "use_descript_z1") {
			write.use_thumbimg.disabled = ""; 
		}
	}
	else {
		if(!chkobj.name.match('use_descript_z')) {
			alert("�߰� ���ε� �ʵ忡�� �̹������ϸ� ����Ͽ��� �մϴ�.\n\n���ε� �Ͻô��� ������ ����Ͻ� �� �����ϴ�.");
			chkobj.value='';
		}
		if(using_preview_img) preview.src = css_dir+"preview_app.gif";
		chkobj.disabled = "1";
		chkobj.checked = "";
		if(chkobj.name == "use_descript_z1") {
			write.use_thumbimg.disabled = "1"; 
			write.use_thumbimg.checked  = "";
		}
		return;
	}

	if(using_preview_img) {
		preview_image.src    = obj.value;
		preview_image.width  = imageWidth;
		preview_image.height = imageHeight;
		setInterval("resize_thumb_image()",500);
	}
	
//	alert($member['user_id']);
}

function resize_thumb_image() {
	if(preview.width > preview.height) {
			preview_image.height = preview.height*imageWidth/preview.width;
			preview_image.width  = imageWidth;
			if(preview_image.height > imageHeight) {
				preview_image.width  = preview.width*imageHeight/preview.height;
				preview_image.height = imageHeight;
			} 
	}else {
			preview_image.width  = preview.width*imageHeight/preview.height;
			preview_image.height = imageHeight;
			if(preview_image.height > imageHeight) {
				preview_image.height = preview.height*imageWidth/preview.width;
				preview_image.width  = imageWidth;
			} 
	}
	document.recalc();
}

// bmmem.php���� ������ ��
var warningalert = 0;
document.write("<span id=ShowImg name=ShowImg style='display:none'></span>");

function imgLoad(filepath)
{
	var maxsize = 409600;
	var strT = new String();
	document.getElementById("ShowImg").innerHTML= "";
//	strT = document.frmphoto.userfile.value;
	strT = filepath.value;
	if(strT != "")
	{
		strT = "<img id='PhotoSample' src='" + strT + "' ></img>";
		document.getElementById("ShowImg").innerHTML= strT;
		if(!LimitedSize(maxsize))
		{
			alert("********** ���**********\n���� ũ�Ⱑ " + maxsize + " �ʰ���(�Ǵ� ��Ȯ��). \n�ݵ�� �̹����� ���� �� ��� �ٶ�. \n�׷��� ���� ���  �Է��۾��� ��ҵ�.\n(�ִ� ���� ũ�⸦ �ʰ����� ���� ��� �ٽ� �õ�) ");
			document.getElementById("ShowImg").innerHTML= "";
			filepath.setAttribute("value", "");
		}else{
			if(warningalert == 1){
//				alert('���� ũ�� �̻� ����');
				warningalert = 0;
			}
		}
	}
}

function LimitedSize(maxfilesize)
{
	var i;
	var y = document.images;
	for (i=0;i<y.length;i++)
	{
		if((y[i].id) == 'PhotoSample')
		{ 
			if(y[i].fileSize == -1){
				alert('���� ũ�� Ȯ��2');
				warningalert = 1;
			}
			if(y[i].fileSize == -1 || y[i].fileSize > maxfilesize){
				return false;
			}
/*
			if(y[i].pixelWidth * y[i].pixelHeight > 1000000){
				alert('100�� ȭ�� �̻�');
				return false;
			}
*/
		}
	}
	return true;
}
// bmmem.php���� ������ ��(end)
