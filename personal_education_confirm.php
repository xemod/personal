<?php

/*error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
ini_set("display_errors", 1);*/
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
    <th width="150" height="25">ชื่อ - สกุล</th>
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
    <th>ชื่อสถานที่ศึกษา</th>
    <td>&nbsp;</td>
    <td colspan="2"><?=$Institute?></td>
  </tr>
  <tr>
    <th>ระดับการศึกษา</th>
    <td>&nbsp;</td>
    <td colspan="2">
				  <?=$get->getListEducationLevelTxt($LevelId); ?>
		</td>
  </tr>
  <tr>
    <th valign="top">วุฒิการศึกษา</th>
    <td valign="top"><span class="require"></span></td>
    <td colspan="2"><?=$get->getListEducationDegreeTxt($DegreeId); ?></td>
  </tr>
  <tr>
    <th>ปีที่สำเร็จการศึกษา</th>
    <td></td>
    <td colspan="2"><?=$FinishYear?></td>
  </tr>
	<tr>
    <th width="150">&nbsp;</th>
    <td width="8">&nbsp;</td>
    <td colspan="2"><input type="button" name="button4" id="button4" value="กลับไปแก้ไข" class="btn" onclick="toggleView();" />
      <input type="button" class="btnActive" name="save" id="save" value=" บันทึก " onclick="Save(JQ('#adminForm'));"  />
    <input type="button" name="button3" id="button3" value=" ยกเลิก " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
  </tr>
</table>
