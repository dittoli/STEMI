<?php
    require_once('global.php');
    include('header.php');
    if(isset($_REQUEST['lab_key'])) $lab_key = $_REQUEST['lab_key'];
    else $lab_key = '';
    $connection = mysql_connect($db_config["hostname"],$db_config["username"],$db_config["password"],"uft-8");
    mysql_query("set character set 'utf8'");//读库
    mysql_query("set names 'utf8'");//写库
    // (2) Select the winestore database
    mysql_select_db($db_config["database"], $connection);
    $current = 'lab.php';
?>
<style>
     .hidden{display:none;}
     span code{display: none;}
     
     /* xml style */
     
test { background: white; display: block; margin: 10px 5px; padding: 1em;}
test name { font-weight: bold; margin: 0 1em;}
specimen { display: block; float: right; margin: 0 1em;}
date { text-indent: 1em;  text-align: justify; float:left; display:block; }
requester { display: none;}
test_items { display: block; clear:both; margin: 10px;}
test_item {clear: both; display: block; border: 1px solid #CCCCCC; padding: 5px;width:100%;height:1.5em;}
test_item:hover {background: #FFFFCC;}
test_item code {display:block;border:none;background:white;margin:0;padding:0;float:left;width:5%;}
test_item name {display: block; float: left;width:25%; overflow: hidden; white-space:nowrap;}
test_item value {font-weight: bold; float: left; width:25%; overflow: hidden; white-space: nowrap;}
test_item unit {display: block; float: left; width: 10%;}
test_item reference_value1 {display: block; width: 20%; float: left; overflow:hidden; white-space: nowrap;}
test_item indicator {display: block; float: left; width: 5%; color:red;}

</style>
<script language="javascript">
    $(function() {
        $("tbody tr").mouseover(function() { $(this).addClass("over"); }).mouseout(function() { $(this).removeClass("over"); });
        $("tbody tr:even").addClass("alt");
        $("#reset").click(function () { $("input#lab_key").val('')});
        var result_num = $(".count_num").size();
        $("#result_num").text(result_num);
        $(".l ul li a[href='<?php echo $current; ?>']").addClass("current");
        $("tr.labitem").click(function() { 
            $(this).find("span").toggle();
            //$("td span").toggle();
        });
    });
    
</script>
<form action="lab.php" method="get">
<div title="筛选条件"><label for="lab_key" class="title">请输入筛选条件</label>
<input id="lab_key" name="lab_key" type="text" value="<?php echo $lab_key; ?>"/>
<input type="submit" value="确定"/><button id="reset">清空</button>
<span>符合条件病例数：<b id="result_num"></b> 例</span>
</form>
</div>
<table border="1" cellpadding="2" cellspacing="1" class="mytable">
<thead>
<tr>
<th width="1%">#</th>
<th width="5%">病历号</th>
<th width="5%">姓名</th>
<th width="5%">性别</th>
<!--
<th>入院时间/出院时间</th>
-->
<th width="10%">时间</th>
<th width="5%">入院</th>
<th>项目</th>
<!--
<th>结果</th>
-->
</tr>
</thead>
<tbody>
<?php
    // (3) Run the query on the winestore through the connection
    
    $result = mysql_query ("SELECT * FROM patient_info order by pid asc",$connection);

    $i=1;
    while ($row = mysql_fetch_array($result)){
    // (5) Print out each element in $row, that is, print the values of
    //foreach ($row as $attribute)
        $pid = $row["pid"];
        $lab = mysql_query ("SELECT * FROM lab WHERE pid = $pid AND LAB_NAME LIKE '%$lab_key%' order by IN_TIME,LAB_APPLY_TIME asc",$connection);
        $j = mysql_num_rows($lab)+1;
        if ($j>1){
            echo '<tr class="patient_info">';
            echo '<td class="count_num" rowspan="'.$j.'">'.$i.'</td>';
            echo '<td rowspan="'.$j.'">'.$row['pid'].'</td>';
            echo '<td rowspan="'.$j.'">'.$row['pname'].'</td>';
            echo '<td rowspan="'.$j.'">'.$row['gender'].'</td>';
            //echo '<td rowspan="'.$j.'">'.$row['in_date'].'/'.$row['out_date'].'</td>';
            //echo '<td colspan="3"></td>';
            echo '</tr>';
            while ($item = mysql_fetch_array($lab)){
                echo '<tr class="labitem">';
                echo "<td>{$item["LAB_APPLY_TIME"]}</td>";
                echo "<td>{$item["IN_TIME"]}</td>";
                //echo "<td>{$item["LAB_NAME"]}<span class=\"hidden record_content\">{$item["RECORD_CONTENT"]}</span></td>";
                echo "<td>{$item["LAB_NAME"]}<span class=\"hidden record_content\">";
                include 'lab_form.xml';
                echo "</span></td>";
                //echo "<td>{$item["RECORD_CONTENT"]}</td>";
                //echo "<td></td>";
                echo '</tr>';
            }
            echo '</tr>';
        }
        $i++;
        //break;
    // Print a carriage return to neaten the output
    //print "/n";
    }
    mysql_close($connection);
    echo '</tbody></table>';