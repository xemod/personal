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
		'text' => $MenuName.'_จัดการสวัสดิการ'
	),
));

?>

<script language="javascript" type="text/javascript">

/* <![CDATA[ */
__debug = false;

function ValidateForm(f){

		if(JQ('#HealthCoverage option:selected').val() == ''){
			jAlert('กรุณาระบุสวัสดิการรักษาพยาบาล','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PrefixId').focus();
			});
			return false;
		}

		if(JQ('#PensionType option:selected').val() == ''){
			jAlert('กรุณาระบุสวัสดิการเงินทุนสำรอง','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PerTypeId').focus();
			});
			return false;
		}
		return true;
}


function Save(f){
	if(ValidateForm(f)){
	 var action_url = '?mod=<?=LURL::dotPage($actionPage);?>';
	 var redirec_url = '?mod=<?=LURL::dotPage($security."&id=$PersonalId");?>';
	 goSave(f,'securesave',action_url,redirec_url);
 }
}



/*  ]]> */
</script>



<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail"><?php echo $MenuName;?>_จัดการสวัสดิการ</div>
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
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>" enctype="multipart/form-data">

  <?php
  //if data exist
  $SecureData = array();
  $get->getSecureByContractNo($SecureData,$get->getLastestContractNoByPersonalid($_GET['id'])); //get data if exist with contractname

  //chck สัญญา
  if($get->getLastestContractNoByPersonalid($_GET['id'])=='')
  {
    $ContractNo=false;
    $buttonname="ส่งข้อมูล";
  }else{
    $ContractNo=$get->getLastestContractNoByPersonalid($_GET['id']);
    $buttonname="แก้ไข";
  }

  if($SecureData['total']>0){
    $tmp=(array)$SecureData['rows'][0];//casting one column ขี้เกียจวนลูป ชื่อตัวแปรซ็ำ
    $HealthCoverage=$tmp['HealthCoverage'];
    $PensionType=$tmp['PensionType'];
    $GroupInsure=$tmp['GroupInsure'];
    $ChildernEdu=$tmp['ChildernEdu'];
    $HealthCheck=$tmp['HealthCheck'];
    $Uniform=$tmp['Uniform'];
    $CallFee=$tmp['CallFee'];
    $Bonus=$tmp['Bonus'];
    $GetHurt=$tmp['GetHurt'];
    $VisitGift=$tmp['VisitGift'];
    $PublicHazard=$tmp['PublicHazard'];
    $Funeral=$tmp['Funeral'];
    $Retire=$tmp['Retire'];
    $Layoff=$tmp['Layoff'];


    echo '<input type="hidden" name="SecurityId" value="'.$tmp['SecurityId'].'">';
  }
  ?>
<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="PersonalId" id="PersonalId" value="<?php echo $_GET['id']?>" />
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td>
      <h3>แก้ไข/เพิ่มเติม สวัสดิการของสัญญาล่าสุด</h3>
      <span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th width="150" height="25">ชื่อ - สกุล / ผู้รับจ้าง</th>
    <td width="8"></td>
    <td>
    <?php
      echo $get->getListPrefixTxt($PrefixId)." $FirstName $LastName";
    ?>
      </td>
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
    <th height="25">เลขที่สัญญาปัจจุบัน</th>
    <td> </td>
    <td>
      <input disabled="disabled"  size="20" value="<?=$ContractNo?>" />
      <input name="ContractNo" type="hidden" value="<?=$ContractNo?>" />
    </td>
    </tr>
  <tr>
    <th height="25">สวัสดิการ รักษาพยาบาล</th>
    <td><span class="require">*</span></td>
    <td>
      <?php $get->getListHealthCoverage($HealthCoverage); ?>
    </td>
    </tr>
  <tr>
    <tr>
    <th height="25">สวัสดิการ กองทุน/บำเน็จ</th>
    <td><span class="require">*</span></td>
    <td>
      <?php $get->getListPensionType($PensionType); ?>
    </td>

  <tr>
    <th height="25">สวัสดิการ ประกันชีวิตหมู่</th>
    <td> </td>
    <td>
      <input type="checkbox" name="GroupInsure"  value="1" <?=$GroupInsure>0?"checked=\"checked\"":""?> />
    </td>
  </tr>
    <tr>
    <th height="25">สวัสดิการ ช่วยเหลือการศึกษาบุตร</th>
    <td> </td>
    <td>
      <input type="checkbox" name="ChildernEdu"  value="1" <?=$ChildernEdu>0?"checked=\"checked\"":""?> />
    </td>
  </tr>
  </tr>
    <tr>
    <th height="25">สวัสดิการ ตรวจสุขภาพประจำปี</th>
    <td> </td>
    <td>
      <input type="checkbox" name="HealthCheck"  value="1" <?=$HealthCheck>0?"checked=\"checked\"":""?> />
    </td>
  </tr>
    </tr>
    <tr>
    <th height="25">สวัสดิการ ชุดยูนิฟอร์ม</th>
    <td> </td>
    <td>
      <input type="checkbox" name="Uniform"  value="1" <?=$Uniform>0?"checked=\"checked\"":""?> />
    </td>
  </tr>
  <tr>
<th height="25">สวัสดิการ ทดแทนเจ็บป่วยจากการปฏิบัติหน้าที่</th>
<td> </td>
<td>
  <input type="checkbox" name="GetHurt"  value="1" <?=$GetHurt>0?"checked=\"checked\"":""?> />
</td>
</tr>
<tr>
  <th height="25">สวัสดิการ ของเยี่ยม</th>
  <td> </td>
  <td>
    <input type="checkbox" name="VisitGift"  value="1" <?=$VisitGift>0?"checked=\"checked\"":""?> />
  </td>
</tr>
  <th height="25">สวัสดิการ เงินช่วยเหลือสาธารณภัย</th>
  <td> </td>
  <td>
    <input type="checkbox" name="PublicHazard"  value="1" <?=$PublicHazard>0?"checked=\"checked\"":""?> />
  </td>
</tr>

<tr>
  <th height="25">สวัสดิการ เงินช่วยเหลือค่าทำศพ</th>
  <td> </td>
  <td>
    <input type="checkbox" name="Funeral"  value="1" <?=$Funeral>0?"checked=\"checked\"":""?> />
  </td>
</tr>
<tr>
  <th height="25">สวัสดิการ รางวัลในโอกาสเกษียนอายุ</th>
  <td> </td>
  <td>
    <input type="checkbox" name="Retire"  value="1" <?=$Retire>0?"checked=\"checked\"":""?> />
  </td>
</tr>
<tr>
  <th height="25">สวัสดิการ ค่าชดเชยจากการถูกเลิกจ้าง</th>
  <td> </td>
  <td>
    <input type="checkbox" name="Layoff"  value="1" <?=$Layoff>0?"checked=\"checked\"":""?> />
  </td>
</tr>
  <tr>
    <th height="25">สวัสดิการ ค่าโทรศัพท์</th>
    <td> </td>
    <td>
      <input type="checkbox" name="CallFee"  value="1" <?=$CallFee>0?"checked=\"checked\"":""?> />
    </td>
  </tr>
    <tr>
    <th height="25">Bonus</th>
    <td> </td>
    <td>
      <input type="checkbox" name="Bonus"  value="1" <?=$Bonus>0?"checked=\"checked\"":""?> />
    </td>
  </tr>

  <tr>
    <th width="150">&nbsp;</th>
    <td width="8">&nbsp;</td>
    <td colspan="2"><input type="button"  name="save" id="save" value="<?=$buttonname?>" onclick="Save(JQ('#adminForm'));"
      <?=$ContractNo?"class=\"btnActive\"":"disabled=\"disabled\" class=\"btn\" "?>
    />
      <input type="button" name="button3" id="button3" value=" ยกเลิก " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
  </tr>
</table>

</form>
</div>
<div id="detailView" style=" display:none"></div>
