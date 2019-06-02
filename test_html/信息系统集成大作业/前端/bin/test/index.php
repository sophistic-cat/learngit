<html>
<head>
<meta charset="utf-8" http-equiv="refresh" content="5">
<title>数据分析界面</title>
<style>
html{
	height: 100%;
}
body{
	height: 100%;
	background-image: url(..\\background\\显示界面_背景图.jpg);
	background-repeat: no-repeat;
	background-size: 100% 100%;
}
</style>
</head>

<body>
<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "streetlight";

// 晴天的数据
$qing_T_date = array();
$qing_W_date = array();
$qing_E_date = array();
// 阴天的数据
$yin_T_date = array();
$yin_W_date = array();
$yin_E_date = array();
// 雨天的数据
$yu_T_date = array();
$yu_W_date = array();
$yu_E_date = array();



//创建连接
$conn = new mysqli($servername,$username,$password,$dbname);

//检测连接
if($conn->connect_error){
	die("连接失败：".$conn->connect_error);
}
//echo "连接成功\n";

// 设置编码,防止中文乱码
mysqli_query($conn, "set names utf8");


// 晴、阴、雨对应的sql语句
$sql_qing = "SELECT 用电用水量.用水量,用电用水量.用电量,用电用水量.日期\n" .
				"FROM 天气,用电用水量\n" .
				"WHERE (天气.日期=用电用水量.日期 AND 天气.天气='晴')";
$sql_yin = "SELECT 用电用水量.用水量,用电用水量.用电量,用电用水量.日期\n" . 
				"FROM 天气,用电用水量\n" . 
				"WHERE (天气.日期=用电用水量.日期 AND 天气.天气='阴')";
$sql_yu = "SELECT 用电用水量.日期, 用电用水量.用水量, 用电用水量.用电量,用电用水量.日期\n" .
			"FROM 天气,用电用水量\n" . 
			"WHERE (天气.日期=用电用水量.日期 AND 天气.天气 LIKE '%雨')";

$result_qing = mysqli_query($conn, $sql_qing);
$result_yin = mysqli_query($conn, $sql_yin);
$result_yu = mysqli_query($conn, $sql_yu);
$flag = 0;

if(mysqli_num_rows($result_qing) > 0)
{
	while($row = mysqli_fetch_assoc($result_qing))
	{
		//echo "日期：" . $row["日期"] . " 用水量：" . $row["用水量"] . " 用电量：" . $row["用电量"] . "<br>";
		if($flag<100)
		{
			$flag = $flag + 1;
			array_push($qing_T_date, date('m-d',strtotime($row["日期"])));
			array_push($qing_E_date, $row["用电量"]);
			array_push($qing_W_date, $row["用水量"]);
		}
	}
	/*
	echo "晴天：";
	print_r($qing_T_date);
	print_r($qing_E_date);
	print_r($qing_W_date);
	echo "<br>";
	print_r("-----------------------------------------------------------------------");
	*/
}
else
{
	echo "0结果";
}
$flag = 0;

if(mysqli_num_rows($result_yin) > 0)
{
	while($row = mysqli_fetch_assoc($result_yin))
	{
		//echo "日期：" . $row["日期"] . " 用水量：" . $row["用水量"] . " 用电量：" . $row["用电量"] . "<br>";
		if($flag<100)
		{
			$flag = $flag + 1;
			array_push($yin_T_date, date('m-d',strtotime($row["日期"])));
			array_push($yin_E_date, $row["用电量"]);
			array_push($yin_W_date, $row["用水量"]);
		}
	}
	/*
	echo "<br>";
	echo "阴天:";
	print_r($yin_T_date);
	print_r($yin_E_date);
	print_r($yin_W_date);
	*/
}
else
{
	echo "0结果";
}
$flag = 0;


if(mysqli_num_rows($result_yu) > 0)
{
	while($row = mysqli_fetch_assoc($result_yu))
	{
		//echo "日期：" . $row["日期"] . " 用水量：" . $row["用水量"] . " 用电量：" . $row["用电量"] . "<br>";
		if($flag<100)
		{
			$flag = $flag + 1;
			array_push($yu_T_date, date('m-d',strtotime($row["日期"])));
			array_push($yu_E_date, $row["用电量"]);
			array_push($yu_W_date, $row["用水量"]);
		}
	}
	/*
	echo "<br>";
	echo "雨天";
	print_r($yu_T_date);
	print_r($yu_E_date);
	print_r($yu_W_date);
	*/
}
else
{
	echo "0结果";
}

// 从100个数据中随机取20个数据的函数
function random_array($real_array1, $index_array2)
{
	$new_array = array();
	foreach($index_array2 as $value)
	{
		array_push($new_array, $real_array1[$value]);
	}
	return $new_array;
}
$index_qing_E_date = array_rand($qing_E_date, 20);
$index_qing_W_date = array_rand($qing_W_date, 20);
$index_yin_E_date = array_rand($yin_E_date, 20);
$index_yin_W_date = array_rand($yin_W_date, 20);
$index_yu_E_date = array_rand($yu_E_date, 20);
$index_yu_W_date = array_rand($yu_W_date, 20);


$qing_E_date = random_array($qing_E_date, $index_qing_E_date);
$qing_W_date = random_array($qing_W_date, $index_qing_W_date);
$yin_E_date = random_array($yin_E_date, $index_yin_E_date);
$yin_W_date = random_array($yin_W_date, $index_yin_W_date);
$yu_E_date = random_array($yu_E_date, $index_yu_E_date);
$yu_W_date = random_array($yu_W_date, $index_yu_W_date);




?>
<?php
// **********************************画 用电图**********************************
require_once ("E:\wamp\jpgraph-4.2.6\jpgraph\jpgraph.php");
require_once ("E:\wamp\jpgraph-4.2.6\jpgraph\jpgraph_line.php");

$graph = new Graph(1000,600); 
$graph->SetScale("textlin");
$graph->SetShadow();   

$graph->img->SetMargin(60,30,30,70); //设置图像边距
 
$graph->graph_theme = null; //设置主题为null，否则value->Show(); 无效



//创建设置y轴 晴天 的曲线
$lineplot2=new LinePlot($qing_E_date); 
$lineplot2->value->SetColor("red");
$lineplot2->value->Show();

//创建设置y轴 阴天 的曲线
$lineplot3=new LinePlot($yin_E_date); 
$lineplot3->value->SetColor("green");
$lineplot3->value->Show();

//创建设置y轴 雨天 的曲线
$lineplot4=new LinePlot($yu_E_date); 
$lineplot4->value->SetColor("black");
$lineplot4->value->Show();


//将曲线放置到图像上
$graph->Add($lineplot2);  
$graph->Add($lineplot3);
$graph->Add($lineplot4);

//$graph->xaxis->SetTickLabels($qing_T_date);


$graph->title->Set("晴天_阴天_雨天_用电图(红-晴天;绿-阴天;黑-雨天)");   //设置图像标题
$graph->xaxis->title->Set("数据个数"); //设置坐标轴名称
$graph->yaxis->title->Set("度"); //设置坐标轴名称
$graph->title->SetMargin(10);
$graph->xaxis->title->SetMargin(10);
$graph->yaxis->title->SetMargin(10);


$graph->title->SetFont(FF_SIMSUN,FS_BOLD); //设置字体
$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD); 


$file_1 = "..\\data\\晴天_阴天_雨天_用电图.png";
if(file_exists($file_1))
{
	unlink($file_1);
}


$graph->Stroke("..\\data\\晴天_阴天_雨天_用电图.png");  //输出图像


// **********************************画 用水图**********************************
$graph1 = new Graph(1000,600); 
$graph1->SetScale("textlin");
$graph1->SetShadow();   

$graph1->img->SetMargin(60,30,30,70); //设置图像边距
 
$graph1->graph_theme = null; //设置主题为null，否则value->Show(); 无效



//创建设置y轴 晴天 的曲线
$lineplot_2=new LinePlot($qing_W_date); 
$lineplot_2->value->SetColor("red");
$lineplot_2->value->Show();

//创建设置y轴 阴天 的曲线
$lineplot_3=new LinePlot($yin_W_date); 
$lineplot_3->value->SetColor("green");
$lineplot_3->value->Show();

//创建设置y轴 雨天 的曲线
$lineplot_4=new LinePlot($yu_W_date); 
$lineplot_4->value->SetColor("black");
$lineplot_4->value->Show();


//将曲线放置到图像上
$graph1->Add($lineplot_2);  
$graph1->Add($lineplot_3);
$graph1->Add($lineplot_4);

//$graph->xaxis->SetTickLabels($qing_T_date);


$graph1->title->Set("晴天_阴天_雨天_用水图(红-晴天;绿-阴天;黑-雨天)");   //设置图像标题
$graph1->xaxis->title->Set("数据个数"); //设置坐标轴名称
$graph1->yaxis->title->Set("吨"); //设置坐标轴名称
$graph1->title->SetMargin(10);
$graph1->xaxis->title->SetMargin(10);
$graph1->yaxis->title->SetMargin(10);


$graph1->title->SetFont(FF_SIMSUN,FS_BOLD); //设置字体
$graph1->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
$graph1->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD); 


$file_2 = "..\\data\\晴天_阴天_雨天_用水图.png";
if(file_exists($file_2))
{
	unlink($file_2);
}


$graph1->Stroke("..\\data\\晴天_阴天_雨天_用水图.png");  //输出图像

/*
echo $_POST["E"];


if($_GET["E"])
{
	//echo "<img src='..\\data\\晴天_阴天_雨天_用电图.png'>";
	echo "111111";
}
else
{
	//echo "<img src='..\\data\\晴天_阴天_雨天_用水图.png'>";
	echo "2222";
}
*/
?>

<h3>统计分析晴天、阴天、雨天的用电用水量:</h3>
	<a href="..\\data\\晴天_阴天_雨天_用电图.png" target="_blank">
		<img src="..\\background\\电.jpg" alt="晴天_阴天_雨天-用电量" width="150" height="150">
	</a>
	<a href="..\\data\\晴天_阴天_雨天_用水图.png" target="_blank">
		<img src="..\\background\\水.jpg" alt="晴天_阴天_雨天-用水量" width="150" height="150">
	</a>
	
<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "streetlight";


// 设置存放出差最多的目的地 和 出差最多的人
$array_position = array();
$array_person = array();

// 比较不同天气情况的出差频次
$array_qing_person = array();
$array_yin_person = array();
$array_yu_person = array();


//创建连接
$conn = new mysqli($servername,$username,$password,$dbname);

//检测连接
if($conn->connect_error){
	die("连接失败：".$conn->connect_error);
}
//echo "连接成功" . "<br>";

// 设置编码,防止中文乱码
mysqli_query($conn, "set names utf8");


// 查找出差最多的目的地、查找出差最多的人、比较不同天气情况的出差频次
$sql_max_position = "SELECT 目的地\n" .
						"FROM 出差表\n" .
						"GROUP BY 目的地\n" . 
						"ORDER BY COUNT(*) DESC";
					
$sql_max_person = "SELECT 工号\n" .
					"FROM 人员表\n" .
					"GROUP BY 工号\n" .
					"ORDER BY COUNT(*) DESC";


// 晴天、阴天、雨天的出差频次			
$sql_qing_person = "SELECT 工号\n" .
					"FROM 出差表,天气\n" .
					"WHERE (出差表.出发时间=天气.日期 AND 天气.天气='晴')\n" . 
					"GROUP BY 工号\n" .
					"ORDER BY COUNT(*) DESC";
					
$sql_yin_person = "SELECT 工号\n" .
					"FROM 出差表,天气\n" .
					"WHERE (出差表.出发时间=天气.日期 AND 天气.天气='阴')\n" .
					"GROUP BY 工号\n" .
					"ORDER BY COUNT(*) DESC";

$sql_yu_person = "SELECT 工号\n" .
					"FROM 出差表,天气\n" .
					"WHERE (出差表.出发时间=天气.日期 AND 天气.天气 LIKE '%雨')\n" .
					"GROUP BY 工号\n" .
					"ORDER BY COUNT(*) DESC";

$result_max_position = mysqli_query($conn, $sql_max_position);
$result_max_person = mysqli_query($conn, $sql_max_person);

$result_qing_person = mysqli_query($conn, $sql_qing_person);
$result_yin_person = mysqli_query($conn, $sql_yin_person);
$result_yu_person = mysqli_query($conn, $sql_yu_person);


// 从数据库中取出 由大到小 排列好的 出差目的地 的数组
if(mysqli_num_rows($result_max_position) > 0)
{
	while($row = mysqli_fetch_assoc($result_max_position))
	{
		array_push($array_position, $row["目的地"]);
	}
	//print_r($array_position);
	//echo "<br>";
}
else
{
	echo "0结果";
}


// 从数据库中取出 由小到大 排列好的 出差人 的数组
if(mysqli_num_rows($result_max_person) > 0)
{
	while($row = mysqli_fetch_assoc($result_max_person))
	{
		array_push($array_person, $row["工号"]);
	}
	//print_r($array_person);
	//echo "<br>";
}
else
{
	echo "0结果";
}


// 晴天 的出差频次
if(mysqli_num_rows($result_qing_person) > 0)
{
	while($row = mysqli_fetch_assoc($result_qing_person))
	{
		array_push($array_qing_person, $row["工号"]);
	}
	//print_r($array_qing_person);
	//echo "<br>";
}
else
{
	echo "0结果";
}

// 阴天 的出差频次
if(mysqli_num_rows($result_yin_person) > 0)
{
	while($row = mysqli_fetch_assoc($result_yin_person))
	{
		array_push($array_yin_person, $row["工号"]);
	}
	//print_r($array_yin_person);
	//echo "<br>";
}
else
{
	echo "0结果";
}

// 雨天 的出差频次
if(mysqli_num_rows($result_yu_person) > 0)
{
	while($row = mysqli_fetch_assoc($result_yu_person))
	{
		array_push($array_yu_person, $row["工号"]);
	}
	//print_r($array_yu_person);
	//echo "<br>";
}
else
{
	echo "0结果";
}
?>
<h3>查询出差最多的目的地:</h3>
	<?php echo $array_position[0] ?>
<h3>查询出差最多的员工:</h3>
	<?php echo $array_person[0] ?>
<h3>比较不同天气情况的出差频次:</h3>
	晴天出差频次：<?php echo $array_qing_person[0]?><br>
	阴天出差频次：<?php echo $array_yin_person[0]?><br>
	雨天出差频次：<?php echo $array_yu_person[0]?><br>
	
<h3>实时化显示环境参数的变化状况:</h3>
	<a href="https://open.iot.10086.cn/app_editor/#/view?pid=230791&id=62610&is_model=0" target="_blank">请戳这里</a>
	

</body>
</html>