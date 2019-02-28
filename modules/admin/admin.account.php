<?php 
if ( !isset($_SESSION['level']) || $_SESSION['level'] < 99 ) 
	exit;
?>


<div class="row">
	<div class="col-lg-12">
		<h4 class="oboro_h4">Admin Accounts</h4>
		<div class="table-responsive">
			<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroDTADM">
				<thead>
					<tr>
						<td>Options</td>
						<td>Account</td>
						<td>User ID</td>
						<td>Password</td>
						<td>E-Mail</td>
						<td>State</td>
						<td>Last IP</td>
						<td>Last Mac</td>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script>
	(function($) {
		'use strict';
		$('#OboroDTADM').DataTable({
			responsive: true,
			bFilter: true,
			bInfo: true,
			bPaginate: true,
			Processing: true,
			bSortClasses: false,
			ajax: "libs/ajax/datatables.ajax.php?info=acc",
			deferRender: true
		});
	}(jQuery));
</script>