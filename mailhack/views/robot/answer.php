<div class="col-md-12">

	<div class="page-header"style="margin-top:0px;">
		<h1>Mail robot <small> | answer settings </small></h1>
	</div>	
	
	<div class="col-md-6">
		<h3 style = "margin-top:0px; margin-bottom:20px;"><small>Write sender's address and text to answer</small></h3>
		<form class="form-horizontal" method="POST" action="<?=BASE_URL?>?module=robot&method=answer#">
			<div class="form-group">
				<div class="table-responsive">
					<table class="table table-striped table-nonfluid">
						<thead>
							<tr>
								<th>#</th>
								<th>To</th>
								<th>Text message</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$stre = '';
								$i = 1;
									foreach($_SESSION['_USER']['answer'] as $row)
									{
										echo '
										<tr>
											<td>'.$i.'</td>
											<td><input type="text" class="form-control" name="to'.$i.'" placeholder="Subjects" value="'.$row->to_send.'"></td>
											<td><input type="text" class="form-control" name="text'.$i.'" placeholder="Subjects" value="'.$row->text_message.'"></td>
										</tr>';
										$i++;
									}
							?>
							<tr>
								<td><?=$i?></td>
								<td><input type="text" class="form-control" name="to<?=$i?>" placeholder="To"></td>
								<td><input type="text" class="form-control" name="text<?=$i?>" placeholder="Text message"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-info">Save</button> 
			</div>
		</form>
	</div>
</div>