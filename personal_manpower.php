<?php
/*error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
ini_set('display_errors', 1);*/
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => getMenuItem(lurl::dotPage($startupPage))->MenuName,
		'link' => '?mod='.lurl::dotPage($startupPage)
	),
	array(
		'text' => $MenuName,
	),
));


?>



<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">แสดงรายการอัตรกำลัง ณ.เวลา/ปี ปัจจุบัน</div>
</div>

<h3 class="sysdetail">ตารางที่ 1. แสดงรายการอัตรกำลังพนักงาน สวรส. ปีปัจจุบัน</h3>
<table width="100%" border="0" class="tbl-list" cellspacing="2">

  <tr>
		<th rowspan="2">หน่วย</th>
		<th colspan="13">มุมมอง-อัตราบรรจุ</th>
		<th colspan="4">มุมมอง-สัญญาจ้าง</th>
  </tr>
	<tr>
		<th>บ.1</th>
		<th>บ.2</th>
		<th>บ.3</th>
		<th>ปท.1</th>
		<th>ปท.2</th>
		<th>ปท.3</th>
		<th>ปว.1</th>
		<th>ปว.2</th>
		<th>ปว.3</th>
		<th>ว.1</th>
		<th>ว.2</th>
		<th>ว.3</th>
		<th>รวม</th>
		<th>พนักงาน</th>
		<th>ลูกจ้าง</th>
		<th>ลูกจ้างโครงการ</th>
		<th>รวม</th>

	</tr>

<?php
$i=1;
$onoff = true;
$sql="SELECT OrgName from vw_manpower GROUP BY OrgName ORDER BY OrgParent";
$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result)) {

	if(!$onoff ) $tdcolor=" bgcolor=\"#daeeff\"";else $tdcolor="";
	echo "<tr height=\"40\" align=\"center\"".$tdcolor." ><td style=\"text-align:left\"><strong>".$row["OrgName"]."</strong></td>";
	$sql2="SELECT ManPowerId,Count(ManPowerId) as Num FROM vw_manpower where OrgName ='".$row["OrgName"]."'GROUP BY ManPowerId ORDER BY ManPowerId";
	$td = array(0,0,0,0,0,0,0,0,0,0,0,0,0); //delete [0] for solv ManPowerId
	$result2 = mysql_query($sql2);
	while ($row2 = mysql_fetch_assoc($result2)) {
	 $td[$row2["ManpowerId"]]=$row2["Num"];
 	}
	//มุมมอง manpower
	$sumtmp = 0;
	for($jj=1;$jj<=12;$jj++){
		if($td[$jj]>0){
			echo "<td>".$td[$jj]."</td>";
		}else{
			echo "<td>-</td>";
		}
		$sumtmp +=$td[$jj];

	}
	//sum manpower
	echo "<td bgcolor=\"#b3dbff\"><strong>$sumtmp</strong></td>";

	//contrace type

	$sql3="SELECT PerTypeId,Count(PerTypeId) as Num FROM vw_manpower where OrgName ='".$row["OrgName"]."' GROUP BY PerTypeId ORDER BY PerTypeId";
	$td = array(0,0,0,0); //delete [0] for solv PersonalType
	$result3 = mysql_query($sql3);
	while ($row3 = mysql_fetch_assoc($result3)) {
	 $td[$row3["PerTypeId"]]=$row3["Num"];
 	}
	$sumtmp = 0;
	for($jj=1;$jj<=3;$jj++){
		if($td[$jj]>0){
			echo "<td>".$td[$jj]."</td>";
		}else{
			echo "<td>-</td>";
		}
		$sumtmp +=$td[$jj];
	}
	//sum PersonalType
	echo "<td bgcolor=\"#b3dbff\"><strong>$sumtmp</strong></td>";



$onoff = !$onoff;
}

	echo "</tr>";

mysql_free_result($result);

?>

</table>
