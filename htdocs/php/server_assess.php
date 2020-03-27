<?php
    session_start();
?>
<meta charset="UTF-8">
<?php
    $ssid = $_POST[ssid];
    $score = $_POST[score];
    $pass = $_POST[pnp];
    $sub_id = $_POST[sub_id];
    $ass_id = $_SESSION[ses_id];
    $file_name = $_POST[fname];

    // db connect
    $dbcon = mysql_connect("localhost", "root", "apmsetup");
    $con = mysql_query("use dbdbdib");

    mysql_query("set session character_set_connection=utf8;");
    mysql_query("set session character_set_results=utf8;");
    mysql_query("set session character_set_client=utf8;");



    // get task, task table name
    $query_get_tasktb_name = "SELECT T.TASK_NAME, T.TAB_NAME
        FROM file_data_type AS F, ori_data_type AS O, task AS T
        WHERE F.SSID = '$ssid'
        AND F.ORI_TYPE_ID = O.TYPE_ID
        AND O.TASK_NAME = T.TASK_NAME";
    $result = mysql_query($query_get_tasktb_name);
    $row = mysql_fetch_row($result);
    $task_name = $row[0];
    $tbname = $row[1];

    if(strcmp($pass, "1") == 0){
        // fill temporary table
        $query_fill_task = "LOAD DATA INFILE '$file_name'
            INTO TABLE `$tbname`
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\n'";
        mysql_query($query_fill_task);
    }



    // update file_data_type(score, p/np...)
    $query_update_fdt = "UPDATE file_data_type
        SET ASS_STATE = '1', ASS_SCORE = '$score', PNP = '$pass'
        WHERE SSID = '$ssid'";
    mysql_query($query_update_fdt);

    // get average of score
    $query_get_ave = "SELECT AVG(ASS_SCORE)
        FROM file_data_type AS F, ori_data_type AS O
        WHERE F.ORI_TYPE_ID = O.TYPE_ID
        AND O.TASK_NAME = '$task_name'
        AND F.SUB_ID = '$sub_id'
        AND F.ASS_STATE = '1'";
    $result = mysql_query($query_get_ave);
//    echo mysql_error($dbcon) . "<br/>";
    $row = mysql_fetch_row($result);
    $score_ave = $row[0];

    // update sub_task score
    $query_update_stask_score = "UPDATE sub_task
        SET SCORE = $score_ave
        WHERE USER_ID = '$sub_id' AND TASK_NAME = '$task_name'";
    mysql_query($query_update_stask_score);



    mysql_close();
?>
<script>
    alert("파일을 제출했습니다.")
    location.href = "ass_main.php";
</script>