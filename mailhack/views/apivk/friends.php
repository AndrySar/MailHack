<div class="col-md-12 col-md-offset-0" >			
	<div class="page-header"style="margin-top:0px;">
		<h1>Mail information <small> | <a href="<?=BASE_URL?>?module=config&method=manager"><?=(isset($_SESSION["_USER"])) ? $_SESSION["_USER"]["USERNAME"] : "Guest"?></a> </small></h1>
	</div>
	<?php
			$i = 1;
			foreach($_SESSION["_USER"]['FRIENDS'] as $friend)
			{
				echo $friend->first_name;
			}
		?>			
</div>
