<div class="row">
    <div id="oboroSlider" class="carousel slide" data-ride="carousel">
        <ul class="carousel-indicators">
            <li data-target="#oboroSlider" data-slide-to="0" class="active"></li>
            <li data-target="#oboroSlider" data-slide-to="1"></li>
            <li data-target="#oboroSlider" data-slide-to="2"></li>
        </ul>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://www.w3schools.com/bootstrap4/la.jpg" alt="Los Angeles" width="1100" height="500">
                <div class="carousel-caption">
                    <h3>Los Angeles</h3>
                    <p>We had such a great time in LA!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://www.w3schools.com/bootstrap4/chicago.jpg" alt="Chicago" width="1100" height="500">
                <div class="carousel-caption">
                    <h3>Chicago</h3>
                    <p>Thank you, Chicago!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://www.w3schools.com/bootstrap4/ny.jpg" alt="New York" width="1100" height="500">
                <div class="carousel-caption">
                    <h3>Let's rock with Nanosoft 2k18</h3>
                    <p>Our new CP makes our competence looks ugly</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#oboroSlider" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
        <a class="carousel-control-next" href="#oboroSlider" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="server_info">
            <ul class="nav nav-tabs">
                <li class="nav-item active">
                    <a data-roll="latestnews">Latest News</a>
                </li>
                <li class="nav-item">
                    <a data-roll="svinfo">Server Information</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="latestnews" class="tab-pane fade in active">
                    <?php
						$result = $DB->execute("SELECT `blog_id`, `date_create`, `title`, `user`.`display_name` FROM `oboro_forum_posts` AS `posts` LEFT JOIN `oboro_forum_user` AS `user` ON `user`.`account_id`=`posts`.`owner_id` ORDER BY `blog_id` ASC", [], "Forum");
						if ($DB->num_rows("Forum"))
						{
							echo 
							'
								<div class="row">
									<div class="col-lg-12 nopadding">
										<table class="table table-hover table-light no-footer table-striped" id="OboroNews">
										<thead>
											<tr>
												<th>Created</th>
												<th class="w-50">Title</th>
												<th>Owner</th>
												<th>Read</th>
											</tr>
										</thead>
										<tbody>
								';
								while ($row = $result->fetch())
								{
									echo 
									'
										<tr>
											<td>'.date_format(date_create($row['date_create']), 'd M, Y').'</td>
											<td>'.$row['title'].'</td>
											<td>'.(!empty($row['display_name']) ? $row['display_name'] : $CONFIG->getConfig("uknown_user")).'</td>
											<td>
                                            	<a href="?forum.post-'.$row['blog_id'].'" class="btn btn-secondary btn-table-fullwidth">View</a>
											</td>
										</tr>
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
                </div>
                <div id="svinfo" class="tab-pane fade">
                    <p style="text-align:center;">
                        <br/> Somos un servidor privado de <strong>Ragnarök Online </strong>en el cual podrás jugar de forma totalmente gratuita. Con apertura en diciembre del 2016, <strong>xRO</strong> vuelve renovándose con una nueva edición en la cual esperamos que lo pasen genial con nosotros y disfruten de nuestro servidor.
                        <br/>
                        <img alt="brScVhV.png" src="http://i.imgur.com/brScVhV.png" />
                        <br/>
                    </p>

                    <ul>
                        <li>Pre-Renewal</li>
                        <li>NO 3° Jobs</li>
                        <li>Rates: 250x/250x/100x</li>
                        <li>Max Lvl. 99/70</li>
                        <li>Battleground 2.0</li>
                        <li>War of Emperium 2.0</li>
                        <li>Card: 1%</li>
                        <li>MVP Card: 0.01%</li>
                        <li>Max ASPD 190</li>
                        <li>Harmony Shield</li>
                        <li>Anti-Cheats system</li>
                        <li>Emulador rAthena</li>
                        <li>Control Panel OBORO</li>
                        <li>Guild Pack rental system - MAX CAP GUILD 30.</li>
                        <li>Soporte: Español / English</li>
                        <li>Localización del Servidor: Los Angeles, USA.</li>
                        <li>Horario del servidor: New York GMT -5.</li>
                        <li>xROcita costumes items</li>
                        <li>Salas especiales (hats, consumibles, etc)</li>
                        <li>Bloody branch Quest</li>
                        <li>Donaciones directas por control panel</li>
                        <li>Eventos de GM con premios exclusivos</li>
                        <li>Warper con niveles y Healer</li>
                        <li>Rental NPC</li>
                        <li>Job Master</li>
                        <li>Estilista</li>
                        <li>Etc...</li>
                    </ul>

                    <p style="text-align:center;"><span style="font-size:24px;">Enjoy<strong><em>!</em></strong></span></p>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-12 nopadding">
           <?php include_once("home.ranking.php"); ?>
        </div>
    </div>

    <div class="col-lg-4">

        <div class="row">
            <div class="col-lg-12 nopadding">
                <h4 class="title-plugin">War Of Emperium</h4>
                <table class="table tableOb table-border">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Type</th>
                            <th>Start</th>
                            <th>Finish</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
								foreach($CONFIG->WOESCHDL as $poc => $arr )
								{
									echo '<tr>';
										foreach ($arr as $val )
											echo '<td>'.$val.'</td>';
									echo '</tr>';
								}
							?>
                    </tbody>
                </table>
            </div>

            <div class="col-lg-12 col-12 nopadding">
                <a href="<?php echo $CONFIG->getConfig('link_descargas'); ?>" target="_blank">
                    <div class="oboro_links oboro_descargas"></div>
                </a>
            </div>
            
            <div class="list-group w-100">
                <h4 class="title-plugin">Usefull Links</h4>

                <a href="#informacion.guildpack" class="list-group-item">
                    <i class="fa fa-comment fa-fw"></i> Guild Pack
                </a>
                <a href="<?php echo $CONFIG->getConfig('link_svinfo'); ?>" target="_blank" class="list-group-item">
                    <i class="fa fa-twitter fa-fw"></i> Server Information
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-envelope fa-fw"></i> Server Rules
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-tasks fa-fw"></i> Rate Us<i>!</i>
                </a>
            </div>
        </div>
    </div>
</div>
