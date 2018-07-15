<div class="col-md-12">

	<div class="page-header"style="margin-top:0px;">
		<h1>Mail robot <small> | delete settings </small></h1>
	</div>	
	
	<div class="col-md-4">
		<h3 style = "margin-top:0px; margin-bottom:20px;"><small>Write those sender's address through comma and space to delete from INBOX</small></h3>
		<form class="form-horizontal" method="POST" action="<?=BASE_URL?>?module=robot&method=del#">
			<div class="form-group">
			<?php
				$stre = '';
				foreach($_SESSION['_USER']['delete'] as $subject)
				{
					$stre .= $subject->from_name.', ';
				}
				$stre = substr($stre, 0, strlen($stre)-2);
			
				echo '<input type="text" class="form-control" name="delete_from" placeholder="Subjects" value="'.$stre.'">';
			?>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-info">Save</button> 
			</div>
		</form>
		
		
	</div>
</div>
	