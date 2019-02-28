<?php
if (!isset($_SESSION['level'])) 
	exit;

if (!$NRM->getParam(0))
	exit;

$consult = "SELECT `category_id`, `category_name`, `parent_category`, `account_level_access`, `account_level_create` FROM `oboro_forum_categories` WHERE `category_id`= ?";
$param = [$NRM->getParam(0)];
$result = $DB->execute($consult, $param, "Forum");
$row = $result->fetch();

$forum_disp = $DB->execute("SELECT `display_name` FROM `oboro_forum_user` WHERE account_id=?", [$_SESSION['account_id']], "Forum")->fetch();

if (empty($forum_disp['display_name']))
{
    echo 'cannot create topic without display_name';
    exit;
}

if ($_SESSION['level'] < $row['account_level_access'] || $_SESSION['level'] < $row['account_level_create'])
	exit;

include_once('forum.shoutbox.php');

echo $FNC->getDinamicForumTree($NRM->getParam(0), 'create');

?>

	<form class="forum-controller" data-opt="CREATETOPIC" data-catid="<?php echo $NRM->getParam(0); ?>">
		<div class="row">
			<div class="col-lg-12" id="search_text_editor">
				<h4 class="title-forum">
					<div class="h4-container">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> Creating a new topic as: <?php echo $forum_disp['display_name']; ?>
						<div class="minimize-forum-container"><i class="fa fa-window-minimize fa-border" aria-hidden="true"></i></div>
						<div class="clear"></div>
					</div>
				</h4>
				<div class="option-container container-category-forum">
					<div class="row nopadding">
						<div class="option-title-row w-100">
								<div class="row">
									<div class="col-lg-5 nopadding-left">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-th" aria-hidden="true"></i> Title</span>
											<input type="text" name="title" class="form-control" placeholder="Title Shown to users">
										</div>
									</div>
									<div class="col-lg-3 nopadding-left">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i> Date</span>
											<input type="text" name="date" class="form-control readonly-class" value="<?php echo date(" Y-m-d "); ?>" readonly>
										</div>
									</div>
        							<div class="col-lg-4 nopadding">
										<input type="submit" id="post-blog" value="Post or Update blog" class="form-control btn btn-primary">
									</div>
								</div>
								<div class="clearfix"></div>
						</div>
					</div>
					<div id="editor"></div>
				</div>
			</div>
		</div>
	</form>