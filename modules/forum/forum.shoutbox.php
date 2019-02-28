<div class="row">
	<div class="col-lg-12">
		<div class="oboro_forum_shoutbox">
			<h5 class="border-bottom border-gray pb-2 mb-0">
				<div class="h4-container">
					Nanosoft Forum &copy;
				</div>
			</h5>

			<div class="oboro_forum_shoutbox_container">
				<table id="oboro_forum_shout_ajax">
					<?php include_once('forum.shoutbox.ajax.php'); ?>
				</table>
			</div>
			<div class="oboro_forum_new_shout_container">
				<form class="OBOROBACKWORK">
					<div class="row shout_box">
						<div class="col-1 nopadding">
							<input type="hidden" name="OPT" value="NEWSHOUTBOX">
							<input type="submit" class="btn btn-success w-100" value="Shout" />
						</div>
						<div class="col-11 nopadding">
							<input type="input" class="form-control" name="shout" placeholder="Enter something to shout">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>