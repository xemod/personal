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
		'text' => $MenuName.'_การศึกษา'
	),
));

function icoDelete($PersonalId,$EducationId){
  $label = 'ลบ';
  $label2 = '&nbsp;';
  global $actionPage;
  vprintf('<a href="%s" class="%s" title="%s"><span>%s</span></a>',array(
    "javascript: toDelete('?mod=".LURL::dotPage($actionPage)."&action=educationdelete&EducationId=".$EducationId."&PersonalId=".$PersonalId."')",
    'ico delete',$label2,
    $label
  ));
}

?>

<script language="javascript" type="text/javascript">

/* <![CDATA[ */
__debug = false;

function ValidateForm(f){


     if(JQ('#Institute').val() == ''){
      jAlert('กรุณากรอกชื่อสถานที่ศึกษา',function(){
        JQ('#Institute').focus();
      });
      return false;
    }

		if(JQ('#LevelId option:selected').val() == ''){
			jAlert('ระบุระดับการศึกษา','ระบบตรวจสอบข้อมูล',function(){
				JQ('#LevelId').focus();
			});
			return false;
		}

		if(JQ('#Subject').val() == ''){
			jAlert('ระบุสาขาวิชา','ระบบตรวจสอบข้อมูล',function(){
				JQ('#Subject').focus();
			});
			return false;
		}

		if(JQ('#FinishYear').val() == ''){
		 jAlert('กรุณากรอกปีที่จบการศึกษา',function(){
			 JQ('#FinishYear').focus();
		 });
		 return false;

	 }
		return true;
}


function Save(f){
	 var action_url = '?mod=<?=LURL::dotPage($actionPage);?>';
	 var redirec_url = '?mod=<?=LURL::dotPage("personal_education&id=$PersonalId");?>';
	 goSave(f,'educationsave',action_url,redirec_url);
}

function Detail(f){
	if(ValidateForm(f)){
		var firm_url = '?mod=<?php echo LURL::dotPage($actionPage);?>';
		goDetail(f,'educationconfirm',firm_url);
	}

}



/*  ]]> */

</script>
<div class="sysinfo">
  <div class="sysname"><?php echo $MenuName;?></div>
  <div class="sysdetail"><?php echo $MenuName;?>_การศึกษา</div>
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
<?php
	if(isset($_GET[edit])){
		$EducationById = array();
		$get->getEducationById($EducationById,$_GET[edit]); //print_r($EducationById);
		if($EducationById["rows"]){
				foreach($EducationById["rows"] as $r ) {
					foreach( $r as $k=>$v){ ${$k} = $v;}
		}

		echo "<input type=\"hidden\" name=\"EducationId\" value=\"$EducationId\" />";

	}
 }
?>

<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td><span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span>
		<?php
			    if(isset($_GET['edit'])){
						echo "<h3 style=\"color:red;\" class=\"blink_me\"> !!ท่านกำลังแก้ไขข้อมูลการศึกษา</h3>";
					}
		?>
		</td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th width="150" height="25">ชื่อ - สกุล</th>
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
    if(isset($_GET['edit'])){
      $EducationByID = array();
      $get->getEducationById($EducationByID,$_GET['edit']); //print_r($EducationByID);
      if($EducationByID["rows"]){
          foreach($EducationByID["rows"] as $r ) {
            foreach( $r as $k=>$v){ ${$k} = $v;}
      }

    }
   }
  ?>

	<tr>
		<th height="25">สถาบันการศึกษา</th>
		<td><span class="require">*</span></td>
		<td><input type="text" name="Institute" id="Institute" value="<?=$Institute?>" maxlength="150"/></td>
	</tr>
	<tr>
		<th height="25">สาขาวิชา</th>
		<td><span class="require">*</span></td>
		<td><input type="text" name="Subject" id="Subject" value="<?=$Subject?>" maxlength="150"/></td>
	</tr>

  <tr>
    <th height="25">ระดับการศึกษา</th>
    <td><span class="require">*</span></td>
    <td>
      <?php $get->getListEducationLevel($LevelId); ?>
    </td>
  </tr>
	<tr>
		<th height="25">วุฒิการศึกษา</th>
		<td></td>
		<td>
			<?php $get->getListEducationDegree($DegreeId); ?>
		</td>
	</tr>
	<tr>
		<th height="25">ปีที่สำเร็จการศึกษา(พ.ศ.)</th>
		<td><span class="require">*</span></td>
		<td><input type="text" name="FinishYear" id="FinishYear" value="<?=$FinishYear?>" maxlength="4" size="4" /> </td>
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
<table width="100%" border="0" class="tbl-list tablesorter"cellspacing="1">
<thead>
  <tr>
    <th class="no" style="width:10px">ลำดับ</th>
    <th>สถาบัน/โรงเรียน</th>
		<th style="width:200px;">สาขาวิชา</th>
    <th style="width:100px;">ระดับการศึกษา</th>
    <th style="width:100px;">วุฒิการศึกษา</th>
		<th style="width:100px;">ปีที่จบ</th>
    <th>action</th>
    </tr>
</thead>
<tbody>

    <?php
    //GET Contract By Personal ID
    $EducationByPersonalId = array();
    $get->getEducationByPersonalId($EducationByPersonalId,$PersonalId);

     $i=1;

      if($EducationByPersonalId["rows"]){
          foreach($EducationByPersonalId["rows"] as $r ) {
            foreach( $r as $k=>$v){ ${$k} = $v;}
    ?>

            <tr>
            <td class="no"><?=$i?></td>
            <td><?=$Institute?></td>
            <td><?=$Subject?></td>
            <td><?=$get->getListEducationLevelTxt($LevelId)?></td>
            <td><?=$get->getListEducationDegreeTxt($DegreeId)?></td>
            <td><?=$FinishYear?></td>
						<td>
<?
echo "<a class='ico edit' href=\"?mod=".lurl::dotPage("personal_education&id=$PersonalId&edit=$EducationId")."\">แก้ไข</a> ";
echo icoDelete($PersonalId,$EducationId);
?>
						</td>
           </tr>

    <?php
       $i++;
        }
      }

    ?>

</tbody>
</table>

<div id="detailView" style=" display:none"></div>
