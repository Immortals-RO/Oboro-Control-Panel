<?php
if (!$FNC->islogged())
{
    echo 
    '
        <div class="row">
            <div class="col-lg-12">
                You need to login to view the forum
            </div>
        </div>
    ';
}
else
{
	include_once('forum.shoutbox.php');
	
    if (!$NRM->getParamSize() || $NRM->getParam(0) == 0)
    {
        $result = $DB->execute("SELECT `category_id`, `category_name`, `parent_category`, `account_level_access` FROM `oboro_forum_categories` WHERE `parent_category`= 0", [], "Forum");
        if ($DB->num_rows("Forum"))
        {            
            echo $FNC->getDinamicForumTree(0, 'parent');
            echo '
				<div class="row">
                 <div class="col-12">
                  <div class="row">
					<div class="col-lg-9 nopadding-left oboro-rowx2">	
			';
            while ($row = $result->fetch())
            {
                if ($_SESSION['level'] < $row['account_level_access'])
                    continue;

                echo 
                '
                	<h5 class="border-bottom border-gray pb-2 mb-0"> 
						<div class="h4-container">
						'. $row['category_name'] .'
						</div>
					</h5>	
                ';
                $consult = "SELECT `category_id`, `category_name`, `parent_category`, `category_descript`, `account_level_access` FROM `oboro_forum_categories` WHERE `parent_category`= ?";
                $param = [$row['category_id']];
                $result_subcategories = $DB->execute($consult, $param, "Forum");
                while ($row_sub = $result_subcategories->fetch())
                {

                    if ($_SESSION['level'] < $row_sub['account_level_access'])
                        continue;

                    $number_topics_consult = "SELECT COUNT(`category`) as `posts` FROM `oboro_forum_posts` WHERE category = ?";
                    $param = [$row_sub['category_id']];
                    $result_total_posts = $DB->execute($number_topics_consult, $param, "Forum");
                    $row_total = $result_total_posts->fetch();

                    $last_subcategoria_consult = "
                        SELECT 
                            `post`.title, 
                            `post`.`date_modify`,
                            `post`.`blog_id`,
                            `user`.`display_name`,
                            `user`.`img_url`, 
                            `group`.`html_start`,
                            `group`.`html_end`
                        FROM `oboro_forum_posts` AS `post`
                        LEFT JOIN `oboro_forum_user` AS `user` ON `user`.`account_id` = `post`.`owner_id`
                        LEFT JOIN `oboro_user_groups` AS `group` ON `user`.`forum_group_id` = `group`.`user_group_id`
                        WHERE category= ? 
                        ORDER BY date_modify 
                        DESC LIMIT 1
                    ";
                    $param = [$row_sub['category_id']];
                    $result_last_update = $DB->execute($last_subcategoria_consult, $param, "Forum");
                    $row_last = $result_last_update->fetch();
                    $date = date_create($row_last['date_modify']);

                    echo
                    '
                        <div class="row text-muted border-bottom border-left border-right border-gray h-80px">
                        	<div class="col-1 d-none d-md-inline  m-auto">
								<div class="forum-oboro-unread"></div>
                            </div>
							
							<div class="col-sm-7  m-auto">
                               	<strong>
									<a class="text-gray-dark" href="?forum.cat-'.$row_sub['category_id'].'">'.$row_sub['category_name'].'</a>
								</strong>
								<br/>
                                <span class="subcategory-description d-md-block">
                                    '.$row_sub['category_descript'].'
                                </span>
							</div>
							<div class="col-sm-1 d-none d-md-inline text-center m-auto">
								<div class="post-count-number">'.$row_total['posts'].'<br/>posts</div>
							</div>
								';
									if (!empty($row_last['title']))
									{
										echo '
											<div class="col-lg-1 d-none d-md-inline m-auto">
												<div class="oboro_forum_mini_user_img">
													<img src="'.($row_last['img_url'] ? $row_last['img_url'] : './img/banners/user-1.jpg').'" />
												</div>
											</div>
											<div class="col-lg-2 col-sm-4  m-auto">
												<a href="?forum.post-'.$row_last['blog_id'].'">'.$FNC->shorter($row_last['title'],12).'</a><br/>
												'.(!empty($row_last['display_name']) ? ($row_last['html_start'] . $row_last['display_name']. $row_last['html_end']) : $CONFIG->getConfig("uknown_user")).', 
												<span class="time post-count-number-mini">	'.date_format($date, 'F Y').'</span>
											</div>
										';
									}
									else
									{
										echo '
											<div class="col-sm-3  m-auto text-center">
												No New Posts
											</div>
										';
									}
						echo '
						</div>
                    ';
                }
                echo '</table>';
            }

            echo '</div>';
            
            echo '<div class="col-lg-3 nopadding">';
			
			include_once('forum.recent.topics.php');
			include_once('forum.best.posters.php');
			
            $total = $DB->execute("
            SELECT 
                (SELECT COUNT(`oboro_forum_user_reply`.`post_id`) FROM `oboro_forum_user_reply`) AS `replies`,
	            (SELECT COUNT(`oboro_forum_posts`.`blog_id`) FROM `oboro_forum_posts`) AS `topics`,
	            (SELECT COUNT(`oboro_forum_user`.`account_id`) FROM `oboro_forum_user`) AS `users`,
                (SELECT `oboro_forum_user`.`display_name` FROM `oboro_forum_user` ORDER BY `account_id` DESC LIMIT 1) AS `latest`
            ", [], "Forum")->fetch();
            
			echo 
                
			'
                   </div>
                </div>
              </div><!--12-->
            </div> <!-- row -->
            <div class="row ForumInfo">
                    <div class="col-4">
                        T. Topics <span class="total">'.$total['topics'].'</span>
                    </div>
                    <div class="col-2">
                        T. Replies <span class="total">'.$total['replies'].'</span>
                    </div>
                     <div class="col-2">
                        T. Users <span class="total">'.$total['users'].'</span>
                    </div>                   
                    <div class="col-4">
                        Lats. Mb. <span class="total">'.$total['latest'].'</span>
                    </div>
            </div>
			';
            include_once('forum.whoisonline.php');
         echo '</div>';
        }
    }
    else
    {
        // Es una Sub_categoría, hay que mostrar los posts..
        $consult = "SELECT `category_id`, `category_name`, `parent_category`, `account_level_access`, `account_level_create` FROM `oboro_forum_categories` WHERE `category_id`= ?";
        $param = [$NRM->getParam(0)];
        $result = $DB->execute($consult, $param, "Forum");
        if ($DB->num_rows("Forum"))
        {
            $row = $result->fetch();
            $lvlcreate = $row['account_level_create'];
            $catid = $row['category_id'];
            if ($_SESSION['level'] < $row['account_level_access'])
                exit;

            echo $FNC->getDinamicForumTree($catid, $row['category_name']);
            echo 
            '
                <div class="row">
					<div class="col-lg-12">
						<h5 class="border-bottom border-gray pb-2 mb-0"> 
							<div class="h4-container">
								'. $row['category_name'] .'
							</div>		
						</h5>
            ';

            $consult = "
                SELECT 
                    blog_id, 
                    `title`, 
                    `date_create`, 
                    `owner_id`,
                    `display_name`,
                    `category`, 
                    `view_count`, 
                    `lock`,
                    `group`.`html_start`,
                    `group`.`html_end`
                FROM `oboro_forum_posts` AS `posts` 
                LEFT JOIN `oboro_forum_user` AS `user` ON  `user`.`account_id`=`posts`.`owner_id` 
                LEFT JOIN `oboro_user_groups` AS `group` ON `user`.`forum_group_id` = `group`.`user_group_id`
                WHERE `category`=? 
                ORDER BY `date_create` DESC";
            $param = [$NRM->getParam(0)];
			
            $result = $DB->execute($consult, $param, "Forum");
			
			if ($result->rowCount() > 0)
			{
				while ($row = $result->fetch())
				{
					$owid = $row ['owner_id'];
					$bid = $row['blog_id'];
					
					$number_topics_consult = "SELECT COUNT(`post_id`) as `posts` FROM `oboro_forum_user_reply` WHERE subcategory_id = ?";
					$param = [$row['blog_id']];
					$result_total_posts = $DB->execute($number_topics_consult, $param, "Forum");
					$row_total = $result_total_posts->fetch();

					$date = date_create($row['date_create']);

					echo
					'
					 	<div class="row text-muted border-bottom border-left border-right border-gray h-80px">
							<div class="col-1 d-none d-md-inline  m-auto">
					';
							if (!$row['lock'])
								echo '<div class="forum-oboro-unread"></div>';
							else
								echo '<div class="locked-topic"><i class="fa fa-lock" aria-hidden="true"></i></div>';
					
					echo
					'
							</div>
							
							<div class="col-sm-6 m-auto">
                               	<strong>
									<a class="text-gray-dark" href="?forum.post-'.$row['blog_id'].'">'.$row['title'].'</a>
								</strong>
                                <div class="subcategory-description">By '.(!empty($row['display_name']) ? ($row['html_start'] . $row['display_name']. $row['html_end']) : $CONFIG->getConfig("uknown_user")).', '.date_format($date, 'd M, Y.').'</div>
							</div>
							
							<div class="col-sm-1 d-none d-sm-inline text-center m-auto">
								<div class="post-count-number">'.$row_total['posts'].'<br/>posts</div>
							</div>

							<div class="col-sm-1 d-none d-sm-inline text-center m-auto">
								<div class="post-count-number">'.$row['view_count'].'<br/>views</div>
							</div>	
					';

					$consult =
					"
						SELECT 
							`reply`.post_id, 
                            `reply`.`date_create`,
                            `user`.`display_name`,
                            `user`.`img_url`,
                            `group`.`html_start`,
                            `group`.`html_end`
						FROM oboro_forum_posts AS `posts`
						INNER JOIN `oboro_forum_user_reply` AS `reply` ON `posts`.`blog_id` = `reply`.subcategory_id
						LEFT JOIN `oboro_forum_user` AS `user` ON `user`.`account_id` = `reply`.`account_id`
                        LEFT JOIN `oboro_user_groups` AS `group` ON `user`.`forum_group_id` = `group`.`user_group_id`
						WHERE `posts`.`blog_id`=?
						ORDER BY `post_id` 
						DESC
						LIMIT 1
					";
					$row = $DB->execute($consult, [$row['blog_id']], "Forum")->fetch();
													
					if (!empty($row['display_name']))
					{
						echo
						'
							<div class="col-1 d-none d-md-inline m-auto">
								<div class="oboro_forum_mini_user_img">
									<img src="'.($row['img_url'] ? $row['img_url'] : './img/banners/user-1.jpg').'" />
								</div>
							</div>
							<div class="col-1 d-none d-md-inline m-auto">
								' . (!empty($row['display_name']) ? ($row['html_start'] . $row['display_name']. $row['html_end']) : $CONFIG->getConfig("uknown_user")) . '<br/> <div class="subcategory-description">On ' . date_format(date_create($row['date_create']), 'd, M Y') .'</div>
							</div>
						';							
					} 
					else
						echo '<div class="col-2 d-none d-md-inline m-auto subcategory-description text-center">No replies</div>';
					
					if ($_SESSION['account_id'] == $owid && $CONFIG->getConfig("User_Delete_Own") == 'yes' || $FNC->isgm() && $_SESSION['level'] >= $CONFIG->getConfig("GM_Delete_Level"))
					{
						echo 
						'
							<div class="col-1 d-none d-md-inline m-auto">
								<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
									<i class="fa fa-cog" aria-hidden="true"></i> 
									<span class="caret"></span> 
								</button>
								<ul class="dropdown-menu">
									<li><a data-catid="'.$catid.'" data-blogid="'.$bid.'" class="forum-delete-post"><i class="fa fa-minus-circle" aria-hidden="true"></i> Delete Post</a></li>
									<li><a href="?forum.mod-'.$bid.'" class="forum-modify-post"><i class="fa fa-wrench" aria-hidden="true"></i> Modify Post</a></li>
						';
						
						if ($FNC->isgm())
							echo '<li><a data-catid="'.$catid.'" data-blogid="'.$bid.'" class="forum-lockunlock-post"><i class="fa fa-lock" aria-hidden="true"></i> (Un)Lock Post</a></li>';
						
						echo '
								</ul>
							</div>
						';
					}
					else
						echo '<div class="col-1 d-none d-md-inline m-auto">No Options</div>';

					echo '</div>';	
				}
			}
			else
			{
				echo 
				'
					<div class="row text-muted border-bottom border-left border-right border-gray h-80px">
						There\'s no post yet.
					</tr>
				';
			}

            echo '
			</div>
            ';

            if (isset($_SESSION['level']) && $_SESSION['level'] >= $lvlcreate)
            {
                echo 
                '
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="?forum.create-'.$catid.'" class="forum-create-new btn btn-success">Create new Post</a>
                        </div>
                    </div>
                ';
            }
            else
            {
                echo 
                '
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="button" class="forum-create-new btn btn-danger" value="Can\'t create posts here." disabled>
                        </div>
                    </div>
                ';
            }
        }
    }
}

?>