<div class="card-group">
   
    <?php
		$consult = 
		"
			SELECT 
				`char`.`name`, 
                `char`.`class`,
                `login`.`sex`, 
                `guild`.`name` AS gname,
                `oboro_pvp`.`kill`+00000 as `score`
			FROM `char` 
			INNER JOIN 	`oboro_pvp` ON `char`.`char_id` = `oboro_pvp`.`char_id` 
			INNER JOIN `login` ON `login`.`account_id` = `char`.`account_id`
			LEFT JOIN `guild` ON `guild`.char_id = `char`.`char_id`
			ORDER BY 
				(`oboro_pvp`.`kill`+000) DESC 
			LIMIT 1
			";
			$result = $DB->execute($consult);
			$row = $result->fetch();
    ?>
    <div class="card">
        <div class="img-container"> <img class="card-img-top" src="./images/class/<?php echo $row['sex'] . '/' . $row['class'] .'.png'?>" alt="No image found">
        </div>
        <div class="card-block">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>Name: </b> <?php echo (isset($row["name"]) ? $row["name"] : 'none') ?></li>
                <li class="list-group-item"><b>Guild: </b> <?php echo (isset($row["gname"]) ? $row["gname"] : 'none') ?></li>
                <li class="list-group-item"><b>Score: </b><?php echo (isset($row["score"]) ? $row["score"] : '-') ?> pts.</li>
            </ul>
        </div>
        <div class="card-footer">
            <small class="text-muted">Best 1 vs 1 Player</small>
        </div>
    </div>
    
 	<?php
        $consult =
        "
            SELECT 
               `char`.`name`, `login`.`sex`, `char`.`class`, `CWS`.`kill_count`, `guild`.`name` AS `gname` 
            FROM `char`
            INNER JOIN `char_wstats` AS `CWS` ON `CWS`.`char_id` = `char`.`char_id`
            INNER JOIN `login` ON `login`.`account_id` = `char`.`account_id`
            LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id` 
            ORDER BY 
                `CWS`.`kill_count` 
            DESC LIMIT 1		
        ";
        $result = $DB->execute($consult);
        $row = $result->fetch();
    ?>
				   
    <div class="card">
        <div class="img-container"> <img class="card-img-top" src="./images/class/<?php echo $row['sex'] . '/' . $row['class'] .'.png'?>" alt="No image found">
        </div>
        <div class="card-block">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>Name: </b> <?php echo (isset($row["name"]) ? $row["name"] : 'none') ?></li>
                <li class="list-group-item"><b>Guild: </b> <?php echo (isset($row["gname"]) ? $row["gname"] : 'none') ?></li>
                <li class="list-group-item"><b>Score: </b><?php echo (isset($row["kill_count"]) ? $row["kill_count"] : '-') ?> pts.</li>
            </ul>
        </div>
        <div class="card-footer">
            <small class="text-muted">Best WOE Player</small>
        </div>
    </div>
    
    <?php
        $consult = 
        "
			SELECT 
				`char`.`name`, `login`.`sex`, `char`.`class`, `CWS`.`kill_count`, `guild`.`name` as gname
			FROM `char` 
			INNER JOIN `char_bg` AS `CWS` ON `CWS`.`char_id` = `char`.`char_id` 
			INNER JOIN `login` ON `login`.`account_id` = `char`.`account_id` 
			LEFT JOIN `guild` ON `guild`.`guild_id` = `char`.`guild_id` 
			ORDER BY 
				`CWS`.`kill_count` DESC 
			LIMIT 1
        ";
        $result = $DB->execute($consult);
        $row = $result->fetch();
    ?>
    <div class="card">
        <div class="img-container"> <img class="card-img-top" src="./images/class/<?php echo $row['sex'] . '/' . $row['class'] .'.png'?>" alt="No image found">
        </div>
        <div class="card-block">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>Name: </b> <?php echo (isset($row["name"]) ? $row["name"] : 'none') ?></li>
                <li class="list-group-item"><b>Guild: </b> <?php echo (isset($row["gname"]) ? $row["gname"] : 'none') ?></li>
                <li class="list-group-item"><b>Score: </b><?php echo (isset($row["kill_count"]) ? $row["kill_count"] : '-') ?> pts.</li>
            </ul>
        </div>
        <div class="card-footer">
            <small class="text-muted">Battleground Kill Spam</small>
        </div>
    </div>
</div>
