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
		'link' => '?mod='.lurl::dotPage($listPage)
	),
	array(
		'text' => 'รายละเอียด',
	),
));

?>
<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter">
  <tr>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th width="150" height="25">คำนำหน้า</th>
    <td width="8">&nbsp;</td>
    <td>
    <?php echo $get->getListPrefixTxt($PrefixId);?>    </td>
    <td width="163" rowspan="6" align="center" valign="top">
    <div style="width:155px; height:150px; overflow:hidden">
    <?php
		if($PictureFile=='') $PictureFile = $noImage;
		else if(!is_file($PathUpload.$PictureFile)) $PictureFile = $noImage;
		if($PictureFile !=$noImage) echo '<a href="'.$PathUpload.$PictureFile.'" rel="prettyPhoto" title="'.$FirstName.' '.$LastName.'">';
		echo '<img src="'.$PathUpload.$PictureFile.'" alt="'.$FirstName.' '.$LastName.'" style="width:155px; height:150px;border:none;" />';
		if($PictureFile !=$noImage) echo '</a>';
	?>
    </div>
    </td>
  </tr>
  
  <tr>
    <th height="25">ชื่อ</th>
    <td>&nbsp;</td>
    <td><?php echo $FirstName;?></td>
  </tr>
  <tr>
    <th height="25">นามสกุล</th>
    <td>&nbsp;</td>
    <td><?php echo $LastName;?></td>
  </tr>
  <tr>
    <th height="25">เพศ</th>
    <td>&nbsp;</td>
    <td><?php if($Gender=="female") echo 'หญิง'; else echo 'ชาย';?>
      </td>
  </tr>
  <tr>
    <th>เลขประจำตัวประชาชน</th>
    <td><span class="require"></span></td>
    <td><?php echo $IDCard;?></td>
    </tr>
  <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th>วันเกิด</th>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo ShowDate($BirthDate);?></td>
  </tr>
  <tr>
    <th>วันที่เข้าทำงาน</th>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo ShowDate($StartWork);?></td>
  </tr>
  <tr>
    <th>ประเภทบุคลากร</th>
    <td>&nbsp;</td>
    <td colspan="2">
    <?php echo $get->getListPersonalTypeTxt($PerTypeId);?>    </td>
  </tr>
  <tr>
    <th valign="top">สถานที่ติดต่อได้</th>
    <td valign="top"><span class="require"></span></td>
    <td colspan="2"><?php echo $Address;?></td>
  </tr>
  <tr>
    <th>ตำบล/แขวง</th>
    <td></td>
    <td colspan="2"><?php echo $District;?></td>
  </tr>
  <tr>
    <th>อำเภอ/เขต</th>
    <td></td>
    <td colspan="2"><?php echo $Zone;?></td>
  </tr>
  <tr>
    <th>จังหวัด</th>
    <td>&nbsp;</td>
    <td colspan="2">
    <?php echo $get->getListProvinceTxt($ProvinceId);?>    </td>
  </tr>
  <tr>
    <th>รหัสไปรษณีย์</th>
    <td><span class="require"></span></td>
    <td colspan="2"><?php echo $PostCode;?></td>
  </tr>
  <tr>
    <th>โทรศัพท์</th>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo $Telephone;?></td>
  </tr>
  <tr>
    <th>โทรสาร</th>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo $Fax;?></td>
  </tr>
  <tr>
    <th>อีเมล</th>
    <td><span class="require"></span></td>
    <td colspan="2"><?php echo $Email;?></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th width="150">&nbsp;</th>
    <td width="8">&nbsp;</td>
    <td colspan="2"><input type="button" name="button4" id="button4" value="กลับไปแก้ไข" class="btnActive" onclick="goPage('?mod=<?php echo lurl::dotPage($addPage);?>&amp;id=<?php echo $_REQUEST['id'];?>');"  />
    <input name="cancel" type="button" value="ย้อนกลับ" class="btn cancle" onclick="history.back(-1);" /></td>
  </tr>
</table>
