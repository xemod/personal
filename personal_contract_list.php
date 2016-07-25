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
		echo '<img src="'.$PathUpload.$PictureFile.'" alt="'.$FirstName.' '.$LastName.'" style="width:80px; height:60px;border:none;" />';
		if($PictureFile !=$noImage) echo '</a>';
	?>

    </td>
    <td valign="top"><a href="?mod=<?php echo lurl::dotPage($viewPage);?>&amp;id=<?php echo $PersonalId;?>"><?php echo $get->getListPrefixTxt($PrefixId);?><?php echo ltxt::highlight_phrase($FirstName.' '.$LastName,$_REQUEST['tsearch']);?></a>

    </td>
     <td align="center"  valign="top" nowrap="nowrap"  >
    <table border="0" cellspacing="1" cellpadding="1" style="border:none">
      <tr>
      	<td style="border:none"> <?php echo icoContract($r);?></td>
        <td style="border:none"><?php echo icoEdit($r);?></td>
        <td style="border:none"><?php echo iconSecure($r);?></td>
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
