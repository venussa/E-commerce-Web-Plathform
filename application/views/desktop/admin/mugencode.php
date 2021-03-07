<?php if(is_mobile() == true){ ?>
	Anda bisa mengaksesnya hanya melalui perangkat desktop
<?php }else{ ?>
	<p style="font-size: 16px;">Mengalihklan ....</p>
<?php redirect(HomeUrl()."/mugencode",5)?>
<?php } ?>