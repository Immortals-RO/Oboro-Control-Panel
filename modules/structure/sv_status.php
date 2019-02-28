<div class="server_status">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-sm-12 nopadding">
				<ul class="ServerStatus">
					<li style="color:#0bafb5;"> Server Status<i>!</i> </li>
					<li><i class="fa <?php echo $FNC->ServerStatus(); ?>"></i></li>
					<li>Time: <span id="getTime"><?php echo $FNC->GetTime(); ?></span></li>
					<li>WoE:
						<?php echo $FNC->getWoeStatus(); ?>
					</li>
					<li>Peak: <span id="getPick"><?php echo $FNC->getUserOnline(1); ?></span></li>
					<li>Online: <span id="user_online"><a href="?informacion.whoisonline" style="color:inherit;"><?php echo $FNC->getUserOnline(0); ?></a></li>
				</ul>
			</div>
			<div class="col-lg-4 col-sm-12 nopadding" align="right">
				<ul class="oboro_login_ul">
					<?php if (empty($_SESSION['account_id'])) { ?>
					<li>
						<a id="ShowLoginForm">Sign in</a></li>
					<li>
						<a href="?account.create">Create Account</a>
					</li>
					<?php } else { ?>

					<li><a href="?account.info"><i class="fa fa-user-circle" aria-hidden="true"></i> <?php echo $_SESSION['userid'] ?></a></li>
					<li>
						<a href="?donation.info"><i class="fa fa-cart-plus" aria-hidden="true"></i> 
								<?php
									$consult = 
									"
										SELECT 
											`value` 
										FROM 
											".
												($FNC->get_emulator() == EAMOD ? 
													"`global_reg_value` WHERE `str`='".$CONFIG->getConfig('PayPal-Points')."'" :
													"`acc_reg_num` WHERE `key`='".$CONFIG->getConfig('PayPal-Points')."'"
												)
											."
										AND 
											account_id = ?
									";
							  		$result = $DB->execute($consult, [$_SESSION['account_id']]);
									if ($row = $result->fetch())
										$value = $row['value'];
							  		else
										$value = 0;
									$DB->free($result);
							  		
							  		echo '' .$value.' .Dps';
							  	?>
								</a>
					</li>
					<li class="SignOut"><a href="index.php?session_destroy=true">Sign Out</a></li>

					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>