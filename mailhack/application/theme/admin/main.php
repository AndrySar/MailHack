<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<link rel="stylesheet" type="text/css" href="<?=BASE_URL?>/application/theme/css/styles.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script type="text/javascript">

		function someFunction(abc) {
			alert(abc);
			//$.session.set("THREADID", abc);
			alert( SESSION  );
		}

		$( document ).ready(function() {
			
			$('#threads').on('click','li.searchterm',function() {    
				console.log('testing');
			});
			
			$( "#res" ).on("click", "li.searchterm", function(event) {    
				var val = $(this).val();
				console.log('lol');
				/* $.ajax(
				{
					url: "http://62.109.21.24/mailhack/?module=config&method=threadviewid",
					type: "POST",

					data: { id: val},
					success: function (result) {
							alert('success');

					}
				});    */  
			});
		});
	</script>
</head>

<div class="container">
	<div class="row">
    <div class="col-md-12" style="margin-top:10px">
		<nav class="navbar navbar-default">
		  <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="#">Mail Robot</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			
			  <ul class="nav navbar-nav">
				<li><a href="<?=BASE_URL?>?module=config&method=account#">Main</a></li>
				<li><a href="<?=BASE_URL?>?module=config&method=manager#">Account manager<span class="sr-only">(current)</span></a></li>
				<?php if($_SESSION["_USER"]["is_email"] == true)
				{
					echo
					'<li><a href="'.BASE_URL.'?module=config&method=mailinformation#">Mail info</a></li>';
				}
				?>
				<li><a href="<?=BASE_URL?>?module=robot&method=robotinfo#">Robot info</a></li>
				<?php if($_SESSION["_USER"]["is_email"] == true)
				{
					echo
					'<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Robot settings <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						<li><a href="'.BASE_URL.'?module=robot&method=search#">Search</a></li>
						<li><a href="'.BASE_URL.'?module=robot&method=sorting#">Sorting</a></li>
						<li><a href="'.BASE_URL.'?module=robot&method=del#">Delete</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="'.BASE_URL.'?module=robot&method=answer#">Answer</a></li>
						<li role="separator" class="divider"></li>
					  </ul>
					</li>';
				}
				?>
				<li><a href="<?=BASE_URL?>?module=config&method=update#">Update</a></li>
			  </ul>
			<ul class="nav navbar-nav navbar-right">				
				<li class=""><a href="<?=BASE_URL?>?module=welcome&method=logout">Logout (<?=(isset($_SESSION["_USER"])) ? $_SESSION["_USER"]["USERNAME"] : "Guest"?>) <span class="sr-only">(current)</span></a></li>
			</ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
  
	</div>
	
	<!--
  </div>
</div>-->