<?php
    require_once('global.php');
    include('header.php');
    $connection = mysql_connect($db_config["hostname"],$db_config["username"],$db_config["password"],"uft-8");
    mysql_query("set character set 'utf8'");//读库
    mysql_query("set names 'utf8'");//写库
    // (2) Select the winestore database
    mysql_select_db($db_config["database"], $connection);

    // (3) Run the query on the winestore through the connection
    
    $result = mysql_query ("SELECT * FROM patient_info order by pid asc",$connection);
    $current = 'main_complain.php';
?>
<script language="javascript">   
    $(function() {
        $("tbody tr").mouseover(function() { $(this).addClass("over"); }).mouseout(function() { $(this).removeClass("over"); });
        $("tbody tr:even").addClass("alt");
        $(".l ul li a[href='<?php echo $current; ?>']").addClass("current");
    });
    
</script>
<table border="1" cellpadding="2" cellspacing="1" class="mytable">
<thead>
<tr>
<th>#</th>
<th>病历号</th>
<th>姓名</th>
<th>性别</th>
<th>入院时间</th>
<th>主诉</th>
<th>入院次数</th>
</tr>
</thead>
<tbody>
<?php
    $i=1;
    while ($row = mysql_fetch_array($result)){
    // (5) Print out each element in $row, that is, print the values of
    //foreach ($row as $attribute)
        echo '<tr>';
        $pid = $row['pid'];
        $main_complain = mysql_query ("SELECT * FROM main_complain WHERE pid = $pid order by IN_TIME asc",$connection);
        $j = mysql_num_rows($main_complain)+1;
        echo '<td rowspan="'.$j.'">'.$i.'</td>';
        echo "<td rowspan='$j'>{$row["pid"]}</td>";
        echo "<td rowspan='$j'>{$row["pname"]}</td>";
        echo "<td rowspan='$j'>{$row["gender"]}</td>";
        echo "<td rowspan='$j'>{$row["in_date"]}</td>";
        echo '</tr>';
        while ($item = mysql_fetch_array($main_complain)){
            echo '<tr>';
            echo "<td>{$item["main_complain"]}</td>";
            echo "<td>{$item["IN_TIME"]}</td>";
            echo '</tr>';
        }
        $diff = strtotime($row['out_date'])-strtotime($row['in_date']);
        //$diff = strtotime($row['out_date']);
        //echo '<td>'.idate('d', $diff).'</td>';
        echo '</tr>';
        $i++;
    // Print a carriage return to neaten the output
    //print "/n";
    }
    mysql_close($connection);
    echo '</tbody></table>';