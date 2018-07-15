	<div class="col-md-12 col-md-offset-0" >	
	
	<div class="page-header"style="margin-top:0px;">
		<h1>Main<small> | <?=(isset($_SESSION["_USER"])) ? $_SESSION["_USER"]["USERNAME"] : "Guest"?> </small></h1>
	</div>
	
	<div class="alert alert-warning" role="alert"> <strong>Send an email</strong></div>
	
	<form class="form-horizontal" method="post" action="<?=BASE_URL?>?module=config&method=send_mail">
		<br>
		<div class="form-group">
			<label for="InputEmail">To</label>
			<input required type="text" class="form-control" name="InputTo" placeholder="E-mail">
		</div>
		<div class="form-group">
			<label for="Phone">Subject</label>
			<input type="text" class="form-control" name="InputSubject" placeholder="title">
		</div>
		<div class="form-group">
			<label for="Message">Message</label>
			<textarea class="form-control" rows="5" name="InputMessage"></textarea>
		</div>
	  <button type="submit" class="btn btn-default">Submit</button>
	</form>
	
	</div>
  </div>
</div>