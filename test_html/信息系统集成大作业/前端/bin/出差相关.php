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
echo "连接成功" . "<br>";

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
	print_r($array_position);
	echo "<br>";
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
	print_r($array_person);
	echo "<br>";
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
	print_r($array_qing_person);
	echo "<br>";
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
	print_r($array_yin_person);
	echo "<br>";
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
	print_r($array_yu_person);
	echo "<br>";
}
else
{
	echo "0结果";
}
?>