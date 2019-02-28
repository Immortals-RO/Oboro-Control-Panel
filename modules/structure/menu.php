<?php
DEFINE ('USER_MENU', 0);
DEFINE ('ALL_MENU', -2);
DEFINE ('GMS_MENU', 99);

$mainmenu = array(
	array("Forum",		ALL_MENU,		"forum.cat",				0),
	array("Rankings",	ALL_MENU,		0,							0),
	array("Information",ALL_MENU,		0,							0),
	array("Item DB",	ALL_MENU,		"itemdb.form",				0),
	array("Vote",		USER_MENU,		"vote.points",				0),
	array("Donate",		USER_MENU,		0,							0),
	array("Admin",		GMS_MENU,		"admin.management",			0)
);

//$submenu("nombre"				"ubicacion",				$mainmenu);
$submenu = array(
	// Rankings
	array("WoE",				"rankings.woe",						1),
	array("BGs",				"rankings.bg",						1),
	array("PVP",				"rankings.pvp",						1),
	array("Exp",				"rankings.exp",						1),
	array("Guild",				"rankings.guild",					1),
	array("Zeny",				"rankings.zeny",					1),
	array("Hom",				"rankings.homunculus",				1),
	array("MVP",				"rankings.mvp",						1),
	array("PK",					"rankings.pk",				    	1),
	array("TK",					"rankings.tk",						1),
	array("Forja",				"rankings.forge",					1),
	array("Potion",				"rankings.potion",					1),
	array("Playtime",			"rankings.playtime",				1),
	array("Cash",				"rankings.cash",					1),
	array("BG Points",			"rankings.bgpoints",				1),

	// Información
	array("Name Changes",		"informacion.nameschange",			2),
	array("Who is online",		"informacion.whoisonline",			2),
	array("Families",			"informacion.family",				2),
	array("WoE Castles",		"informacion.castles",				2),
	array("MVP Cards",			"informacion.mvpcard",				2),
	array("Guild Pack",			"informacion.guildpack",			2),
	
	// Donations
	array("Donate",				"donation.info",					5),
	array("Donation Shop",		"donation.shop",					5),
);



echo '<ul class="navbar-nav ml-auto">';

foreach($mainmenu as $i => $menu )
{
	if( 
		$menu[1] == ALL_MENU || 
		(!empty($_SESSION['account_id']) && $menu[1] == USER_MENU ) ||
		(!empty($_SESSION['level']) && $_SESSION['level'] >= GMS_MENU && $menu[1] == GMS_MENU)  
	)
	{
		$head = 1;
		
		if ( !empty($menu[2]))
        {
			echo
            '
                <li class="nav-item">
                    <a class="OboroMenu" href="'.($menu[2][0] == "/" ? "" : "?").$menu[2].'">'.$menu[0].'</a>
                </li>
            ';
        } else {
			echo 
            '
				<li class="nav-item dropdown">
                    <a class="OboroMenu dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$menu[0]. ' <span class="caret"></span></a>
					<ul class="dropdown-menu multi-column columns-2" aria-labelledby="navbarDropdownMenuLink">
                        <div class="row">
                            <div class="col-sm-6 nopadding">
                                <ul class="multi-column-dropdown">
			';
			
            $columnCount = 0;
            $totalCol = 0;
            foreach($submenu as $j => $MenuSec)
                if ($submenu[$j][2] == $i)
                    $totalCol++;
            
			foreach($submenu as $j => $MenuSec)
            {
                if ($submenu[$j][2] != $i)
                    continue;
                if($columnCount == floor($totalCol/2))
                {
                    echo '
                                </ul>
                            </div>
                            <div class="col-sm-6 nopadding">
				                <ul class="multi-column-dropdown">
                    ';
                }
                
                echo '<li><a class="dropdown-item" href="?'.$MenuSec[1].'">'.$MenuSec[0].'</a></li>';
                $columnCount++;
            }
			echo '
                                </ul>
                            </div>
                        </div>
					</ul>
				</li>
	  		';
		}
	}
}
echo '</ul>';
?>