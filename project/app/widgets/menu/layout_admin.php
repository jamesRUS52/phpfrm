<p style='text-align:center;margin:10px 10px 10px 10px;;color:#52023A;font-weight:bold;'>Инструменты администратора</p>
<DIV class=menu_admin>
    <?php foreach ($items as $name => $item) :?>
        <?php if (jamesRUS52\phpfrm\User::getInstance()->hasRoles($item['roles'])) :?>
            <a class='menu_admin' href="<?=$item['url'];?>"><?=$name;?></a>
        <?php endif; ?>
    <?php endforeach;?>
</DIV>