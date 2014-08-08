#!/usr/bin/perl

$dir=".";
$total_count_file = "totalcount.dat";
$today_count_file = "todaycount.dat";
$yes_count_file = "yesdaycount.dat";
$max_count_file = "maxcount.dat";
$min_count_file = "mincount.dat";
$day_file = "today.dat";
$kdate = &get_date;

################## 수정해야 할 부분 ######################

$where="0";         # 카운터를 가로로 놓으려면 0, 세로로 놓으려면 1로

#_______________ 전체 오늘 현재 등의 글자색 설정 ________________

$total_textcolor="black";        # 전체 글자색
$today_textcolor="black";      # 오늘 글자색
$yes_textcolor="black";         # 어제 글자색
$max_textcolor="black";       # 최대 글자색
$min_textcolor="black";        # 최저 글자색
$user_textcolor="black";       # 현재 글자색


#______________ 전체 오늘 현재등의 숫자(데이타)색 설정 __________

$total_datacolor="blue";         # 전체 데이타색
$today_datacolor="blue";       # 오늘 데이타색
$yes_datacolor="blue";         # 어제 데이타색
$max_datacolor="blue";        # 최대 데이타색
$min_datacolor="blue";         # 최저 데이타색
$user_datacolor="red";         # 현재접속자 데이타색

################### 여기까지 ##############################
&cookie;
&get_current;
&get_Total_num;
&get_date_file;
&get_max_num;
&get_min_num;
&get_yes_num;
&get_today_num;
&put_date_file;  
&print_count;


sub get_date {
  local ($current_date, $sec, $min, $hour, $day, $mon, $year);
  ($sec ,$min, $hour, $day, $mon, $year) = (localtime(time))[0,1,2,3,4,5];
  $mon++;
  $current_date = "$day";

($current_date);
}

sub get_date_file {
   open(COUNT,"$day_file") || die "Can't Open Count Data File: $!\n";
    $day_file_count = <COUNT>;
   close(COUNT);
   if ($day_file_count =~ /\n$/) {
      chop($day_file_count);
   }
}

sub put_date_file {
   open(COUNT,">$day_file") || die "Can't Open Count Data File For Writing: $!\n";
   print COUNT "$kdate";
   close(COUNT);
}


sub get_Total_num {
   open(COUNT,"$total_count_file") || die "Can't Open Count Data File: $!\n";
    $total_count = <COUNT>;
   close(COUNT);
   if ($total_count =~ /\n$/) {
      chop($total_count);
   }
if ($COOKIE{'COUNT'} ne "카운터"){$total_count++;}
   open(COUNT,">$total_count_file") || die "Can't Open Count Data File For Writing: $!\n";
   print COUNT "$total_count";
   close(COUNT);
}

sub get_yes_num {
   open(COUNT,"$yes_count_file") || die "Can't Open Count Data File: $!\n";
    $yes_count = <COUNT>;
   close(COUNT);
   if ($yes_count =~ /\n$/) {
       chop($yes_count);
   }
   }

sub get_max_num {
   open(COUNT,"$max_count_file") || die "Can't Open Count Data File: $!\n";
     $max_count = <COUNT>;
     close(COUNT);
   if ($max_count =~ /\n$/) {
     chop($max_count);
     }
     }

sub get_min_num {
   open(COUNT,"$min_count_file") || die "Can't Open Count Data File: $!\n";
     $min_count = <COUNT>;
     close(COUNT);
   if ($min_count =~ /\n$/) {
      chop($min_count);
     }
     }

sub get_today_num {
   open(COUNT,"$today_count_file") || die "Can't Open Count Data File: $!\n";
    $today_count = <COUNT>;
   close(COUNT);
   if ($today_count =~ /\n$/) {
      chop($today_count);
   }
   if ($kdate == $day_file_count){
if ($COOKIE{'COUNT'} ne "카운터"){$today_count++;}
   }
      else {
           $yes_count=$today_count;
            open(COUNT,">$yes_count_file") || die "Can't Open Count Data File For Writing: $!\n";
            print COUNT "$yes_count";
            close(COUNT);
      if ($max_count < $today_count) {
          $max_count = $today_count;
          open(COUNT,">$max_count_file") || die "Can't Open Count Data File For Writing: $!\n";
          print COUNT "$max_count";
          close(COUNT);
          }
          elsif ($min_count > $today_count) {
          $min_count = $today_count;
          open(COUNT,">$min_count_file") || die "Can't Open Count Data File For Writing: $!\n";
          print COUNT "$min_count";
          close(COUNT);
          }
	   $today_count=1;
   }
  

   open(COUNT,">$today_count_file") || die "Can't Open Count Data File For Writing: $!\n";
   print COUNT "$today_count";
   close(COUNT);
}
sub get_current {
unless (open(MYDIR, "$dir/logs")){
print `mkdir $dir/logs`;
print `chmod 777 $dir/logs`;
print `chmod 777 $dir`;
}

$user_ip=$ENV{'REMOTE_ADDR'};

opendir(MODIFY_FILE, "$dir/logs");
@modify_file = readdir(MODIFY_FILE);
closedir(MODIFY_FILE);
foreach $modify_file (@modify_file) {
if (-f "$dir/logs/$modify_file") {
if (-M "$dir/logs/$modify_file" > 60/60/24) {
print `rm -rf $dir/logs/$modify_file`;
}
}
}

$login_data=join("||", "$year$mon$day$hour$min$sec");
unless (open(MYDIR, "$dir/logs/$user_ip")){
open(WRITE, "+>$dir/logs/$user_ip");
flock (WRITE, 8);
print WRITE "$login_data\n";
close(WRITE);
flock (WRITE, 2);
print `chmod 777 $dir/logs/$user_ip`;
}

opendir(COUNT_FILE, "$dir/logs");
@count_file = readdir(COUNT_FILE);
closedir(COUNT_FILE);
foreach $count_file (@count_file) {
if (-f "$dir/logs/$count_file") {
$user_count++;
}
}#foreach문 종료
}
#------------------
sub print_count {
   print "Set-Cookie: COUNT=카운터;\r\n";
   print "Content-type: text/html\n\n";
   print "<html>\n";
   print "<STYLE TYPE=\"text/css\">";
   print "<!--";
   print "body, table, tr, td{";
   print "  color: black\;";
   print "  font-family: 돋움,굴림, verdana, arial, helvetica, sans-serif\;";
   print "  font-size: 9pt;";
   print "  }";
   print " A:link    {text-decoration:none\;}";
   print " A:visited {text-decoration:none\;}";
   print " A:active  {color:red\;}";
   print " A:hover  {color:red\;}";
   print "-->";
   print "</style>";
   print "<body>\n";
#_______________________________________ display1(세로배열)___________________________________
if($where eq "1") {
   print "<font color=$total_textcolor>전체 : </font> <font color=$total_datacolor>$total_count</font><br>\n";
   print "<font color=$today_textcolor>오늘 : </font> <font color=$today_datacolor>$today_count</font><br>\n";
   print "<font color=$yes_textcolor>어제 : </font> <font color=$yes_datacolor>$yes_count</font><br>\n";
}
#_______________________________________ display2(가로배열)__________________________________

else {
  print "<font color=$today_textcolor>오늘</font> <font color=$today_datacolor>$today_count</font>&nbsp;<font color=$yes_textcolor>어제</font> <font color=$yes_datacolor>$yes_count</font>&nbsp;<font color=$max_textcolor>최고</font> <font color=$max_datacolor>$max_count</font>&nbsp;<font color=$total_textcolor>전체</font> <font color=$total_datacolor>$total_count</font>\n";
}
#__________________________________________________________________________________________

   print "\n</body></html>\n";

   exit;
}


sub cookie{
    if($ENV{'HTTP_COOKIE'}) {
        @cookies = split(/; /,$ENV{'HTTP_COOKIE'});
        foreach(@cookies) {
        ($name,$value) = split(/=/,$_);
        $COOKIE{$name} = $value;
        }}
}