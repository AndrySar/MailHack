<div class="page-header"style="margin-top:0px;">
	<h1>Mail robot <small> | input your login </small></h1>
</div>
<?php
		if(isset($msg))
		{
			echo '<p style="color:red; margin-top:10px;"">'.$msg.'</p>';
		}		
?>
<form class="form-horizontal" method="POST" action="<?=BASE_URL?>?module=welcome&method=forgot_password">
	<div class="form-group">
		<div class="col-sm-4">
			<input type="text" class="form-control" name="r_login" placeholder="Login">
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
		
	</div>		
</div>