<?php
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

function icoActive($r){
	global $actionPage;
	$onChange = 'onChange="self.location=\'?mod='.LURL::dotPage($actionPage).'&action=changestatus&PersonalId='.$r->PersonalId.'&EnableStatus=\'+this.value"';
	$html = clssHTML::yesnoSelectList('EnableStatus',$onChange,(strtolower($r->EnableStatus) == 'y' ? 1 : 0),'แสดง','ไม่แสดง');
	return $html;
}

function icoEdit($r){
	$label = 'แก้ไขประวัติ';
	$label2 = '&nbsp;';
	global $addPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($addPage)."&id=".$r->PersonalId."'",'ico edit',
		$label2,
		$label
	));
}

function icoDelete($r){
	$label = 'ลบทิ้ง';
	$label2 = '&nbsp;';
	global $actionPage;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=delete&PersonalId=".$r->PersonalId."')",
		'ico delete',		$label2,
		$label
	));
}


function icoContract($r){
	$label = 'เพิ่ม/แก้ไขสัญญา';
	$label2 = '&nbsp;';
	global $personalContract;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($personalContract)."&id=".$r->PersonalId."'",'ico form',
		$label2,
		$label
	));
}

function iconSecure($r){
	$label = 'จัดการสวัสดิการ';
	$label2 = '&nbsp;';
	global $security;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($security)."&id=".$r->PersonalId."'",'ico form',
		$label2,
		$label
	));
}

function icoEducation($r){
	$label = 'เพิ่ม/แก้ไขการศึกษา';
	$label2 = '&nbsp;';
	global $Education;
	vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
		"javascript:self.location='?mod=".LURL::dotPage($Education)."&id=".$r->PersonalId."'",'ico attach',
		$label2,
		$label
	));
}


?>

<script language="javascript" type="text/javascript">
/* <![CDATA[ */

	function Search(){
		var tsearch=JQ('#tsearch').val();
		window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&tsearch="+ tsearch;
	}

	JQ(document).ready(function(){
		JQ('#BNGroupID').change(function(){
			window.location.href="?mod=<?php echo LURL::dotPage($listPage)?>&BNGroupID="+ this.value;
		});
	});

/* ]]> */
</script>

<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายการข้อมูล<?php echo $MenuName;?></div>
</div>
<div class="boxfilter" id="boxFilter">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <td><input type="button" name="button4" id="button4" value="เพิ่มรายการ" class="btnActive" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>');" />
      <input type="button" name="button" id="button" value="รีเฟรช" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
      <td width="20%" align="right"><input type="button" name="button3" id="button3" value="  ค้นหา  " class="btn" onclick="JQ('#boxSearch').slideToggle('slow');" /></td>
    </tr>
  </table>
</div>
<form name="searchForm" id="SearchForm" method="post">
<div id="boxSearch" class="boxsearch" style="display:<?php echo 'none';?>">
  <table width="60%" border="0" align="center" cellpadding="0" cellspacing="5" >
    <tr>
      <td width="15%" align="left"><strong>คำค้น : </strong></td>
      <td width="40" colspan="3"><input name="tsearch" id="tsearch" type="text" class="input-search" size="30" value="<?php echo $_REQUEST['tsearch']?>" />
        <input id="search2" name="search2" type="button" value="  ค้นหา  " class="btnActive"   onclick="Search();" />
        <input type="button" name="button5" id="button2" class="btn" value=" ยกเลิก " onclick="JQ('#boxSearch').hide();JQ('#boxFilter').show();" /></td>
    </tr>
  </table>

</div></form>
<div class="cms-box-search">

  <?php if($_REQUEST['tsearch']){?>
ผลการค้นหา <span style="color:#FF6600; font-weight:bold;">&quot;<?php echo $_REQUEST['tsearch'];?>&quot;</span> พบจำนวน <span style="color:#FF6600; font-weight:bold;"><?php echo $list['total'];?></span> รายการ
<?php }?>
</div>
<script type="text/javascript" language="javascript" id="js">
/* <![CDATA[ */
JQ(document).ready(function() {
	JQ("table").tablesorter({
		headers: {
			0: {sorter: false},
			1: {sorter: false},
			4: {sorter: false},
			3: {sorter: false}
		}
	});
});
/* ]]> */
</script>
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
    <td valign="top"><a href="?mod=<?php echo lurl::dotPage($viewPage);?>&amp;id=<?php echo $PersonalId;?>"><?php echo $get->getListPrefixTxt($PrefixId);?><?php echo ltxt::highlight_phrase($FirstName.' '.$LastName,$_REQUEST['tsearch']);?></a>

    </td>
     <td align="center"  valign="top" nowrap="nowrap"  >
    <table border="0" cellspacing="1" cellpadding="1" style="border:none">
      <tr>

        <td style="border:none"><?php echo icoEdit($r);?></td>
				<td style="border:none"> <?php echo icoContract($r);?></td>
        <td style="border:none"><?php echo iconSecure($r);?></td>
				<td style="border:none"> <?php echo icoEducation($r);?></td>
        <td style="border:none"> <?php echo icoDelete($r);?></td>
      </tr>
    </table>     </td>
    <td align="center" valign="top"><?php echo icoActive($r);?></td>

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
<div class="cms-box-navpage">
<?php echo NavPage(array('total'=>$list['total']));?>
</div>
