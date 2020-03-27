<?php
    session_start();
?>
<meta charset="UTF-8">
<?php
    $task_name = $_POST[task_name]; // task name
    $task_tbname = $_POST[task_tb]; // task table name
    $ori_type_name = $_POST[ori_type_name]; // ori-type name
    $term_start = $_POST[term_start];
    $term_end = $_POST[term_end];
    $phase = $_POST[phase];
    $sub_id = $_SESSION[ses_id];
    $ass_id = "????"; // undefined yet

    // db connect
    $dbcon = mysql_connect("localhost", "root", "apmsetup");
    mysql_query("use dbdbdib");

    mysql_query("set session character_set_connection=utf8;");
    mysql_query("set session character_set_results=utf8;");
    mysql_query("set session character_set_client=utf8;");



    // global variables for file
    $dir_path = $_SERVER['DOCUMENT_ROOT']."/csv_files";
    // if directiry doesn't exist, make it!
    if(!file_exists($dir_path)){
        mkdir($dir_path);
    }
    $dir_path = $dir_path."/";

    $local_file_name = $_FILES["file_to_upload"]["name"];
    $target_file = $dir_path.basename($local_file_name);

    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);



    // Allow certain file formats
    if($file_type != "csv"){
        ?><script>
            alert("csv 파일을 올려주세요.");
        </script><?php
    }
    else{
        // Check if file already exists
        $split_file_name = explode(".", $target_file);
        $file_name = $split_file_name[0];
        $stored_file_name = $target_file; // file name that uploaded on server actually
        $file_cnt = 1;
        while(file_exists($stored_file_name)){
            // renew file name
            $stored_file_name = $file_name . " (" . $file_cnt++ . ").csv";
        }

        // upload file
        if(move_uploaded_file($_FILES["file_to_upload"]["tmp_name"], $stored_file_name)){



            // get create table scheme query
            $query_get_table_scheme = "SELECT SCHEME_QUERY FROM task WHERE '$task_name' = TASK_NAME";
            $result = mysql_query($query_get_table_scheme);
            $row = mysql_fetch_row($result);
            $table_scheme = $row[0];

            // get scheme mapping to table
            $query_get_mapping = "SELECT TASK_SCHEMA, TASK_MAPPING FROM ori_data_type WHERE TYPE_ID = '$ori_type_name'";
            $result = mysql_query($query_get_mapping);
            $row = mysql_fetch_row($result);
            $ori_scheme = $row[0];
            $mapping_tb_to_ori = $row[1];

            // create csv table
            $csv_tbname = "__A____________________________";
            $query_create_csv_table = "CREATE TABLE `$csv_tbname` ( $ori_scheme ) CHARSET=utf8";
            mysql_query($query_create_csv_table);

            // fill csv table
            $query_fill_csv_table = "LOAD DATA INFILE '$stored_file_name'
                INTO TABLE `$csv_tbname`
                FIELDS TERMINATED BY ','
                LINES TERMINATED BY '\n'";
            mysql_query($query_fill_csv_table);

            $temp_tbname = "__B____________________________";
            $query_create_temporary_table = "CREATE TABLE `$temp_tbname` ( $table_scheme ) CHARSET=utf8";
            mysql_query($query_create_temporary_table);

            // fill temporary table
            $query_fill_temporary_table = "INSERT INTO `$temp_tbname`
                SELECT '$sub_id' AS PRESENTOR, $mapping_tb_to_ori FROM `$csv_tbname`";
            mysql_query($query_fill_temporary_table);



            // fill REDUN_TUPLE, NULL_RATIO

            // number of tuples
            $query_get_nr_of_tuples = "SELECT COUNT(*) As nrOfTuples FROM `$temp_tbname`";
            $result = mysql_query($query_get_nr_of_tuples);
            $row = mysql_fetch_row($result);
            $nr_of_tuples = intval($row[0]);

            // number of distinct tuples
            $query_get_nr_of_distinct_tuples = "SELECT COUNT(*) As nrOfTuples FROM (SELECT DISTINCT * FROM `$temp_tbname`) T";
            $result = mysql_query($query_get_nr_of_distinct_tuples);
            $row = mysql_fetch_row($result);
            $nr_of_distinct_tuples = intval($row[0]);
            $dup_ratio = ($nr_of_tuples - $nr_of_distinct_tuples) / $nr_of_tuples;

            //number of columns and array of columns
            $nr_of_columns = 0;
            // $columns is array of col names
            $split_by_comma = explode(",", $table_scheme);
            foreach($split_by_comma as $counter => $str){
                $str_trimmed = trim($str);
                $split_by_space = explode(" ", $str_trimmed);
                $columns[$counter] = $split_by_space[0];
                $nr_of_columns++;
            }
            $columns_scheme = implode(",", $columns);

            $vals = $nr_of_tuples * $nr_of_columns;
            $nullvals = 0;
            foreach($columns as $counter => $col_name){
                $nr_of_nullvals = 0;
                $query_get_nr_of_nullvals = "SELECT COUNT(*) FROM `$temp_tbname` WHERE $col_name IS NULL";
                $result = mysql_query($query_get_nr_of_nullvals);
                $row = mysql_fetch_row($result);
                $nr_of_nullvals = intval($row[0]);
                $nullvals += $nr_of_nullvals;
            }
            $null_ratio = $nullvals / $nr_of_tuples;



            // randomly choose ass_id
            $query_get_assids = "SELECT USER_ID FROM user WHERE ROLE = 'ASS'";
            $result = mysql_query($query_get_assids);
            $rnum = rand(0, mysql_num_rows($result)-1);
            $row = mysql_fetch_row($result);
            for($i = 0; $i < $rnum; $i++){
                $row = mysql_fetch_row($result);
            }
            $ass_id = $row[0];

            // insert into file_data_type table
            $query_add_seq_file = "INSERT INTO file_data_type(
                NUMBER, SUBMIT_DATE, TERM_START, TERM_END,
                NUM_TUPLE, REDUN_TUPLE, NULL_RATIO, SUB_ID, ASS_ID,
                ASS_STATE, ORI_TYPE_ID, STORED_FILE_NAME
                ) VALUES(
                '$phase', CURDATE(), '$term_start', '$term_end',
                '$nr_of_tuples', '$dup_ratio', '$null_ratio', '$sub_id', '$ass_id',
                '0', '$ori_type_name', '$stored_file_name')";
            mysql_query($query_add_seq_file);



            // update first submit date
            $query_set_first_submit_date = "UPDATE sub_task
                SET START_DATE = CURDATE()
                WHERE USER_ID = '$sub_id'
                AND TASK_NAME = '$task_name'
                AND START_DATE IS NULL";
            mysql_query($query_set_first_submit_date);



            // export mapped table to csv file
            unlink($stored_file_name); // delete the file first
            $query_export_table = "SELECT * INTO OUTFILE '$stored_file_name'
                FIELDS TERMINATED BY ','
                LINES TERMINATED BY '\n'
                FROM `$temp_tbname`";
            mysql_query($query_export_table);

            // remove table
            $query_drop_csv_table = "DROP TABLE `$csv_tbname`";
            mysql_query($query_drop_csv_table);
            $query_drop_temporary_table = "DROP TABLE `$temp_tbname`";
            mysql_query($query_drop_temporary_table);



//echo mysql_error($dbcon) . "<br/>";
            mysql_close();

            ?><script>
                alert("csv 파일을 성공적으로 제출했습니다.");
            </script><?php
        }
        // unexpected error
        else{
            ?><script>
                alert("csv 파일을 제출하는 데 오류가 있었습니다.");
            </script><?php
        }
    }

?>
<script>
    location.href = "sub_main.php";
</script>