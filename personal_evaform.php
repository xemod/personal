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
		'text' => $MenuName
	),
));



?>

<script language="javascript" type="text/javascript">

/* <![CDATA[ */
__debug = false;

function ValidateForm(){
		if(JQ('#q1 :selected').text() =='--กรุณาเลือก--')
			return false;
		if(JQ('#q2 :selected').text() =='--กรุณาเลือก--')
			return false;
		if(JQ('#q3 :selected').text() =='--กรุณาเลือก--')
			return false;
		if(JQ('#q4 :selected').text() =='--กรุณาเลือก--')
			return false;
		if(JQ('#q5 :selected').text() =='--กรุณาเลือก--')
			return false;
		if(JQ('#q6 :selected').text() =='--กรุณาเลือก--')
			return false;
		if(JQ('#q7 :selected').text() =='--กรุณาเลือก--')
			return false;
		if(JQ('#q8 :selected').text() =='--กรุณาเลือก--')
			return false;
		if(JQ('#q9 :selected').text() =='--กรุณาเลือก--')
			return false;
		if(JQ('#q10 :selected').text() =='--กรุณาเลือก--')
			return false;

		return true;
}


function Save(f){
	if(ValidateForm(f)){
	 		var action_url = '?mod=<?=LURL::dotPage($actionPage);?>';
	 		var redirec_url = '?mod=<?=LURL::dotPage("personal_evaluate");?>';
	 		goSave(f,'evaluatesave',action_url,redirec_url);
	}else{
		jAlert('โปรดระบุระดับความพึงพอใจให้ครบทุกข้อก่อนส่ง','ระบบตรวจสอบข้อมูล',function(){
			JQ('#adminForm').focus();
		});
	}
}


/*  ]]> */

</script>
<div class="sysinfo">
  <div class="sysname">แบบประเมิน </div>
  <div class="sysdetail">พนักงานภายใน สวรส.</div>
</div>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="boxfilter">
  <tr>
    <td>
        แบบประเมินความพึงพอใจ ที่มีต่อ <?=$get->getListPrefixTxt($PrefixId)." ".$FirstName." ".$LastName?> ปีงบประมาณ 2558
    </td>
    <td align="right"><input type="button" name="button" id="button" value="ย้อนกลับ" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage($listPage);?>')" /></td>
  </tr>
</table>

<div id="formView">
<form id="adminForm" name="adminForm" method="post" action="?mod=<?php echo LURL::dotPage($actionPage);?>" enctype="multipart/form-data">
<input type="hidden" name="action" id="action" value="" />


<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td>
				<p>แบบประเมินฉบับนี้มีวัตถุประสงค์เพื่อนำความคิดเห็นของผู้รับบริการไปใช้ในการปรับปรุงและพัฒนาการ ให้บริการให้มีคุณภาพดียิ่งขึ้นไป  จึงขอความร่วมมือทุกท่านในการตอบแบบประเมินความพึงพอใจฉบับนี้ </p>
				<p>
					<strong>คำชี้แจง</strong>
					<ol>
						<li>ข้อมูลจากการแสดงความคิดเห็นของท่านจะไม่มีผลต่อการปฏิบัติงานของท่าน</li>
						<li>ผลการวิเคราะห์ข้อมูลจะนำไปพัฒนาและปรับปรุงด้านดัชนีบ่งชี้คุณภาพเกณฑ์การตัดสิน  การประเมินผลจะ   ดำเนินงานในภาพรวมเท่านั้น ดังนั้นการตอบแบบประเมินความพึงพอใจตามความเป็นจริง จะทำให้สถาบันฯ
   สามารถนำไปปรับปรุงและพัฒนาระบบการทำงานให้มีประสิทธิภาพมากยิ่งขึ้น</li>
 				</ol>
			</p>
			<p style="color:red">
				<strong>ระดับความพึงพอใจ 5 ระดับ คือ</strong><br/>
				<ul style="list-style-type:none;padding-left:30px">
				<li>5	=	พึงพอใจมาก</li>
				<li>4 =	พึงพอใจ</li>
				<li>3	=	ปานกลาง</li>
				<li>2	=	ไม่พอใจ</li>
				<li>1	=	ควรปรับปรุง</li>
				<li>N/A   = 	ไม่สามารถให้ข้อมูลได้</li>
			</ul>
			<br />

<span style="color:red">***ในกรณีเลือกระดับความพึงพอใจ 1 = ควรปรับปรุง ให้ผู้ประเมินระบุข้อเสนอแนะ เพื่อการปรับปรุงและพัฒนางานบริการในอนาคต</span>
			</p>

			<span>กรุณาใส่ข้อมูลตรงช่องที่มีเครื่องหมาย </span><span class="require">*</span>
		</td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="1" class="tbl-view">
	<tr>
		<thead>
			<th style="text-align:center"  height="35">หัวข้อ</th>
			<td style="text-align:center" colspan="3">ระดับความพึงพอใจ</td>
		</thead>
	</tr>
	<tr>
    <th  height="30">1. มีกระบวนการปฏิบัติงานเป็นไปตามขั้นตอนและ เป็นระบบ</th>
    <td width="8"><span class="require">*</span></td>
    <td>
			<select name="q1" id="q1">
				<option value="">--กรุณาเลือก--</option>
				<option value="0">N/A</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
    </td>
    <td width="150" rowspan="6" align="center" valign="top">
    <div style="width:155px; height:150px; overflow:hidden">
    <?php
		if($PictureFile=='') $PictureFile = $noImage;
		else if(!is_file($PathUpload.$PictureFile)) $PictureFile = $noImage;
		if($PictureFile !=$noImage) echo '<a href="'.$PathUpload.$PictureFile.'" rel="prettyPhoto" title="'.$FirstName.' '.$LastName.'">';
		echo '<img src="'.$PathUpload.$PictureFile.'" alt="'.$FirstName.' '.$LastName.'" style="width:112px; height:150px;border:none;" />';
		if($PictureFile !=$noImage) echo '</a>';
	  ?>
    </div>
    </td>
  </tr>
	<tr>
		<th  height="30">2.  มีความรู้ ความสามารถ ความชำนาญในงานที่รับผิดชอบ สามารถให้คำปรึกษา แนะนำ แก่ผู้อื่นได้อย่างชัดเจน และตรงประเด็น</th>
		<td><span class="require">*</span></td>
		<td colspan="2">
				<select name="q2" id="q2">
					<option value="">--กรุณาเลือก--</option>
					<option value="0">N/A</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
		</td>
	</tr>
	<tr>
		<th  height="30">3. ตั้งใจรับฟังปัญหา และให้บริการด้วยความเต็มใจ กระตือรือร้นในการให้บริการ </th>
		<td><span class="require">*</span></td>
		<td colspan="2">
				<select name="q3" id="q3">
					<option value="">--กรุณาเลือก--</option>
					<option value="0">N/A</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
		</td>
	</tr>
	<tr>
		<th  height="30">4.มีการทำงานเป็นทีม ช่วยเหลือซึ่งกันและกัน ร่วมแก้ไขปัญหาและให้ความร่วมมือกับเพื่อนร่วมงาน</th>
		<td><span class="require">*</span></td>
			<td colspan="2">
				<select name="q4" id="q4">
					<option value="">--กรุณาเลือก--</option>
					<option value="0">N/A</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
		</td>
	</tr>

	<tr>
	  <th  height="30">5.มีการแลกเปลี่ยนเรียนรู้ และถ่ายทอดประสบการณ์ให้กับเพื่อนร่วมงาน 	</th>
	  <td><span class="require">*</span></td>
	  	<td colspan="2">
	      <select name="q5" id="q5">
	        <option value="">--กรุณาเลือก--</option>
	        <option value="0">N/A</option>
	        <option value="1">1</option>
	        <option value="2">2</option>
	        <option value="3">3</option>
	        <option value="4">4</option>
	        <option value="5">5</option>
	      </select>
	  </td>
	</tr>
	<tr>
	  <th  height="30">6.มีส่วนร่วมในการพัฒนาองค์กร เสียสละ ถือประโยชน์ส่วนรวม </th>
	  <td><span class="require">*</span></td>
		<td colspan="2">
	      <select name="q6" id="q6">
	        <option value="">--กรุณาเลือก--</option>
	        <option value="0">N/A</option>
	        <option value="1">1</option>
	        <option value="2">2</option>
	        <option value="3">3</option>
	        <option value="4">4</option>
	        <option value="5">5</option>
	      </select>
	  </td>
	</tr>
	<tr>
	  <th  height="30">7.มีความใฝ่รู้ และพัฒนาตนเองอย่างต่อเนื่อง แสวงหาความรู้เพิ่มเติมที่เป็นประโยชน์ต่อองค์กร </th>
	  <td><span class="require">*</span></td>
	<td colspan="2">
	      <select name="q7" id="q7">
	        <option value="">--กรุณาเลือก--</option>
	        <option value="0">N/A</option>
	        <option value="1">1</option>
	        <option value="2">2</option>
	        <option value="3">3</option>
	        <option value="4">4</option>
	        <option value="5">5</option>
	      </select>
	  </td>
	</tr>
	<tr>
	  <th  height="30">8.มีมนุษย์สัมพันธ์ดี สุขุม สามารถควบคุมอารมณ์ได้ดี เมื่ออยู่ในภาวะกดดัน 	</th>
	  <td><span class="require">*</span></td>
		<td colspan="2">
	      <select name="q8" id="q8">
	        <option value="">--กรุณาเลือก--</option>
	        <option value="0">N/A</option>
	        <option value="1">1</option>
	        <option value="2">2</option>
	        <option value="3">3</option>
	        <option value="4">4</option>
	        <option value="5">5</option>
	      </select>
	  </td>
	</tr>
	<tr>
	  <th  height="30">9.มีการสื่อสารที่สร้างสรรค์ สร้างความตั้งใจ ความสามัคคีในองค์กร </th>
	  <td><span class="require">*</span></td>
		<td colspan="2">
	      <select name="q9" id="q9">
	        <option value="">--กรุณาเลือก--</option>
	        <option value="0">N/A</option>
	        <option value="1">1</option>
	        <option value="2">2</option>
	        <option value="3">3</option>
	        <option value="4">4</option>
	        <option value="5">5</option>
	      </select>
	  </td>
	</tr>
	<tr>
	  <th  height="30">10.มีความอดทน ขยันหมั่นเพียรในการทำงาน </th>
	  <td><span class="require">*</span></td>
		<td colspan="2">
	      <select name="q10" id="q10">
	        <option value="">--กรุณาเลือก--</option>
	        <option value="0">N/A</option>
	        <option value="1">1</option>
	        <option value="2">2</option>
	        <option value="3">3</option>
	        <option value="4">4</option>
	        <option value="5">5</option>
	      </select>
	  </td>
	</tr>
	<tr>
		<td colspan="5s" style="padding-left:10px">
				<textarea name="Sugeestion" id="Suggestion" rows="4" cols="50" placeholder="ในกรณีเลือกระดับความพึงพอใจ 1 ควรปรับปรุง ให้ผู้ประเมินระบุข้อเสนอแนะ เพื่อการปรับปรุงและพัฒนางานบริการในอนาคต"></textarea>
		</td>
	</tr>
  <tr>
		<td>
			<input type="hidden" name="EvaMateId" value="<?=$_GET["id"]?>" />
			<input type="hidden" name="PersonalId" value="<?=$_SESSION["Session_PersonalId"]?>" />
			<input type="button" class="btnActive" name="save" id="save" value="ส่งแบบฟอร์ม" onclick="Save(JQ('#adminForm'));"  />
      <input type="button" name="button3" id="button3" value=" ยกเลิก " class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage("personal_evaluate");?>')" /></td>
	<td colspan="3"></td>
	</tr>
</table>

</form>
</div>


<div id="detailView" style=" display:none"></div>
