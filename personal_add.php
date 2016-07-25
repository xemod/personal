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
		'text' => 'เพิ่มข้อมูล'.$MenuName
	),
));

function fixBirthdate(&$BirthDate){
  $datex = explode('-',$BirthDate);
  $BirthDate = implode('-',array($datex[2],$datex[1],($datex[0]+543)));
  return $BirthDate;
}

?>
<script language="javascript" type="text/javascript">

/* <![CDATA[ */
__debug = false;

function ValidateForm(f){

		if(JQ('#PrefixId option:selected').val() == ''){
			jAlert('กรุณาระบุคำนำหน้า','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PrefixId').focus();
			});
			return false;
		}
		if(JQ('#FirstName').val() == ''){
			jAlert('กรุณาระบุชื่อ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#FirstName').focus();
			});
			return false;
		}
		if(JQ('#LastName').val() == ''){
			jAlert('กรุณาระบุนามสกุล','ระบบตรวจสอบข้อมูล',function(){
				JQ('#LastName').focus();
			});
			return false;
		}

		<?php if(!$PersonalId){?>
		if(JQ('#PictureFile').val() == ''){
			jAlert('กรุณาเลือกไฟล์รูปภาพ','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PictureFile').focus();
			});
			return false;
		}
		<?php }?>

		if(JQ('#PerTypeId option:selected').val() == ''){
			jAlert('กรุณาระบุประเภทบุคลากร','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PerTypeId').focus();
			});
			return false;
		}


		return true;
}


function Save(f){
	 var action_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
	 var redirec_url = '?mod=<?php echo LURL::dotPage($listPage);?>';
	 goSave(f,'save',action_url,redirec_url);
}

function Detail(f){
	if(ValidateForm(f)){
		var firm_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		goDetail(f,'confirm',firm_url);
	}

}


/*  ]]> */

</script>
<div class="sysinfo">
  <div class="sysname">เพิ่มรายการข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับนำเข้าข้อมูลทำการ เพิ่ม/แก้ไขข้อมูล<?php echo $MenuName;?></div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter">
  <tr>
    <td>
        <?php include_once "personal_menu.php";?>
    </td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>" enctype="multipart/form-data" >
<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="PersonalId" id="PersonalId" value="<?php echo $_GET['id']?>" />

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th width="150" height="25">คำนำหน้า</th>
    <td width="8"><span class="require">*</span></td>
    <td>
    <?php $get->getListPrefix($PrefixId);?>    </td>
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
    <td><span class="require">*</span></td>
    <td><input name="FirstName" type="text" id="FirstName" size="30" value="<?php echo $FirstName;?>"></td>
    </tr>
  <tr>
    <th height="25">นามสกุล</th>
    <td><span class="require">*</span></td>
    <td><input name="LastName" type="text" id="LastName" size="30" value="<?php echo $LastName;?>" /></td>
    </tr>
  <tr>
    <th height="25">วันที่เริ่มทำงาน</th>
    <td><span class="require">*</span></td>
    <td><?php echo InputCalendar(array('name' => 'StartWork','value' => $StartWork,'size' => '10'));?></td>
    
  </tr>
  <tr>
    <th height="25">วันที่บรรจุ</th>
    <td><span class="require">*</span></td>
    <td><?php echo InputCalendar(array('name' => 'OperationWork','value' => $OperationWork,'size' => '10'));?></td>
    
  </tr>
    <tr>
    <th height="25">วันที่สิ้นสุดการทำงาน</th>
    <td><span class="require">*</span></td>
    <td><?php echo InputCalendar(array('name' => 'FinalWork','value' => $FinalWork,'size' => '10'));?></td>
    
  </tr>
  <tr>
    <th height="25">เพศ</th>
    <td><span class="require">*</span></td>
    <td><input name="Gender" type="radio" id="Gender" value="male" checked="checked" />
      ชาย
      <input type="radio" name="Gender" id="Gender" value="female" <?php if($Gender=="female") echo 'checked="checked"';?> />
      หญิง</td>
  </tr>
  <tr>
    <th>เลขประจำตัวประชาชน</th>
    <td><span class="require"></span></td>
    <td><input name="IDCard" type="text" id="IDCard" maxlength="13" value="<?php echo $IDCard;?>" />
      <span class="hint">ตัวเลขจำนวน 13 ตัว</span></td>
    </tr>
  <tr>
    <th>รูปภาพ</th>
    <td>&nbsp;</td>
    <td><input type="file" name="PictureFile" id="PictureFile">
      &nbsp;<span class="hint">ควรใช้ไฟล์รูปภาพเท่านั้น ขนาดไม่เกิน 150 X 100 pixel
        <input name="PictureFileOld" type="hidden" id="PictureFileOld" value="<?php echo $PictureFile;?>" />
      </span></td>
    </tr>
  <tr>
    <th>วันเกิด</th>
    <td>&nbsp;</td>
    <td colspan="2"><input type="text" id="BirthDate" name="BirthDate" size"10" value="<?=fixBirthdate($BirthDate)?>" placeholder="วว-ดด-ปปปป" />
  </tr>
<!--  <tr>
    <th>วันที่เข้าทำงาน</th>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo InputCalendar(array('name' => 'StartWork','value' => Date2Slash($StartWork),'size' => '10'));?></td>
  </tr>
  <tr>
    <th>ประเภทบุคลากร</th>
    <td><span class="require">*</span></td>
    <td colspan="2">
    <?php $get->getListPersonalType($PerTypeId);?>    </td>
  </tr> -->
  <tr>
    <th valign="top">สถานที่ติดต่อได้</th>
    <td valign="top"><span class="require"></span></td>
    <td colspan="2"><textarea name="Address" id="Address" cols="45" rows="5"><?php echo $Address;?></textarea></td>
  </tr>
  <tr>
    <th>ตำบล/แขวง</th>
    <td></td>
    <td colspan="2"><input type="text" name="District" id="District" value="<?php echo $District;?>" /></td>
  </tr>
  <tr>
    <th>อำเภอ/เขต</th>
    <td></td>
    <td colspan="2"><input type="text" name="Zone" id="Zone" value="<?php echo $Zone;?>" /></td>
  </tr>
  <tr>
    <th>จังหวัด</th>
    <td>&nbsp;</td>
    <td colspan="2">
    <?php $get->getListProvince($ProvinceId);?>    </td>
  </tr>
  <tr>
    <th>รหัสไปรษณีย์</th>
    <td><span class="require"></span></td>
    <td colspan="2"><input name="PostCode" type="text" id="PostCode" size="5" maxlength="5" value="<?php echo $PostCode;?>" /></td>
  </tr>
  <tr>
    <th>โทรศัพท์</th>
    <td>&nbsp;</td>
    <td colspan="2"><input type="text" name="Telephone" id="Telephone" value="<?php echo $Telephone;?>" /></td>
  </tr>
  <tr>
    <th>โทรสาร</th>
    <td>&nbsp;</td>
    <td colspan="2"><input type="text" name="Fax" id="Fax" value="<?php echo $Fax;?>" /></td>
  </tr>
  <tr>
    <th>อีเมล</th>
    <td><span class="require"></span></td>
    <td colspan="2"><input name="Email" type="text" id="Email" size="40" value="<?php echo $Email;?>" /></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th width="150">&nbsp;</th>
    <td width="8">&nbsp;</td>
    <td colspan="2"><input type="button" class="btnActive" name="save" id="save" value="ดูรายละเอียด" onclick="Detail(JQ('#adminForm'));"  />
      <input type="button" name="button3" id="button3" value=" ยกเลิก " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
  </tr>
</table>

</form>
</div>
<div id="detailView" style=" display:none"></div>
