<div style="width:100%;background-color:red">

        <input type="button" id="button_bio" value="ประวัติทั่วไป" class="<?=$modData=="personal_add"?"btnActive":"btn"?>" onclick="goPage('?mod=<?php echo lurl::dotPage("personal_add&id=$PersonalId");?>')" />
        <input type="button" id="button_contract" value="สัญญาจ้าง" class="<?=$modData=="personal_contract"?"btnActive":"btn"?>" onclick="goPage('?mod=<?php echo lurl::dotPage("personal_contract&id=$PersonalId");?>')" />
        <input type="button" id="button_security" value="สวัสดิการ" class="<?=$modData=="personal_security"?"btnActive":"btn"?>" onclick="goPage('?mod=<?php echo lurl::dotPage("personal_security&id=$PersonalId");?>')" />
        <input type="button" id="button_files" value="การศึกษา" class="<?=$modData=="personal_education"?"btnActive":"btn"?>" onclick="goPage('?mod=<?php echo lurl::dotPage("personal_education&id=$PersonalId");?>')" />
        <input type="button" id="button_files" value="ไฟล์" class="btn" onclick="goPage('?mod=<?php echo lurl::dotPage("files_add?id=$PersonalId");?>')" />
</div>
