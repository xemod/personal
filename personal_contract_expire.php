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



function icoContract($r){
	$label = 'เพิ่ม/แก้ไขสัญญา';
	$label2 = '&nbsp;';
	global $personalContract;
	vprintf('<td><a href="%s" class="%s" title="%s"><span>%s</span></a></td>',array(
		"javascript:self.location='?mod=".LURL::dotPage($personalContract)."&id=".$r."'",'ico form',
		$label2,
		$label
	));
}
?>



<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">แสดงรายการข้อมูลสัญญาคงเหลือ</div>
</div>


<table width="100%" border="0" class="tbl-list" cellspacing="2">

  <tr>
    <th class="no" style="width:10px">ลำดับ</th>
		<th style="width:160px">สัญญาคงเหลือ</th>
		<th>ชื่อพนักงาน</th>
    <th>ตำแหน่ง</th>
    <th>ประเภท</th>
    <th>วันหมดอายุ</th>
		<th>ดำเนินการ</th>
  </tr>


<?php
$i=1;
$sql="select * from vw_personal order by EndDate";
$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result)) {
	echo "<tr height='40'><td>$i</td>";
	$get->ChkContract($row["EndDate"]);
	echo "<td>".$row["FullName"]."</td>";
	echo "<td>".$row["Position"]."</td>";
	echo "<td>".$row["PerType"]."</td>";
	echo "<td>".ShowDate($row["EndDate"])."</td>";
	icoContract($row["PersonalId"]);
	echo "</tr>";
	$i++;
}
mysql_free_result($result);

?>

</table>
