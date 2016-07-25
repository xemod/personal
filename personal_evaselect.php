<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);


include("config.php");
include($KeyPage."_helper.php");
include($KeyPage."_data.php");
$this->DOC->setPathWays(array(
	array(
		'text' => getMenuItem(lurl::dotPage($startupPage))->MenuName,
		'link' => '?mod='.lurl::dotPage($startupPage)
	),
	array(
		'text' => getMenuItem(lurl::dotPage($personalYear))->MenuName,
	),
));

?>
<script>
	JQ(document).ready(function(){

		JQ('#moveRight').click(function(){
			JQ("#ListPersonal > option:selected").appendTo("#ListPersonalSelect");
		});

		JQ('#moveLeft').click(function(){
			JQ("#ListPersonalSelect > option:selected").appendTo("#ListPersonal");
		});

		JQ('#OrgId').change(function(){
			window.location.href = '?mod=<?php echo lurl::dotPage("personal_year");?>&OrgId=' + this.value;
		});

	});

	function Save()
	{
		if(JQ('#OrgId').val()==''){
			jAlert('กรุณาเลือกหน่วยงาน','ระบบแจ้งเตือน');
			return false;
		}

		JQ('#ListPersonalSelect option').attr('selected',true);

		JQ('#adminForm').submit();

	}

</script>
<div class="sysinfo">
  <div class="sysname">รายละเอียดข้อมูล<?php echo $MenuName;?></div>
  <div class="sysdetail">สำหรับแสดงรายละเอียดข้อมูล<?php echo $MenuName;?> </div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter">
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>

<div >

    <table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
  <tr>
    <th width="120" valign="top">รายชื่อบุคลากร</th>
    <td width="8">&nbsp;</td>
    <td valign="top">

    <form action="?mod=<?php echo lurl::dotPage("personal_action");?>&action=saveyear" method="post" name="adminForm" id="adminForm">
    <table width="470" border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td>เลือกรายชื่อผู้ถูกประเมิน</td>
        <td align="center">&gt;&gt;</td>
        <td valign="top"><?php echo $get->getEvaPersonId($_GET["EvaId"]); ?></td>
      </tr>
      <tr>
        <td width="200"><select name="ListPersonal" size="10" multiple="multiple" id="ListPersonal" style="width:200px;">
          <?php
		$Personal = $get->getListPersonal();
		foreach($Personal as $v){
			$Prefix = $get->getListPrefixTxt($v->PrefixId);
		?>
          <option value="<?php echo $v->PersonalId;?>"><?php echo $Prefix.$v->FirstName.' '.$v->LastName;?></option>
          <?php }?>
        </select></td>
        <td width="60" align="center"><input type="button" name="moveRight" id="moveRight" value="  &gt;&gt;  " />
          <br />
<br />
          <input type="button" name="moveLeft" id="moveLeft" value="  &lt;&lt;  " /></td>
        <td valign="top">

        <select name="ListPersonalSelect[]" size="10" multiple="multiple" id="ListPersonalSelect" style="width:200px;">
          <?php
		$Personal = $get->getListPersonalOrg($_REQUEST["OrgId"]);
		foreach($Personal as $v){
			$Prefix = $get->getListPrefixTxt($v->PrefixId);
		?>
          <option value="<?php echo $v->PersonalId;?>"><?php echo $Prefix.$v->FirstName.' '.$v->LastName;?></option>
          <?php  }?>
        </select>

        </td>
      </tr>
    </table>
    </form>


    </td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>&nbsp;</td>
    <td><input type="button" class="btnActive" name="save" id="save" value=" บันทึก " onclick="Save();"  /></td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td></td>
    <td>&nbsp;</td>
  </tr>
</table>

</div>
