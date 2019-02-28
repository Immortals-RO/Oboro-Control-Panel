<?php
if ( !isset($_SESSION['level']) || $_SESSION['level'] < 99 ) 
	exit;

if ($NRM->getParam(0))
	$result = $DB->execute("DELETE FROM `oboro_user_groups` WHERE `user_group_id`=?", [$NRM->getParam(1)], "Forum");

$result = $DB->execute("SELECT `user_group_id`, `group_name`, `html_start`, `html_end` FROM `oboro_user_groups` ORDER BY `user_group_id` ASC", [], "Forum");
if ($DB->num_rows())
{
	echo 
	'
		<div class="row">
			<div class="col-lg-12">
				<h4 class="oboro_h4"><i class="fa fa-list-ol" aria-hidden="true"></i> Forum User group Administration</h4>
				<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroDT">
				<thead>
					<tr>
						<th>ID Group.</th>
						<th>Name</th>
						<th>Administration</th>
					</tr>
				</thead>
				<tbody>
	';
				while ($row = $result->fetch())
				{
					echo 
					'
						<tr>
							<td>'.$row['user_group_id'].'</td>
							<td>'.$row['html_start'] . $row['group_name']. $row['html_end'].'</td>
							<td>
								<div class="btn-group">
								  <div class="btn-group">
									<a data-htmls="'.$row['html_start'].'" data-htmle="'.$row['html_end'].'" data-gid="'.$row['user_group_id'].'" data-name="'.$row['group_name'].'" class="btn btn-secondary ModifyGroup">Modify</a>
								  </div>
								  <div class="btn-group">
									<a href="?admin.management-6-'.$row['user_group_id'].'" class="btn btn-warning">Delete</a>
								  </div>
								</div>
							</td>
					';
				}
	echo '
				</tbody>
				</table>
			</div>
		</div>
	';
}
?>

    <form class="OBOROBACKWORK">
        <div class="row">
            <div class="col-lg-12" id="search_text_editor">
                <h4 class="title-forum">
                    <div class="h4-container">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> Create a new User group
                        <div class="minimize-forum-container"><i class="fa fa-window-minimize fa-border" aria-hidden="true"></i></div>
                        <div class="clearfix"></div>
                    </div>
                </h4>
                <div class="option-container container-category-forum">
                    <div class="row nopadding">
                        <div class="col-12 oboro-divs-container">
                            <div class="row">
                                <div class="col-6">
                                    <input type="hidden" name="OPT" value="CREATEMODIFYGROUPS">
                                    <input type="hidden" name="gid" class="form-control" value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-th" aria-hidden="true"></i> Group Name</span>
                                        <input type="text" name="name" class="form-control" placeholder="Title Shown to users">
                                    </div>
                                    <input type="submit" id="post-blog" value="Create or Update" class="form-control btn btn-primary">
                                </div>
                                <div class="col-6">

                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-address-card" aria-hidden="true"></i> HTML Start</span>
                                        <input type="text" name="htmls" class="form-control" value="<span style='color:#07ceed'>">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-address-card" aria-hidden="true"></i> HTML End</span>
                                        <input type="text" name="htmle" class="form-control" value="</span>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
