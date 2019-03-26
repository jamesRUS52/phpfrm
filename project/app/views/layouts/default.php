<HTML>
    <HEAD>
        <?=$meta;?>
    </HEAD>

<BODY>
    <DIV style="height: auto; overflow: hidden;">
        <DIV style="float: right; width: 200px; margin:0px 10px;">
            <?=new app\widgets\menu\Menu();?>
            <?php if (jamesRUS52\phpfrm\User::getInstance()->hasRoles(['admin','superadmin'])) :?>
                <?=new app\widgets\menu\Menu('admin','layout_admin');?>
            <?php endif; ?>
        </DIV>
        <DIV style="width: auto; overflow: auto; margin: 0px 10px 0px 10px;">
            <?=$content;?>
        </DIV>

</BODY>
</HTML>
