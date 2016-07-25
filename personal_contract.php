<?php
/*error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);*/

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
		'text' => $MenuName.'_จัดการสัญญา'
	),
));

function icoDelete($PersonalId,$ContractId){
  $label = 'ลบ';
  $label2 = '&nbsp;';
  global $actionPage;
  vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
    "javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=deletecontract&ContractId=".$ContractId."&PersonalId=".$PersonalId."')",
    'ico delete',$label2,
    $label
  ));
}

?>

<script language="javascript" type="text/javascript">

/* <![CDATA[ */
__debug = false;

function ValidateForm(f){


     if(JQ('#ContractNo').val() == ''){
      jAlert('กรุณากรอกเลขที่สัญญา',function(){
        JQ('#ContractNo').focus();
      });
      return false;
    }

		if(JQ('#PrefixId option:selected').val() == ''){
			jAlert('กรุณาระบุคำนำหน้า','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PrefixId').focus();
			});
			return false;
		}

		if(JQ('#PerTypeId option:selected').val() == ''){
			jAlert('กรุณาระบุประเภทรูปแบบสัญญา','ระบบตรวจสอบข้อมูล',function(){
				JQ('#PerTypeId').focus();
			});
			return false;
		}

    if(JQ('#BoardTypeId option:selected').val() == ''){
      jAlert('กรุณาระบุมติบอร์ดที่รองรับสัญญาการจ้าง','ระบบตรวจสอบข้อมูล',function(){
        JQ('#BoardTypeId').focus();
      });
      return false;
    }

    if(JQ('#PositionTypeId option:selected').val() == ''){
      jAlert('กรุณาระบุตำแหน่งที่ระบุในสัญญาจ้าง','ระบบตรวจสอบข้อมูล',function(){
        JQ('#PositionTypeId').focus();
      });
      return false;
    }


		return true;
}


function Save(f){
	 var action_url = '?mod=<?=LURL::dotPage($actionPage);?>';
	 var redirec_url = '?mod=<?=LURL::dotPage($personalContract."&id=$PersonalId");?>';
	 goSave(f,'contractsave',action_url,redirec_url);
}

function Detail(f){
	if(ValidateForm(f)){
		var firm_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		goDetail(f,'contractconfirm',firm_url);
	}

}



/*  ]]> */

</script>
<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail"><?php echo $MenuName;?>_จัดการสัญญา</div>
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
<input type="hidden" name="PrefixId" value="<?=$PrefixId?>">
<input type="hidden" name="FirstName" value="<?=$FirstName?>">
<input type="hidden" name="LastName" value="<?=$LastName?>">
<input type="hidden" name="PictureFile" value="<?=$PictureFile?>">
<input type="hidden" name="action" id="action" value="" />
<input type="hidden" name="PersonalId" id="PersonalId" value="<?php echo $_GET['id']?>" />
<h3>เพิ่ม/แก้ไขสัญญา</h3>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span></td>
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
  <?php
    if(isset($_GET[edit])){
      $ContractByID = array();
      $get->getContractById($ContractByID,$_GET[edit]); //print_r($ContractByID);
      if($ContractByID["rows"]){
          foreach($ContractByID["rows"] as $r ) {
            foreach( $r as $k=>$v){ ${$k} = $v;}
      }

      echo "<input type=\"hidden\" name=\"ContractId\" value=\"$ContractId\" />";

    }
   }
  ?>
  <tr>
    <th height="25">เลขที่สัญญา</th>
    <td><span class="require">*</span></td>
    <td><input name="ContractNo" type="text" id="ContractNo" size="20" value="<?=$ContractNo;?>"></td>
    </tr>
  <tr>
    <th height="25">วันที่เริ่มต้นสัญญา</th>
    <td><span class="require">*</span></td>
    <td><?php echo InputCalendar(array('name' => 'StartDate','value' => $StartDate,'size' => '10'));?></td>

    </tr>
  <tr>
    <tr>
    <th height="25">วันที่สิ้นสุดสัญญา</th>
    <td><span class="require">*</span></td>
    <td><?php echo InputCalendar(array('name' => 'EndDate','value' =>$EndDate,'size' => '10'));?></td>
    </tr>
  <tr>
    <th height="25">รูปแบบสัญญา</th>
    <td><span class="require">*</span></td>
    <td>
      <?php $get->getListPersonalType($PerTypeId); ?>  ประเภท
        <select name="SalaryType" id="SalaryType">
          <option value="1" selected="selected">รายเดือน</option>
          <option value="2">รายวัน</option>
        </select>
    </td>
  </tr>
	<tr>
		<th height="25">มติการจ้าง</th>
		<td><span class="require">*</span></td>
		<td>
			<?php $get->getListBoardType($BoardTypeId); ?>
		</td>
		<tr>
			<th height="25">อัตากำลัง</th>
			<td><span class="require">*</span></td>
			<td>
				<?php $get->getListManPower($ManPowerId); ?>
			</td>
		</tr>
	</tr>
  <tr>
    <th height="25">ตำแหน่ง</th>
    <td><span class="require">*</span></td>
    <td>
      <?php $get->getListPositionType($PositionTypeId); ?>
    </td>
  </tr>
    </tr>
    <tr>
    <th height="25">เงินเดือน</th>
    <td></td>
    <td>
      <input type="number" name="Salary" id="Salary" value="<?=$Salary?>" size="10" />
    </td>
  </tr>
  <tr>
    <th>ไฟล์</th>
    <td>&nbsp;</td>
    <td><input type="file" name="ContractFilename" id="ContractFilename" accept="application/pdf">
      &nbsp;<span class="hint"><?=isset($_GET['edit'])?"File :<a href='upload/personal/contract/$ContractFilename' target='new'>$ContractFilename</a>":"ควรเป็นไฟล์ pdf"?>
        <input name="ContractFilenameOld" type="hidden" id="ContractFileOld" value="<?php echo $ContractFilename;?>" />
      </span></td>
  </tr>
  <tr>
    <th valign="top">หมายเหตุ</th>
    <td valign="top"></td>
    <td colspan="2"><textarea name="ContractNote" id="ContractNote" cols="45" rows="5"><?php echo $ContractNote;?></textarea></td>
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
<h3>รายละเอียดสัญญาล่าสุด(เรียงตามลำดับ)</h3>
<table width="100%" border="0" class="tbl-list tablesorter"cellspacing="1">
<thead>
  <tr>
    <th class="no" style="width:10px">ลำดับ</th>
    <th style="width:200px;">เลขที่สัญญา</th>
    <th style="width:100px;">วันที่เริ่มต้นสัญญา</th>
    <th style="width:100px;">วันที่สิ้นสุดสัญญา</th>
    <th style="width:50px;">จำนวน</th>
    <th style="width:130px;">สัญญาคงเหลือ</th>
    <th style="width:100px;">ตำแหน่ง</th>
    <th style="width:100px;">ไฟล์</th>
    <th>หมายเหตุ</th>
    </tr>
</thead>
<tbody>

    <?php
    //GET Contract By Personal ID
    $ContractByPersonalId = array();
    $get->getContractByPersonalId($ContractByPersonalId,$PersonalId);

     $i=1;

      if($ContractByPersonalId["rows"]){
          foreach($ContractByPersonalId["rows"] as $r ) {
            foreach( $r as $k=>$v){ ${$k} = $v;}
    ?>

            <tr>
            <td class="no"><?=$i?></td>
            <td>
              <?php
							if($EnableStatus=="Y"){
                echo "$ContractNo <a class='ico edit' href=\"?mod=".lurl::dotPage($personalContract."&id=$PersonalId&edit=$ContractId")."\">แก้ไข</a> ";
                //echo "<a class='ico delete' href=\"?mod=".lurl::dotPage($actionPage."&PersonalId=$PersonalId&action=deletecontract&ContractId=$ContractId")."\">del</a>";

                echo icoDelete($PersonalId,$ContractId);
							}else{
								echo "$ContractNo"." ";echo icoDelete($PersonalId,$ContractId);
							}
              ?>
            </td>
            <td><?=ShowDate($StartDate)?></td>
            <td><?=ShowDate($EndDate)?></td>
            <td>
              <?php
               echo date("Y",strtotime($EndDate))-date("Y",strtotime($StartDate))." ปี";
              ?>
            </td>
            <td>
              <?php //checke date contract end,,,
              if(strtotime(date('Y-m-d'))>strtotime($EndDate)){
                echo "<span style='color:red'>สิ้นสุดสัญญา</span>";
              }else{
                echo "<span style='color:green'>".$get->dateDiff(date('Y-m-d H:i:s'),$EndDate,3)."</span>";
              }



              ?>
            </td>
            <td><?=$get->getListPositionTypeTxt($PositionTypeId)?></td>
            <td><?="<a href='upload/personal/contract/$ContractFilename' target='new'>$ContractNo</a>";?></td>
            <td><?=htmlspecialchars($ContractNote)?></td>
           </tr>

    <?php
       $i++;
        }
      }

    ?>

</tbody>
</table>

<div id="detailView" style=" display:none"></div>
