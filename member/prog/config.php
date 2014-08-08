<?php

  $connect=mysql_connect("localhost", "coretek", "qnsekddkwk9") || die("MySQL Server 접속 불가");
  mysql_select_db("coretek") or die("mysql_select_db error");
  // $admin_id = "|nogok|seosc|run4joy|joongseokryu|"; // 반드시 앞뒤에 '|'
  $admin_id = "|run4joy|hm6818|jungjuseong|"; // 반드시 앞뒤에 '|'

  $home = "/home/hosting_users/coretek/www";
  $base_dir = "/home/hosting_users/coretek/www/member/prog";
  $managerEmail = "jungjuseong@gmail.com";
  $path2racephoto = "/home/hosting_users/coretek/www/member/racephoto";
?>
