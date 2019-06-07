<? 
include($_SERVER["DOCUMENT_ROOT"]."/core/db/dbconn-read.php");
$userid=$_SESSION['userid'];
$userrole=$_SESSION['userrole'];
if ($userrole!=="guest")
	{
	$showstate="1";	
	$orderby="ORDER BY `priority` ASC";

$query1=mysql_query("SELECT distinct `taskid`
	FROM `task-tasks` t,`task-users`,`task-projectmembers` pm,`task-projects` pr
	WHERE t.`engineer` = `task-users`.`id` and `state`='$showstate' and pr.`id`=t.`projectid` and (t.`engineer`='1' or 
	(t.`projectid`=pm.`projectid` and pm.`memberid`='$userid') or (t.`projectid`='0' and t.`engineer`='$userid')) $orderby;");
	while ($taskdata=mysql_fetch_array($query1))
		{$sumtasknumber1=$sumtasknumber1+$taskdata[taskid];
		}
	if ($sumtasknumber1!==(int)$_REQUEST[sumtasknumber]){echo "1";/* Перегрузить список задач*/}else{echo "2"; /*Нет новых задач*/}
	}
else{echo "3";}?>
	