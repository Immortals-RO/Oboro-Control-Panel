<?php
if ( !isset($_SESSION['level']) || $_SESSION['level'] < 99 ) 
	exit;

if ($NRM->getParam(0))
	$result = $DB->execute("DELETE FROM `oboro_forum_categories` WHERE `category_id`=?", [$NRM->getParam(1)], "Forum");

$result = $DB->execute("SELECT `category_id`, `category_name`, `parent_category`, `category_descript`, `account_level_access`, `account_level_create` FROM `oboro_forum_categories` ORDER BY `category_id` ASC", [], "Forum");
if ($DB->num_rows())
{
	echo 
	'
		<div class="row">
			<div class="col-lg-12">
				<h4 class="oboro_h4"><i class="fa fa-list-ol" aria-hidden="true"></i> Forum Categories Administration</h4>
				<table class="table table-hover table-light no-footer table-bordered table-striped table-condensed" id="OboroDT">
				<thead>
					<tr>
						<th>Cat Ident.</th>
						<th>Title</th>
						<th>Parent</th>
						<th>Description</th>
						<th>Lv. to read</th>
						<th>Lv. to write</th>
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
							<td>'.$row['category_id'].'</td>
							<td>'.$row['category_name'].'</td>
							<td>'.(empty($row['parent_category']) ? 'Parent' : $row['parent_category']).'</td>
							<td>'.$FNC->shorter($row['category_descript'], 46).'</td>
							<td>'.$row['account_level_access'].'</td>
							<td>'.$row['account_level_create'].'</td>
							<td>
								<div class="btn-group">
								  <div class="btn-group">
									<a date-catid="'.$row['category_id'].'" data-catname="'.$row['category_name'].'" data-parentid="'.$row['parent_category'].'" data-desc="'.$row['category_descript'].'" data-lvacc="'.$row['account_level_access'].'" data-lvcreate="'.$row['account_level_create'].'" class="btn btn-secondary ModifyBlog">Modify</a>
								  </div>
								  <div class="btn-group">
									<a href="?admin.management-5-'.$row['category_id'].'" class="btn btn-warning">Delete</a>
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
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> Create a new Category or Subcategory
						<div class="minimize-forum-container"><i class="fa fa-window-minimize fa-border" aria-hidden="true"></i></div>
						<div class="clearfix"></div>
					</div>
				</h4>
				<div class="option-container container-category-forum">
					<div class="row nopadding">
						<div class="col-lg-6 oboro-divs-container">
							<div class="input-group">
								<input type="hidden" name="catid" class="form-control" value="0" readonly>
							</div>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-th" aria-hidden="true"></i> (Sub?) Category name</span>
								<input type="text" name="name" class="form-control" placeholder="Title Shown to users">
							</div>

							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-th" aria-hidden="true"></i> Parent or Sub-Category</span>
								<?php 
									echo $FNC->CDD('forum_categories', '', $GV, '');
								?>
							</div>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-address-card" aria-hidden="true"></i> Account Lv. to read</span>
								<input type="number" name="lvtoread" class="form-control" placeholder="Account Lv." min="0" step="0" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="0">
							</div>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-address-card" aria-hidden="true"></i> Account Lv. to write</span>
								<input type="number" name="lvtowrite" class="form-control" placeholder="Account Lv." min="0" step="0" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="0">
							</div>
							
							<input type="submit" id="post-blog" value="Create or Update" class="form-control btn btn-primary">
						</div>
                        
                        
						<div class="col-lg-6">
							<input type="hidden" name="OPT" value="CREATEMODIFYCATEGORY">
							<textarea name="description" class="form-control" placeholder="Category or Sub-Category description" rows="7" maxlength="150" style="resize:none;"></textarea>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
	</form>