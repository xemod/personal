<?php
//error_reporting(E_ALL & ~E_NOTICE);
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
		'text' => $MenuName,
	),
));

function icoEvaluate($r){
	$label = 'กรอกแบบประเมิน';
	$label2 = '&nbsp;';
	global $EvaluatePage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($EvaluatePage)."&id=".$r->EvaMateId."&eva=".$r->EvaPersonalId."'",'ico edit',
		$label2,
		$label
	));
}
?>


<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">แสดงรายชื่อผู้ถูกประเมิน</div>
</div>
<h3>การประเมินความพึงพอใจต่อบุคคลากร สวรส.</h3>
<table width="100%" border="0" class="tbl-list tablesorter"cellspacing="0">
<thead>
  <tr>
    <th class="no" style="width:10px">ลำดับ</th>
    <th align="center" style="width:125px;">รูปภาพ</th>
    <th align="left" >ชื่อพนักงาน</th>
    <th style="width:100px;">ปฏิบัติการ</th>
    <th style="width:10px;">สถานะ</th>
    </tr>
</thead>
<tbody>
<?php
	$i=1;

	if($list["rows"]){
          foreach($list["rows"] as $r ) {
				foreach( $r as $k=>$v){ ${$k} = $v;}?>
  <tr class="active-row">
    <td valign="top" class="center"><?php echo $i ;?>.</td>
    <td align="center" valign="top" class="center">
    <?php

		if($PictureFile=='') $PictureFile = $noImage;
		else if(!is_file($PathUpload.$PictureFile)) $PictureFile = $noImage;
		if($PictureFile !=$noImage) echo '<a href="'.$PathUpload.$PictureFile.'" rel="prettyPhoto" title="'.$FirstName.' '.$LastName.'">';
		echo '<img src="'.$PathUpload.$PictureFile.'" alt="'.$FirstName.' '.$LastName.'" style="width:70px; height:93px;border:none;" />';
		if($PictureFile !=$noImage) echo '</a>';
	?>

    </td>
    <td valign="top">
			<?php echo $get->getListPrefixTxt($PrefixId);?><?=$FirstName.' '.$LastName?>

    </td>
     <td align="center"  valign="top" nowrap="nowrap"  >
    <table border="0" cellspacing="1" cellpadding="1" style="border:none">
      <tr>
      	<td style="border:none"><?php echo icoEvaluate($r);?></td>
      </tr>
    </table>

	</td>
<td align="center" valign="top">
	<?php
		if($get->getChkEvaluatePerson($EvaMateId,$_SESSION["Session_PersonalId"]))
			echo '<img src="images/enabled.gif" border="0" />';
		else
			echo 'รอประเมิน';

	?>


</td>

    </tr>
<?php $i++;}
	}
?>
<?php if($i==1){?>
  <tr class="active-row">
    <td height="100" colspan="5" align="center" valign="middle" class="center">ไม่มีรายการข้อมูล</td>
  </tr>
<?php } ?>
</tbody>
</table>
