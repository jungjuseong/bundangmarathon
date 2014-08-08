
var club_events = new Array(
		['16 October 2009','07 November 2009','11.07 제4회 마라토니아데이','',''],
		['02 November 2009','08 November 2009','11.08 오포행사','',''],
		['25 November 2009','05 December 2009','12.05 송년의밤','/bbs/zboard.php?id=pubboard&page=1&sn1=&divpage=1&sn=off&ss=on&sc=on&select_arrange=headnum&desc=asc&no=4650',''],
		['07 December 2009','27 December 2009','12.27 기록회(Half)','',''],
		['20 December 2010','1 January 2010','1.1 2010 해맞이','/bbs/zboard.php?id=pubboard&no=4711',''],
		['07 December 2009','31 January 2010','1.31 고성마라톤','','/bbs/hotnews/2010-01-31goseong.jpg'],
		['27 January 2010','14 February 2010','<font color=red><b>2.14 설 날</b></font>','#','/bbs/hotnews/2010-02-14-seol.jpg'],
		['27 January 2010','21 February 2010','2.21 아!고구려','#','/bbs/hotnews/2010-02-21-kokuryo.jpg'],
		['20 December 2009','21 March 2010','3.21 동아마라톤','#','/bbs/hotnews/2010-03-21-donga.jpg'],
		['23 March 2010','28 March 2010','3.28 회원의 날','#','/bbs/hotnews/2010-03-28-oppo1.jpg'],
		['11 April 2010','11 April 2010','4.11 예산벗꽃마라톤','#','/bbs/hotnews/2010-4-11-yesan.jpg'],
		['16 May 2010','8 June 2010','6.6클럽창립기념행사','#','/bbs/hotnews/2010-06-06-changlip.jpg'],
		['9 June 2010','30 June 2010','6th club leaders','#','/bbs/hotnews/6th-president.jpg']
);

function print_club_events() {
	var skin = "<img src='/bbs/latest_skin/unistyle6box2/unistyle6_box_bbs/images/a.gif'>";

	var is_first = 1; // true
	var this_day = new Date(); // today

	for (i = 0; i < club_events.length; i++) {
		var start_day = new Date(club_events[i][0]);
		var end_day = new Date(club_events[i][1]);

		if (end_day >= this_day) {
			if (is_first == 1) { 
				var hotnews;
				if (club_events[i][3] != "#") {
					hotnews = "<a href="+club_events[i][3]+">" + "<img src=" + club_events[i][4] + ">" + club_events[i][2]+"</a>";
				}
				else {
					hotnews = "<img src=" + club_events[i][4] + ">";
				}
				document.getElementById("HOTNEWS").innerHTML = hotnews;

				is_first = 0;
				document.write("<div id=minibox style='text-align:left'>");
				document.write("<div style='text-align:center'><B>* 클럽 행사</B></div>");

				// change the top position of the 2nd and 3rd column
				$("#C2").css("top", "550px");
				$("#C3").css("top", "550px");
				$("#copyright").css("top", "980px");
			}
			dayLeft = Math.ceil((end_day - this_day)/1000/60/60/24);
			document.write(skin + "<a href="+club_events[i][3]+">" + club_events[i][2]+"</a>->" + dayLeft + "일 남음");
			document.write("<br>");
		}

	}
	document.write("</div>");
}
