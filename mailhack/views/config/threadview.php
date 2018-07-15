<div class="col-md-12 col-md-offset-0" >			
	<div class="page-header"style="margin-top:0px;">
		<h1>Mail information <small> | <a href="<?=BASE_URL?>?module=config&method=manager"><?=(isset($_SESSION["_USER"])) ? $_SESSION["_USER"]["USERNAME"] : "Guest"?></a> </small></h1>
	</div>

	<div class="tab-content">
		<div class="col-md-4">
			<ul class="nav nav-pills nav-stacked" role="tablist">
				<?php
					$i = 1;
					foreach($_SESSION["_USER"]['FOLDERS'] as $folder)
					{
						#debug($folder->folder);
						if($i == 1)
						{
							$active = 'class="active"';
						}
						else
						{
							unset($active);
						}
						echo '<li role="presentation" '.$active.' data-toggle="tooltip" data-placement="left" title="'.$folder->messages.' messages"><a href="#folder'.$i.'"aria-controls="folder'.$i.'"role="tab" data-toggle="tab">'.$folder->name;
						if ($folder->messages_unread!=0)
						{
							echo '<span class="badge">'.$folder->messages_unread.' unread</span>';
						}
						if ($folder->messages_total!=0)
						{
							echo '<span class="label label-info pull-right">'.$folder->messages_total.'</span>';
						}
						echo '</a></li>';
						$i++;
					}
				?>
			</ul>
		</div>
		
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
				<div role="tabpanel" class="col-md-8 tab-pane '.$active.'" id="folder'.$i.'">
					<div class="col-md-12">
						<h2 style = "margin-top:0px; margin-bottom:20px;">THREADS</h2>
				';
					
						
				echo '<ul class="list-group">';
				foreach ($_SESSION["_USER"]['MESSAGES'][$_SESSION['THREADID']] as $message)
				{
					echo '<li class="list-group-item">'.$message->body->html.'</li>';

				}
				echo '</ul>';
			
					
				$i++;
				echo
				'
					</div>
				</div>
				';
			}
		?>			
	</div>
</div>
