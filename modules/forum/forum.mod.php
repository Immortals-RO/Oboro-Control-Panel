<?php
if (!$FNC->islogged() || !$NRM->getParam(0) || !is_numeric($NRM->getParam(0)))
	exit;

$result = $DB->execute(
			"SELECT 
				`cat`.`category_id`, 
				`cat`.`category_name`, 
				`cat`.`parent_category`, 
				`cat`.`account_level_access`, 
				`cat`.`account_level_create`,
				`oboro_forum_posts`.`owner_id`
			FROM 
				`oboro_forum_posts`
			INNER JOIN
				`oboro_forum_categories` AS `cat` ON `cat`.category_id = `oboro_forum_posts`.`category` 
			WHERE 
			`oboro_forum_posts`.`blog_id`= ?",
			[$NRM->getParam(0)],
			"Forum"
		);
		
$row = $result->fetch();

$catid = $row['category_id'];

if ($_SESSION['level'] < $row['account_level_access'] || $_SESSION['level'] < $row['account_level_create'])
	exit;
        
if (!$result->rowCount() || $row['owner_id'] != $_SESSION['account_id'] || $FNC->isgm() && $_SESSION['level'] < $CONFIG->getConfig("GM_Delete_Level"))
    $FNC->redirect('forum.cat');

$forum_disp = $DB->execute("SELECT `display_name` FROM `oboro_forum_user` WHERE account_id=?", [$_SESSION['account_id']], "Forum")->fetch();

if (empty($forum_disp['display_name']))
{
    echo 'cannot modify post without display name';
    exit;
}

include_once('forum.shoutbox.php');

echo $FNC->getDinamicForumTree($NRM->getParam(0), 'create');

?>
	<form id="post-modify" class="forum-controller" data-catid="<?php echo $NRM->getParam(0); ?>" data-opt="MODIFY_POST">
        <input type="hidden" name="catid" value="<?php echo $NRM->getParam(0); ?>">
		<div class="row">
			<div class="col-lg-12" id="search_text_editor">
				<h4 class="title-forum">
					<div class="h4-container">
						<i class="fa fa-newspaper-o" aria-hidden="true"></i> Modifying topic as: <?php echo $forum_disp['display_name']; ?>
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