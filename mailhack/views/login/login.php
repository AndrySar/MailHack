


<div class="page-header"style="margin-top:0px;">
	<h1>Mail robot <small> | sign in to your account </small></h1>
	<?php
		if(isset($msg))
		{
			echo '<p style="color:red; margin-top:10px;"">'.$msg.'</p>';
		}		
	?>
</div>
	
<form class="form-horizontal" method="POST" action="<?=BASE_URL?>?module=welcome&method=login">
	<div class="form-group">
		<div class="col-md-4">
			<input type="text" class="form-control" name="login" placeholder="Login" required>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-4">
			<input type="password" class="form-control" name="password" placeholder="Password" required>
		</div>
	</div>
	<div class="form-group" style="margin-bottom:5px;">
		<div class="col-md-4">
			<input type="checkbox" style="margin-right: 5px;">Remember me
			<a href="<?=BASE_URL?>?module=welcome&method=forgot_password" style="float:right!important;"> 
				Forgot your password?
			</a>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-4">
			<button type="submit" class="btn btn-info">Sign in</button> 
			<a href="<?=BASE_URL?>?module=welcome&method=register">
				<button type="button" class="btn btn-default pull-right">Sign up for a new account</button> 
			</a>
		</div>
	</div>
</form>
		
	</div>		
</div>