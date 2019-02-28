<?php
if ( !isset($_SESSION['level']) || $_SESSION['level'] < 99 || !$NRM->getParam(0))
	exit;

if (!empty($_POST['update'])) 
{
	$error = '';
	$consult = "UPDATE `login` SET ";
	foreach($_POST as $poc => $val)
	{
		if (in_array($poc,array("id_load", "http", "update", "account_id", "undefined")))
			continue;
		else
        {
			$consult .= ' `'.$poc.'`=?, ';
            array_push($param, $val);
        }
	}
	$consult = rtrim($consult, ', ');
	$consult .= " WHERE `account_id` = ". $NRM->getParam(0);
	$result = $DB->execute($consult, $param);
	if (!$result->rowCount())
		$error ='No changes applied';
	$DB->free($result);
}


$arr = $DB->ShowColumns('login');
if (!empty($error))
	echo '<div id="hideOboroAlert" class="alert alert-danger"><strong>Error!</strong> ' .$error. '.</div>';
else if (isset($_POST['update']) && empty($error))
	echo '<div id="hideOboroAlert" class="alert alert-success"><strong>&Eacute;xito!</strong> Usuario modificado exitosamente</div>';
?>

    <div class="row" id="ladder_div">
        <div class="col-lg-12">
            <h4 class="oboro_h4"><i class="fa fa-cogs fa-2x" style="vertical-align: middle;"> </i> <span> Administrating Account: <?php echo $NRM->getParam(0) ?></span></h4>
            <form method="post" action="?admin.account.edit-<?php echo $NRM->getParam(0); ?>">
                <table class='table table-hover table-light no-footer table-bordered table-striped table-condensed' id='OboroNDT'>
                    <?php
							$cont = 0;
							$consult = 'SELECT * FROM `login` WHERE `account_id`=?';
							$result = $DB->execute($consult, [$NRM->getParam(0)]);
							$row = $result->fetch();
							$DB->free($result);
							foreach($arr as $val)
							{		
								if ( $cont == 0 )
									echo '<tr>';
								
								echo '<td>'.$val.'</td>';
								echo '<td>'.$FNC->CDD($val, $row, $GV, $row[$val] ).'</td>';
								
								if ( $cont == 2 )
								{
									echo '</tr>';
									$cont = 0;
								} else 
									$cont++;
							}
						?>
                </table>
                <input type="hidden" name="update" value="1">
                <input type="submit" class="btn btn-primary float-right" value="Update">
            </form>
        </div>
    </div>
