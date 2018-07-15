<div class="col-md-12">

	<div class="page-header"style="margin-top:0px;">
		<h1>Mail robot <small> | sorting settings </small></h1>
	</div>	

	<div class="tab-content">
		<div class="col-md-4">
			<ul class="nav nav-pills nav-stacked" role="tablist">
				<?php
					$i = 1;
					foreach($_SESSION["_USER"]['FOLDERS'] as $folder)
					{
						if($i == 1)
						{
							$active = 'class="active"';
						}
						else
						{
							unset($active);
						}
						echo '<li role="presentation" '.$active.'><a href="#folder'.$i.'"aria-controls="folder'.$i.'"role="tab" data-toggle="tab">'.$folder->folder.
							'<span class="label label-info pull-right">'.$folder->messages.'</span>
							</a></li>';
						$i++;
					}
				?>
			</ul>
		</div >

		<?php
			$i = 1;

			foreach($_SESSION["_USER"]['FOLDERS'] as $folder)
			{
				if($i == 1)
				{
					$active ='active';
				}

				else
				{
					unset($active);
				}
					echo
					'
					<div role="tabpanel" class="tab-pane '.$active.'" id="folder'.$i.'">
						<div class="btn-group-vertical col-md-8" role="group" aria-label="...">
							<h3 style = "margin-top:0px; margin-bottom:20px;"><small>Write those sender`s address through comma and space to move to current folder</small></h3>
							<form class="form-horizontal" method="POST" action="'.BASE_URL.'?module=robot&method=sorting#">
								<div class="form-group">
									<input type="text" class="form-control" name="'.$folder->folder.'" placeholder="Subjects" value="';
									$stre = '';
									foreach($_SESSION['_USER']['sorting'] as $subject)
									{
										if ($subject->folder == $folder->folder)
										{
											$stre .= $subject->from_name.', ';
										}
										#echo $stre;
									}
									#echo $stre;
									$stre = substr($stre, 0, strlen($stre)-2);
									echo $stre;
									
									echo '">
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-info">Save</button> 
								</div>
							</form>
						</div>
					</div>
					';
				$i++;
			}
		?>

	</div>
</div>
	