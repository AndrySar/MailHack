<div class="page-header"style="margin-top:0px;">
	<h1>Mail robot <small> | input code that will send to your email</small></h1>
	<?php
		if(isset($msg))
		{
			echo '<p style="color:red; margin-top:10px;"">'.$msg.'</p>';
		}		
	?>
</div>

<form class="form-horizontal" method="POST" action="<?=BASE_URL?>?module=welcome&method=get_password">
	<div class="form-group">
		<div class="col-sm-4">
			<input type="text" class="form-control" name="code" placeholder="Code">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-4">
			<button type="submit" class="btn btn-info">Continue</button> 
			<a href="<?=BASE_URL?>?module=welcome&method=login">
				<button type="button" class="btn btn-default pull-right">Cancel</button> 
			</a>
		</div>
	</div>
</form>