
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
echo "连接成功\n";

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
		if($flag<10)
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
		if($flag<10)
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
		if($flag<10)
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
?>
<?php
// 画晴天的用水图和用电图
require_once ("E:\wamp\jpgraph-4.2.6\jpgraph\jpgraph.php");
require_once ("E:\wamp\jpgraph-4.2.6\jpgraph\jpgraph_line.php");

$graph = new Graph(1000,600); 
$graph->SetScale("textlin");
$graph->SetShadow();   

$graph->img->SetMargin(60,30,30,70); //设置图像边距
 
$graph->graph_theme = null; //设置主题为null，否则value->Show(); 无效



//创建设置y轴曲线曲线
$lineplot2=new LinePlot($qing_E_date); 
$lineplot2->value->SetColor("red");
$lineplot2->value->Show();


//$gbplot = new AccBarPlot(array($lineplot1,$lineplot2));
$graph->Add($lineplot2);  //将曲线放置到图像上
$graph->xaxis->SetTickLabels($qing_T_date);


$graph->title->Set("晴天->日期-用电图");   //设置图像标题
$graph->xaxis->title->Set("日期"); //设置坐标轴名称
$graph->yaxis->title->Set("度"); //设置坐标轴名称
$graph->title->SetMargin(10);
$graph->xaxis->title->SetMargin(10);
$graph->yaxis->title->SetMargin(10);


$graph->title->SetFont(FF_SIMSUN,FS_BOLD); //设置字体
$graph->yaxis->title->SetFont(FF_SIMSUN,FS_BOLD);
$graph->xaxis->title->SetFont(FF_SIMSUN,FS_BOLD); 


$graph->Stroke("..\\data\\晴天_日期-用电图.png");  //输出图像

?>
