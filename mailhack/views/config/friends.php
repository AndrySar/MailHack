<div class="col-md-12 col-md-offset-0" >			
	<div class="page-header"style="margin-top:0px;">
		<h1>Mail information <small> | <a href="<?=BASE_URL?>?module=config&method=manager"><?=(isset($_SESSION["_USER"])) ? $_SESSION["_USER"]["USERNAME"] : "Guest"?></a> </small></h1>
	</div>

	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Отправить файл</button>

  <!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">

	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Список друзей</h4>
		</div>
		<div class="modal-body">
		  <?php
			$i = 1;
			foreach($_SESSION["_USER"]['FRIENDS'] as $friend)
			{
				echo '
				<div class="custom-control custom-radio">
					<input type="radio" class="custom-control-input" id="defaultGroupExample1" name="groupOfDefaultRadios">
					<label class="custom-control-label" for="defaultGroupExample1">'.$friend->first_name.' '.$friend->last_name.'</label>
				</div>';
			}
		?>
		</div>
		<div class="modal-footer">
		  <button type="button" onclick="location.href='http://62.109.21.24/mailhack/?module=config&method=sendfile'" class="btn btn-default" data-dismiss="modal">Отправить</button>
		</div>
	  </div>
	  
	</div>
</div>
			
</div>
