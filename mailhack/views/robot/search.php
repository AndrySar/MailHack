<div class="col-md-12">

	<div class="page-header"style="margin-top:0px;">
		<h1>Mail robot <small> | search settings </small></h1>
	</div>	
	
	<div class="col-md-4">
		<h3 style = "margin-top:0px; margin-bottom:20px;"><small>Write key words</small></h3>
		<form class="form-horizontal" method="POST" action="<?=BASE_URL?>?module=robot&method=search#">
			<div class="form-group">
				<input type="text" class="form-control" name="value_search" placeholder="Subjects" value="<?=$_REQUEST['value_search']?>">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-info">Search</button> 
			</div>
		</form>
	</div>
	
	<div class="col-md-8">
	<?php
	if(count($_SESSION['_USER']['search'])>0)
	{
		#debug($_SESSION['_USER']['search']);
		echo'
			<div class="table-responsive">
				<table class="table table-striped table-nonfluid">
					<thead>
						<tr>
							<th>#</th>
							<th>From</th>
							<th>Subject</th>
							<th>Text message</th>
						</tr>
					</thead>
					<tbody>';
							$stre = '';
							$i = 1;
								foreach($_SESSION['_USER']['search'] as $row)
								{
									#debug( $row);
									echo '
									<tr>
										<td>'.$i.'</td>
										<td>'.$row->from_name.'</td>
										<td>'.$row->subject.'</td>
										<td>'.$row->text.'</td>
									</tr>';
									$i++;
								}
	}
	else
	{
		if(strlen(array_values($_REQUEST)[2])>0)
		{
			echo 'Nothing is found';
		}
	}
	?>
					</tbody>
				</table>
			</div>
	</div>
</div>
	