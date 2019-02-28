<?php
$result  = $DB->execute("
SELECT 
        `shout`.`shout_id`, 
        `shout`.`account_id`, 
        `shout`.`shout_text`, 
        `shout`.`date_create`, 
        `user`.`display_name`, 
        `user`.`img_url`,
        `group`.`html_start`,
        `group`.`html_end`
    FROM `oboro_forum_shoutbox` AS `shout` 
    INNER JOIN `oboro_forum_user` AS `user` ON `user`.`account_id` = `shout`.`account_id`
    LEFT JOIN `oboro_user_groups` AS `group` ON `user`.`forum_group_id` = `group`.`user_group_id`
    ORDER BY `shout_id` DESC LIMIT 20
", [], "Forum");

while ($row = $result->fetch())
{
	echo '
		<tr>
			<td>
				<div class="oboro_forum_shoutbox_user_img">
					<img src="'.($row['img_url'] ? $row['img_url'] : './img/banners/user-1.jpg').'" />
				</div>
				<span class="shoutbox_user_name">'. $row['html_start'] . $row['display_name']. $row['html_end'] .'</div>
			</td>
			<td>
				'.$row['shout_text'].'
			</td>
			<td>
				<span class="shoutbox-time">' .date_format(date_create($row['date_create']), 'd M, Y H:i:s'). '</span>
			</td>
		</tr>
	';
}

?>