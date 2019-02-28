<?php
if (!isset($_SESSION['level']) || $_SESSION['level'] < 99)
	exit;
?>

<div class="row">
	<div style="margin-top: -10px;">
		<div class="admin-menu">
			<ul>
                <li><a href="?admin.management-0">Dashboard</a></li>
				<li><a href="?admin.management-1">Accounts</a></li>
				<li><a href="?admin.management-2">Characters</a></li>
				<li>
					<a>Configure Item DB</a>
					<ul>
						<li><a href="?admin.management-3">Add Item DB</a></li>
						<li><a href="?admin.management-4">Config. Donation Shop</a></li>
					</ul>
				</li>
				<li>
					<a>Forum Management</a>
					<ul>
						<li><a href="?admin.management-5">Categories Conf.</a></li>
						<li><a href="?admin.management-6">User Groups.</a></li>
						<li><a href="?admin.management-7">User Conf.</a></li>
					</ul>
				</li>
				<li><a href="?admin.management-8">PickLog</a></li>
			</ul>
		</div>
	</div>
</div>


<?php
	if (($opt = $NRM->getParam(0)) >= 0)
	{
		$module = FALSE;
		switch($opt)
		{
            case 0:
                $module = "dashboard";
            break;
			case 1:
				$module = "account";
			break;
			
			case 2:
				$module = "char";
			break;
				
			case 3:
				$module = "item_db.create";
			break;
				
			case 4:
				$module = "donationshop";
			break;
				
			case 5:
				$module = "forum.categories";
			break;
				
			case 6:
				$module = "forum.groups";
			break;
                
            case 7:
                $module = "forum.user";
            break;
				
			case 8:
				$module = "picklog";
			break;
		}
		if (isset($module))
			include_once("admin.".$module.".php");
	}
?>