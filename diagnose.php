<?php
    require_once('global.php');
    include('header.php');
    if(isset($_REQUEST['diag_key'])) $diag_key = $_REQUEST['diag_key'];
    else $diag_key = '';
    $connection = mysql_connect($db_config["hostname"],$db_config["username"],$db_config["password"],"uft-8");
    mysql_query("set character set 'utf8'");//读库
    mysql_query("set names 'utf8'");//写库
    // (2) Select the winestore database
    mysql_select_db($db_config["database"], $connection);
    $current = 'diagnose.php';
?>
<script language="javascript">
    $(function() {
        $("tbody tr").mouseover(function() { $(this).addClass("over"); }).mouseout(function() { $(this).removeClass("over"); });
        $("tbody tr:even").addClass("alt");
        $("#reset").click(function () { $("input#diag_key").val('')});
        var result_num = $(".count_num").size();
        $("#result_num").text(result_num);
        $(".l ul li a[href='<?php echo $current; ?>']").addClass("current");
    });
    
</script>
<form action="diagnose.php" method="get">
<div title="筛选条件"><label for="diag_key" class="title">请输入筛选条件</label>
<input id="diag_key" name="diag_key" type="text" value="<?php echo $diag_key; ?>"/>
<input type="submit" value="确定"/><button id="reset">清空</button>
<span>符合条件病例数：<b id="result_num"></b> 例</span>
</form>
</div>
<table border="1" cellpadding="2" cellspacing="1" class="mytable">
<thead>
<tr>
<th>#</th>
<th>病历号</th>
<th>姓名</th>
<th>性别</th>
<th>入院时间/出院时间</th>
<th>诊断类别</th>
<th>诊断</th>
<th>入院次数</th>
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
        $diagnose = mysql_query ("SELECT * FROM diagnose WHERE pid = $pid AND diagnose_type = 'CY' AND diagnose LIKE '%$diag_key%' order by IN_TIME asc",$connection);
        $j = mysql_num_rows($diagnose)+1;
        if ($j>1){
            echo '<tr>';
            echo '<td class="count_num" rowspan="'.$j.'">'.$i.'</td>';
            echo '<td rowspan="'.$j.'">'.$row['pid'].'</td>';
            echo '<td rowspan="'.$j.'">'.$row['pname'].'</td>';
            echo '<td rowspan="'.$j.'">'.$row['gender'].'</td>';
            echo '<td rowspan="'.$j.'">'.$row['in_date'].'/'.$row['out_date'].'</td>';
            //echo '<td colspan="3"></td>';
            echo '</tr>';
            while ($item = mysql_fetch_array($diagnose)){
                echo '<tr>';
                echo "<td>{$item["diagnose_type"]}</td>";
                echo "<td>{$item["diagnose"]}</td>";
                echo "<td>{$item["IN_TIME"]}</td>";
                echo '</tr>';
            }
            echo '</tr>';
        }
        $i++;
    // Print a carriage return to neaten the output
    //print "/n";
    }
    mysql_close($connection);
    echo '</tbody></table>';