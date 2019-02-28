<?php
if (!$NRM->getParam(0))
	exit;

include_once('forum.shoutbox.php');

if (is_numeric($NRM->getParam(0)))
	$DB->execute("UPDATE `oboro_forum_posts` SET `view_count`=(`view_count` + 1) WHERE `blog_id` = ?", [$NRM->getParam(0)], "Forum");

$result = $DB->execute('
    SELECT 
        `blog_id`, 
        `date_create`, 
        `title`, 
        `text_html`, 
        `date_modify`, 
        `display_name`, 
        `img_url`, 
        `lock`,
        `group`.`html_start`,
        `group`.`html_end`,
        `group`.`group_name`
    FROM `oboro_forum_posts` 
    LEFT JOIN `oboro_forum_user` as user on user.account_id = `oboro_forum_posts`.`owner_id` 
    LEFT JOIN `oboro_user_groups` AS `group` ON `user`.`forum_group_id` = `group`.`user_group_id`
    WHERE `blog_id`=?
', [$NRM->getParam(0)], "Forum");

if (!$DB->num_rows("Forum"))
	exit;

$row = $result->fetch();
echo $FNC->getDinamicForumTree($NRM->getParam(0), 'post');


$date = date_create($row['date_create']);
$lock = $row['lock'];
echo 
'
    <div class="row">
        <div class="col-12">
            <h4 class="title-forum">
				<div class="h4-container">
					<i class="fa fa-envelope-open" aria-hidden="true"></i> '. $row['title'] .' 
                	<span class="blog_subtitle">Started by <b>'.(!empty($row['display_name']) ? $row['display_name'] : $CONFIG->getConfig("uknown_user")) .'</b>, '. date_format($date, 'F Y') .'</span>
				</div>
            </h4>

            <div class="oboro_post oboro_as_table">
                <div class="row">
                    <div class="col-3 col-lg-user-info">
                        <div class="user-img-perfil">
                            <img src="'.($row['img_url'] ? $row['img_url'] : './img/banners/user-1.jpg').'" />

                            <div class="user-info-inside">
                                <div class="user-info-name">'.(!empty($row['display_name']) ? $row['display_name'] : $CONFIG->getConfig("uknown_user")).'</div>
                                <div class="user-info-group">
                                    <ul> 
                                        <li><a><center>'.$row['html_start']. $row['group_name']. $row['html_end']. '</center></a></li>
                                        <li><a href="#"><i class="fa fa-address-card-o" aria-hidden="true"></i> Visit profile</a></li>
                                        <li><a href="#"><i class="fa fa-envelope-open" aria-hidden="true"></i> Send message</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-9 user-text-container">
                        <div class="user-text">'.html_entity_decode($row['text_html']).'</div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        
        
';
// mostrar todos los comentarios a este post...

$result = $DB->execute("
    SELECT 
        `reply`.`account_id`, 
        `reply`.`date_create`, 
        `reply`.`text_html`, 
        `user`.`display_name`, 
        `user`.`img_url`,
        `group`.`html_start`,
        `group`.`html_end`,
        `group`.`group_name`
    FROM 
        `oboro_forum_user_reply` AS `reply` 
    LEFT JOIN `oboro_forum_user` AS `user` ON `user`.`account_id`=`reply`.`account_id`  
    LEFT JOIN `oboro_user_groups` AS `group` ON `user`.`forum_group_id` = `group`.`user_group_id`
    WHERE `subcategory_id`=?
", [$NRM->getParam(0)], "Forum");

while ($row = $result->fetch())
{
	echo
	'
            <div class="oboro_post oboro_as_table">
                <div class="row">
                    <div class="col-3 col-lg-user-info">
                        <div class="user-img-perfil">
                            <img src="'.($row['img_url'] ? $row['img_url'] : './img/banners/user-1.jpg').'" />

                            <div class="user-info-inside">
                                <div class="user-info-name">'.(!empty($row['display_name']) ? $row['display_name'] : $CONFIG->getConfig("uknown_user")).'</div>
                                <div class="user-info-group">
                                    <ul> 
                                        <li><a><center>'.$row['html_start']. $row['group_name']. $row['html_end']. '</center></a></li>
                                        <li><a href="#"><i class="fa fa-address-card-o" aria-hidden="true"></i> Visit profile</a></li>
                                        <li><a href="#"><i class="fa fa-envelope-open" aria-hidden="true"></i> Send message</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-9 user-text-container">
                        <div class="user-text">'.html_entity_decode($row['text_html']).'</div>
                        <div class="UserPostOptions">
                            <div class="btn-group" data-toggle="buttons">
                                <button class="btn btn-outline-secondary OnQuoted" data-enq-user="'.(!empty($row['display_name']) ? $row['display_name'] : $CONFIG->getConfig("uknown_user")).'" data-enq="'.$row['text_html'].'" type="button">Quote</button>
                                <input class="btn btn-outline-primary" type="button" value="Like it">
                                <input class="btn btn-outline-warning" type="submit" value="Report">
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>	
	';
	
}



echo '
        </div>
    </div>
';

if ($lock && !$FNC->isgm())
{
	echo 
	'
		<div class="row">
			<div class="col-lg-12">
				<div class="locked-forum-msg">This topic is now closed to further replies.</div>
			</div>
		</div>
	';
}
else
{
    
    if ($lock && $FNC->isgm())
	echo 
	'
		<div class="row">
			<div class="col-lg-12">
				<div class="locked-forum-msg">This topic is now closed to further replies.</div>
			</div>
		</div>
	';
echo '	
    <div class="row forum-oboro-newpost">
        <div class="col-12">
			<form class="oboro-post" data-catid="'.$NRM->getParam(0).'" data-opt="CREATEUSERPOST">
                <textarea name="content" id="editor">
                </textarea>
                <input type="submit" class="btn btn-primary" value="New Reply"/> 
			</form>
        </div>
    </div>
';
}