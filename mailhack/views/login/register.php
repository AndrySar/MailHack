<script>
$( document ).ready(function() {
	$('#pass2').keyup(function() {
		
		var pass1 = $("#pass1").val();
		var pass2 = $("#pass2").val();
		console.log('echo');
		if(pass1.length == pass2.length)
		{
			if(pass1 != pass2)
			{
				$(".vis_pass").removeAttr("disabled");
				$(".btn").attr("disabled", "disabled");
				$(".vis_pass").css('display', 'block');
			}
			else
			{
				$(".vis_pass").attr("disabled", "disabled");
				$(".vis_pass").css('display', 'none');
				$(".btn").removeAttr("disabled");
			}
		}
		if (pass1.length > pass2.length)
		{
			$(".vis_pass").attr("disabled", "disabled");
			$(".vis_pass").css('display', 'none');
			$(".btn").attr("disabled", "disabled");
		}
		if (pass1.length < pass2.length)
		{
			$(".btn").attr("disabled", "disabled");
			$(".vis_pass").removeAttr("disabled");
			$(".vis_pass").css('display', 'block');
		}
	});
	
});
</script>
<!--
<div class="container">
	<div class="block1">
		<center>
		<h2>Mail Robot</h2></center>
		<center >Create an account</br>
		
		*/
		</center>
		<div class="msg_text"></div>
		<form action="<?=BASE_URL?>?module=welcome&method=register" method="post">
			<div class="f_in"">
				<p><input type="text" name="login" placeholder="Login" style="text-align: center;" required></p>
			</div>
			<div class="f_in">
				<p><input type="password" id="pass1" name="password1" placeholder="Password" style="text-align: center;" required/></p>
			</div>
			<div class="f_in">
				<p><input type="password" id="pass2" name="password2" placeholder="Repeat password" style="text-align: center;" required/></p>
			</div>
			<div class="f_in">
				<p>
					<button type="submit" class="btn btn-warning" disabled>Submit</button> 
				</p>
			</div>	
		</form>
		<div class="f_in">	
			<a class="btn btn-warning" href="<?=BASE_URL?>?module=welcome&method=login" >I've already had</a> 
		</div>
	</div>
</div>
-->

<div class="page-header"style="margin-top:0px;">
	<h1>Mail robot <small> | sign up for a new account </small></h1>
	<?php
		if(isset($msg))
		{
			echo '<p style="color:red; margin-top:10px;"">'.$msg.'</p>';
		}		
	?>
</div>
	
<form class="form-horizontal" method="POST" action="">
	<div class="form-group">
		<div class="col-sm-4">
			<input type="text" class="form-control" name="login" placeholder="Login" required>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-4">
			<input type="text" class="form-control" name="username" placeholder="Name and Surname" required>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-4">
			<input type="password" class="form-control" id="pass1" name="password1" placeholder="Password" required>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-4">
			<input type="password" class="form-control" id="pass2" name="password2" placeholder="Repeat password" required>
		</div>
		<div class="col-sm-2 vis_pass alert alert-danger" style="display: none; height:34px; margin-bottom:0px; padding:6px;" role="alert">Passwords do not match</div>
	</div>
	<div class="form-group">
		<div class="col-sm-4"> 
			<a href="<?=BASE_URL?>?module=welcome&method=login" style="margin-left:12px;"> 
				I have an account
			</a>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-4">
			<button type="submit" class="btn btn-info" disabled>Submit</button>  
		</div>
	</div>
</form>
		
	</div>		
</div>