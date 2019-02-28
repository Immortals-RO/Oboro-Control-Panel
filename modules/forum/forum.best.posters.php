<?php
echo
'
    <h4 class="title-plugin">Top Spamers</h4>
	<div class="row recent_topics_plugin .text-muted">
';
			
$result = $DB->execute("
	SELECT 
		COUNT(posts.owner_id) AS `total`, 
        `user`.display_name,
        `user`.img_url,
        `group`.`html_start`,
        `group`.`html_end`
	FROM
		oboro_forum_posts AS posts
	INNER JOIN oboro_forum_user AS `user` ON `user`.account_id = posts.owner_id
    LEFT JOIN `oboro_user_groups` AS `group` ON `user`.`forum_group_id` = `group`.`user_group_id`
	GROUP BY `posts`.`owner_id`
	LIMIT 4
", [], "Forum");

$cont = 0;
while ($row = $result->fetch())
{
	$cont++;
	echo 
	'
		<div class="row w-100">
			<div class="col-1 nopadding ">'.$cont.'</div>
			<div class="col-2 nopadding">
				<div class="oboro_forum_recent_post_user_img">
					<img src="'.($row['img_url'] ? $row['img_url'] : './img/banners/user-1.jpg').'" />
				</div>
			</div>
			<div class="col-9 nopadding">
				<div class="col-12"><b class="rem-plugin">'. $row['html_start'] . $row['display_name']. $row['html_end'] .'</b></div>
				<div class="col-12"><span class="subcategory-description">Total posts: ' . $row['total']. '</span></div>							
			</div>
		</div>
	';
}
			
echo '
		<div class="clearfix"></div>
	</div>
';
?>