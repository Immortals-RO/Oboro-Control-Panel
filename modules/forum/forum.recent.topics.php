<?php
echo
'		<h4 class="title-plugin"> Recent Topics</h4>
		<div class="row recent_topics_plugin text-muted">
';
			
$result = $DB->execute("
	SELECT 
		posts.title, 
        posts.owner_id, 
        posts.date_create, 
        posts.blog_id, 
        `user`.display_name, 
        `user`.img_url, 
        `cat`.category_name,
        `group`.`html_start`,
        `group`.`html_end`
	FROM
		oboro_forum_posts AS posts
	LEFT JOIN oboro_forum_user AS `user` ON `user`.account_id = posts.owner_id
	INNER JOIN oboro_forum_categories AS cat ON `cat`.category_id = posts.category
    LEFT JOIN `oboro_user_groups` AS `group` ON `user`.`forum_group_id` = `group`.`user_group_id`
	ORDER BY date_create DESC
	LIMIT 4
", [], "Forum");

while ($row = $result->fetch())
{
	echo 
	'
		<div class="row w-100">
			<div class="col-2 nopadding">
				<div class="oboro_forum_recent_post_user_img">
					<img src="'.($row['img_url'] ? $row['img_url'] : './img/banners/user-1.jpg').'" />
				</div>
			</div>
			<div class="col-10 nopadding">
				<div class="col-12"><b class="rem-plugin"><a href="?forum.post-'.$row['blog_id'].'">' . $FNC->shorter($row['title'], 25). '</a></b></div>
				<div class="col-12"><span class="subcategory-description">' . $row['category_name']. '</span></div>							
				<div class="col-12"><span class="subcategory-description">' . (!empty($row['display_name']) ? ($row['html_start'] . $row['display_name']. $row['html_end']) : $CONFIG->getConfig("uknown_user"))  . ' - '. date_format(date_create($row['date_create']), 'd M, Y').'.</span></div>
			</div>
		</div>
	';
}
			
echo '
			<div class="clearfix"></div>
		</div>
';
?>