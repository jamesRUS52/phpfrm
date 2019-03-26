<FORM name="assign" method="PSOT" action="<?php print $_SERVER['PHP_SELF']; ?>">
    <TABLE>
        <TR>
            <TD>Тип сущности:</TD>
            <TD>Сущность:</TD>
            <TD>Заказчик:</TD>
            <TD>Проект:</TD>
            <TD>Администратор:</TD>
            <TD></TD>
        </TR>
        <TR>
            <TD>
                <SELECT id="s_entity_type" onchange="FillSelectEntity(this.value);" style="width:150px;">
                <OPTION disabled selected value> -- Выберите тип сущности -- </OPTION>
                <?php foreach ($entitytyoes as $row) : ?>
                    <OPTION value='<?=$row['entitytypeid']?>'><?=$row['entitytypename']?></OPTION>
                <?php endforeach; ?>
                </SELECT>
            </TD>
            <TD>
                <SELECT id="s_entity" disabled="true" onchange="CheckAssign(this.value);" style="width:150px;">
                    <option disabled selected value> -- Выберите сущность -- </option>
                </SELECT>
            </TD>
            <TD>
                <SELECT id="s_owner"  style="width:150px;">
                    <option disabled selected value> -- Выберите владельца -- </option>
                    <?php foreach ($owners as $row) : ?>
                        <OPTION value='<?=$row['ownerid']?>'><?=$row['ownername']?></OPTION>
                    <?php endforeach; ?>
                </SELECT>
            </TD> 
            <TD>
                <SELECT id="s_project"  style="width:150px;">
                    <option disabled selected value> -- Выберите проект -- </option>
                    <?php foreach ($projects as $row) : ?>
                        <OPTION value='<?=$row['projectid']?>'>[<?=$row['projectid']?>] <?=$row['projectname'];?> (<?=$row['manager']?>)</OPTION>
                    <?php endforeach; ?>
                </SELECT>
                
            </TD>
            <TD>
                <SELECT id="s_admin" style="width:150px;" >
                    <option disabled selected value> -- Выберите администратора -- </option>
                    <?php foreach ($admins as $row) : ?>
                        <OPTION value='<?=$row['ownerlogin']?>'><?=$row['ownername']?></OPTION>
                    <?php endforeach; ?>
                </SELECT>
            </TD> 
            <TD>
                <IMG src='/img/ic_note_add_24px.svg' class="svg_button" id='b_saveassign' title='Создать новое назначение' onClick="AddAssign('assign');">
            </TD>
        </TR>
     </TABLE>
<!-- Кнопка сохранения назначения приходит сюда из ajax_check_entity_assign при проверке текущего назначения -->
<Div id="d_content"></DIV>
<Div id="d_message"></DIV>
<!--<p class="message" id="p_message" ></p>        -->
        
</FORM>

<SCRIPT>
$( document ).ready( function() {
        PageLoaded ;
        $("#s_entity_type").select2({dropdownAutoWidth:true});
        $("#s_entity").select2({dropdownAutoWidth:true});
        $("#s_owner").select2({dropdownAutoWidth:true});
        $("#s_project").select2({dropdownAutoWidth:true});
        $("#s_admin").select2({dropdownAutoWidth:true});
       
    });
</SCRIPT>