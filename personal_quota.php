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
		'text' => $MenuName."-กรอบอัตรกำลัง",
	),
));



?>



<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">แสดงกรอบอัตรากำลังของแต่ละส่วนงาน</div>
</div>


<table width="80%" border="0" class="tbl-list" cellspacing="2">
	<tr>
    <th class="no" width="40">ลำดับ</th>
    <th align="left">ส่วนงาน</th>
    <th align="left">กรอบอัตรกำลัง</th>
		<th align="left">กำลังคนปัจจุบัน(จำนวน)</th>
		<th align="left">ส่วนต่าง</th>
  </tr>

<?php
$i=1;
$quata1=0;
$quata2=0;

$sql="SELECT * FROM tblpersonal_quota";
$resultQuota = mysql_query($sql);
	while($rowQuoata = mysql_fetch_assoc($resultQuota)){
		echo $sql="SELECT QuotaId,count(QuotaId) as num FROM vw_manpower WHERE QuotaId ='".$rowQuoata['Type']."'group by QuotaId";
		//$result = mysql_query($sql);
	}

/*$sql="SELECT QuotaId,count(QuotaId) as num FROM vw_manpower group by QuotaId";
$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result)) {
	echo "<tr><td>$i</td>";
	$sqlqouta = "Select * from tblpersonal_quota WHERE Type=".$row["QuotaId"];
	$qouta = mysql_fetch_assoc(mysql_query($sqlqouta));
	$diff = $qouta["QuotaNum"]-$row["num"];

	echo "<td>".$qouta["QuotaName"]."</td>";
	echo "<td><strong>".$qouta["QuotaNum"]."</strong></td>";
	echo "<td><strong>".$row["num"]."</strong></td>";
	if($diff < 1){
		echo "<td style=\"color:red\"><strong>$diff</strong></td>";
	}else{
		echo "<td style=\"color:green\"><strong>+$diff</strong></td>";
	}
	echo "</tr>";
	$quata1+=$row["num"];
	$quata2+=$qouta["QuotaNum"];
	$i++;
}
echo "</table>";
*/
?>
<br>
<p><strong>สรุป</stong></p>
<table width="50%" border="0" class="tbl-list" cellspacing="2">
<?php
echo "<tr><td>โควตาอัตรากำลังคน </td><td> $quata1 อัตรา</td></tr>";
echo "<tr><td>จำนวนบรรจุจริง </td><td> <strong  style=\"color:red\">$quata2</strong> อัตรา</td></tr>";

if($quata1<$quata2){
	echo "<td colspan=\"2\">จำนวนอัตรากำลังคน เกินอัตรา ".$quata2-$quata1." อัตรา</td>";
}elseif($quata1>$quata2){
	echo "<td colspan=\"2\">จำนวนอัตรากำลังคน สามารถบรรจุได้ ".$quata1-$quata2." อัตรา</td>";
}else{
	echo "<td colspan=\"2\" style=\"color:green\">จำนวนอัตรากำลังคนเท่ากับจำนวนโควตา $quata1 อัตรา</td>";
}
echo "</table>";

mysql_free_result($result);

?>
