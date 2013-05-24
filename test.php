<head>
	<meta charset="utf-8">
    <link rel="stylesheet" title="Default Styles" href="style.css" type="text/css">
    <link rel="stylesheet" title="Default Styles" href="js/base/jquery.ui.all.css" type="text/css">    
    <script type="text/javascript" src="js/jquery.js"></script> 
    <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script> 
    <script type="text/javascript" src="js/jquery.tablesorter.js"></script> 
    <script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script> 
    <title>STEMI科研统计系统</title>
    <style>
        form{ margin: 10px 0;}
        .nav .l ul li a.current{ color: #C7C7C7 !important; }
    </style>
</head>
<body>
<div id="container">
	<h1>STEMI科研统计系统</h1>
	<div id="body">
        <div class="nav">
        <div class="l">
            <ul>
                <li><a href="index.php">首页</a>|</li>
                <li><a href="main_complain.php">主诉</a>|</li>
                <li><a href="diagnose.php">诊断</a>|</li>
                <li><a class="current" href="lab.php">检验结果</a>|</li>
                <li><a href="#">入院记录</a>|</li>
                <li><a href="#">体格检查</a>|</li>
                <li><a href="#">超声心动</a>|</li>
                <li><a href="#">医嘱</a>|</li>
                <li><a href="#">造影及介入</a>|</li>
            </ul>
        </div>
        <div class="r">
            <a class="selected" href="#">简体中文</a>|<a href="#">English</a>|<a>欢迎您，李昱熙</a>
        </div>
    </div><script language="javascript">
    $(function() {
        $("tbody tr").mouseover(function() { $(this).addClass("over"); }).mouseout(function() { $(this).removeClass("over"); });
        $("tbody tr:even").addClass("alt");
        $("#reset").click(function () { $("input#lab_key").val('')});
        var result_num = $(".count_num").size();
        $("#result_num").text(result_num);
        $(".l ul li a[href='lab.php']").addClass("current");
    });
    
</script>
<form action="lab.php" method="get">
<div title="筛选条件"><label for="lab_key" class="title">请输入筛选条件</label>
<input id="lab_key" name="lab_key" value="" type="text">
<input value="确定" type="submit"><button id="reset">清空</button>
<span>符合条件病例数：<b id="result_num">1</b> 例</span>

</div></form>
<table class="mytable" border="1" cellpadding="2" cellspacing="1">
<thead>
<tr>
<th>#</th>
<th>病历号</th>
<th>姓名</th>
<th>性别</th>
<th>入院时间/出院时间</th>
<th>时间</th>
<th>项目</th>
<th>入院次数</th>

</tr>
</thead>
<tbody>
<tr class="alt">
    <td class="count_num" rowspan="4">1</td>
    <td rowspan="4">2000602</td>
    <td rowspan="4">杜正富</td>
    <td rowspan="4">男</td>
    <td rowspan="4">2012-04-19/2012-04-26</td>
</tr>
<tr class="">
    <td>20120419122620</td>
    <td>急诊生化+CTNI+肝2+离子1+心肌酶谱</td>
    <td>3</td>
</tr>
<tr>
    <td colspan="3">test</td>
</tr>
<tr class="alt">
    <td>20120419125125</td>
    <td>出凝血功能筛查1</td>
    <td>3</td>

</tr>
</tbody>
</table>
</div>
</div>
</body>