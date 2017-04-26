<?php
//error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
//ini_set('display_errors', 1);
include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => getMenuItem(lurl::dotPage($startupPage))->MenuName,
		'link' => '?mod='.lurl::dotPage($startupPage)
	),
	array(
		'text' => $MenuName."-กรอบอัตรกำลัง",
	),
));



?>



<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">แสดงกรอบอัตรากำลังของแต่ละส่วนงาน</div>
</div>

<br id="top"><br>
<table width="80%" border="0" class="tbl-list" cellspacing="2">
	<tr>
    <th class="no" width="40">ลำดับ</th>
    <th align="left">ส่วนงาน</th>
    <th align="left">กรอบอัตรกำลัง</th>
		<th align="left">กำลังคนปัจจุบัน(จำนวน)</th>
		<th align="left">ส่วนต่าง</th>
		<th align="left">รายเอียด</th>
  </tr>

<?php
$i=1;
$quota1=0;
$quota2=0;
$ShowRowData = array();

$sql="SELECT * FROM tblpersonal_quota_section";
$resultQuota = mysql_query($sql);
	while($rowQuoata = mysql_fetch_assoc($resultQuota)){

		$sql="SELECT QuotaId,count(QuotaId) as num FROM vw_manpower WHERE QuotaId ='".$rowQuoata['QuotaId']."'group by QuotaId";
		$sql2="SELECT * FROM vw_manpower WHERE QuotaId =".$rowQuoata['QuotaId']." Order By Position";
		//make DATA
				$resultData = mysql_query($sql2);
				while($rowData=mysql_fetch_assoc($resultData)){
					$ShowRowDataLable[$i] = $rowQuoata["QuotaName"];
					$ShowRowData[$i] .= "<tr><td width=25%>".$rowData['FullName']."</td><td width=25%>".$rowData['Position']."</td><td>".$rowData['ManpowerName']."</td></tr>";
				}
		$result=mysql_fetch_assoc(mysql_query($sql));

		$diff = $rowQuoata['QuotaNum']-$result["num"];
		echo "<tr><td>$i</td>";
		echo "<td>".$rowQuoata["QuotaName"]."</td>";
		echo "<td align='center'><strong>".$rowQuoata['QuotaNum']."</strong></td>";
		echo "<td align='center'><strong>".$result["num"]."</strong></td>";

		if($diff == 0){
			echo "<td style=\"color:blue\"><strong>เท่ากับกรอบอัตรากำลัง</strong></td>";
		}else if($diff > 0){
			echo "<td style=\"color:green\"><strong>บรรจุได้อีก ".abs($diff)." อัตรา</strong></td>";
		}else{
			echo "<td style=\"color:red\"><strong>กรอบเกินอัตรา ".abs($diff)." อัตรา</strong></td>";
		}
		echo "<td><a href=\"#show".$i."\"><img src=\"/images/user.png\" border='0' /> คลิกรายเอียด</a> </td>";
		echo "</tr>";
		$quota1 = $quota1 + $rowQuoata['QuotaNum'];//sum
		$quota2 = $quota2 + $result["num"];//sum
		$i++;



	}
echo "</table>";

?>

<br>
<h3>สรุป</h3>
<table width="80%" border="0" class="tbl-list" cellspacing="2">
<?php
$diffsum = $quota1 - $quota2;
echo "<tr><td>กรอบอัตรากำลังคน </td><td> $quota1 อัตรา</td></tr>";
echo "<tr><td>จำนวนบรรจุจริง </td><td> <strong>$quota2</strong> อัตรา</td></tr>";
echo "<tr><td colspan='2'>";
if($diffsum == 0){
	echo "<strong>เท่ากับกรอบอัตรากำลัง</strong>";
}else if($diffsum > 0){
	echo "<strong style=\"color:green\">สามารถบรรจุกำลังคนเพิ่มได้ ".abs($diffsum)." อัตรา</strong>";
}else{
	echo "<strong style=\"color:red\">เกินกรอบอัตรากำลังคน ".abs($diffsum)." อัตรา</strong>";
}
echo "</td></tr></table>";

echo "<br><br><br><br><h3>ข้อมูล - การบรรจุอัตรากำลังคน</h3>";


for($x=1;$x<=6;$x++){
	echo "<table width=\"80%\" border=\"0\" cellpadding=\"5\"  style='color:#666' class=\"tbl-list\">";
	echo "<tr bgcolor='#c4c4c4' id='show".$x."'><td colspan='3'><img src=\"/images/people.png\" border=0 /> <strong>".$ShowRowDataLable[$x]."</strong></td></tr>";
	echo $ShowRowData[$x];
	echo "</table><br /><br /><br /><a href=\"#modules\">^ ด้านบน</a>";
}





?>
