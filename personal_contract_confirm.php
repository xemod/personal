<?php
include("config.php");
include($KeyPage."_data.php");

	foreach($_REQUEST as $k=>$v){
		${$k} = $v;
	}

?>

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th width="150" height="25">ชื่อ - สกุล / ผู้รับจ้าง</th>
    <td width="8">&nbsp;</td>
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
    <th>ระยะสัญญา</th>
    <td>&nbsp;</td>
    <td colspan="2">ระยะเวลา <?=date("Y",strtotime($EndDate))-date("Y",strtotime($StartDate))?> ปี เริ่มตั้งแต่ <?=ShowDate($StartDate);?> ถึงวันที่ <?=ShowDate($EndDate);?></td>
  </tr>
  <tr>
    <th>รูปแบบสัญญา</th>
    <td>&nbsp;</td>
    <td colspan="2">
    <?php echo $get->getListPersonalTypeTxt($PerTypeId);?>  ประเภท  <?=$SalaryType==1?"รายเดือน":"รายวัน";?></td>
  </tr>
  <tr>
    <th valign="top">ตำแหน่ง</th>
    <td valign="top"><span class="require"></span></td>
    <td colspan="2"><?=$get->getListPositionTypeTxt($PositionTypeId);?></td>
  </tr>
  <tr>
    <th>มติบอร์ด</th>
    <td></td>
    <td colspan="2">
			<?php
			foreach ($BoardTypeId as $value){
				 echo $get->getListBoardTypeTxt($value)."<br>";
			}
			?>
		 </td>
  </tr>
	<tr>
		<th>อัตากำลัง</th>
		<td></td>
		<td colspan="2">
			<?=$get->getListManPowerTypeTxt($ManPowerId);?>
		 </td>
	</tr>
  <tr>
    <th>เงินเดือน</th>
    <td></td>
    <td colspan="2"><?=$Salary==""?"-":number_format($Salary); ?> บาท</td>
  </tr>
   <tr>
    <th>File</th>
    <td> </td>
    <td colspan="2">
    <?php
       if(is_uploaded_file($_FILES['ContractFilename']['tmp_name']))
          echo "Received <span style='color:green'>".$_FILES['ContractFilename']['name']."</span> - size is ".$_FILES['ContractFilename']['size']." Byte";
       else
          echo "Received <span style='color:green'>".$_POST['ContractFilenameOld']."</span>";
    ?>
    </td>
  </tr>
  <tr>
    <th>หมายเหตุ</th>
    <td>&nbsp;</td>
    <td colspan="2"><?=strip_tags($ContractNote)?></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <th width="150">&nbsp;</th>
    <td width="8">&nbsp;</td>
    <td colspan="2"><input type="button" name="button4" id="button4" value="กลับไปแก้ไข" class="btn" onclick="toggleView();" />
      <input type="button" class="btnActive" name="save" id="save" value=" บันทึก " onclick="Save(JQ('#adminForm'));"  />
    <input type="button" name="button3" id="button3" value=" ยกเลิก " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
  </tr>
</table>
