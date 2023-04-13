<?php

include("kr_Sendmail.php");
include("jp_Sendmail.php");
include("en_Sendmail.php");
include("Sendmail.php");
    $conn = mysqli_connect('localhost', 'root', 'passit', 'cptcnew')or die('실패입니다.');                                     //데이터베이스 연결
  // $conn = mysqli_connect("222.101.9.198", 'root', 'passit', 'cptcnew')or die("실패입니다.");

    $sql_select = "SELECT idx FROM CP_Nanum_CronSet";                       // 2주마다 실행시키기 위한 스위치 1일때 실행
        $sql_send_start = "UPDATE CP_Nanum_CronSet SET mail_send_state= 0";     // 실행 되고있을때는 0, 실행완료시 1

    $result = mysqli_query($conn, $sql_select);                               // select 쿼리 실행
    $row = mysqli_fetch_row($result);

  $start_result = mysqli_query($conn, $sql_send_start);                     // start 쿼리실행

    $idx = ($row[0] + 1)%2;
    if ($idx == 0) {
        $year = date('Y'); //copyright 연도 표시
        header("Content-Type:text/html; charset:utf-8;");

        include("gaburi.lib.php");
        include("SQL_make.php");                            //SQL 쿼리를 작성하고 실행하는 부분
      
        include("photo_Select.php");                        //효정천보포토와 참부모님포토중 가장최신것 1개 ID 가져오기
        include("news_image_edit.php");                     //NEWS 이미지 스타일 주는 것
        include("make_var.php");                            //HTML 생성시 사용하는 모든 변수 생성
      
        include("html_kr.php");                             //각 언어별 HTML 생성
        include("html_jp.php");
        include("html_en.php");
        include("html_cn.php");
        
        include("send_Mail.php");                           //MAIL 보내기
        // include("send_mail_test.php");
    }
  $sql_update = "UPDATE CP_Nanum_CronSet SET idx=".$idx;
    $sql_send_finish = "UPDATE CP_Nanum_CronSet SET mail_send_state = 1";

   $result = mysqli_query($conn, $sql_update);            //쿼리 실행 후 $result 에 결과 저장
     $send_result = mysqli_query($conn, $sql_send_finish);
  mysqli_close($conn);
