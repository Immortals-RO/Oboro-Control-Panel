<?php
if (!isset($_SESSION['account_id']) || empty($_SESSION['account_id'])) 
	exit;
	
$consult =
"
	SELECT 
		`login`.`userid`,`login`.`user_pass`,`login`.`email`,`login`.`state`,`login`.`sex`,`login`.`lastlogin`,`login`.`last_ip`, `login`.`pais`
	FROM 
		`login` 
	WHERE 
		`account_id` = ?
";

$result = $DB->execute($consult, [$_SESSION['account_id']]);
$row = $result->fetch();
$DB->free($result);
$jobs = $_SESSION['jobs'];
$date = date_create($row['lastlogin']);

$forum_disp = $DB->execute("SELECT `display_name`, `img_url` FROM `oboro_forum_user` WHERE `account_id`=?", [$_SESSION['account_id']], "Forum")->fetch();

?>

    <div class="row">
        <div class="col-lg-3 nopadding oboro-divs-container">
            <div class="user-img-perfil">
                <img src="<?php echo ($forum_disp['img_url'] ? $forum_disp['img_url'] : './img/banners/user-1.jpg'); ?>" />
            </div>


            <form class="IMGURAPIWIN">
                <input name="img" id="fileimgInput" size="35" type="file" /><br/>
                <input type="submit" name="submit" class="btn btn-success" value="Upload" />
            </form>

            <form class="OBOROBACKWORK">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <div class="input-group-addon">Account</div>
                            <input name="cuenta" class="form-control" type="text" value="<?php echo $row['userid'] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <div class="input-group-addon">Gender</div>
                            <?php 
                                        echo $FNC->CDD('sex', $row, $GV, '');
                                    ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <div class="input-group-addon">Mail</div>
                            <input name="cuenta" class="form-control" type="text" value="<?php echo $row['email'] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <div class="input-group-addon">Last IP</div>
                            <input name="cuenta" class="form-control" type="text" value="<?php echo $row['last_ip'] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <div class="input-group-addon">Last Login</div>
                            <input name="cuenta" class="form-control" type="text" value="<?php echo date_format($date, 'F, Y') ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <div class="input-group-addon">Display Name</div>
                            <input name="dispname" class="form-control" type="text" value="<?php echo $forum_disp['display_name'] ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <div class="input-group-addon">Country</div>
                            <?php echo $FNC->CDD('pais', $row, $GV, ''); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <input type="hidden" name="OPT" value="ACCOUNTPANEL">
                        <input type="submit" class="btn btn-success w-100" value="Update Basic Information">
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-9">
            <div class="row">

                <h4 class="oboro_h4"><i class="fa fa-user-circle" aria-hidden="true"></i>
                    <?php echo $_SESSION['userid']; ?> Account & Char's Settings</h4>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <form class="OBOROBACKWORK">
                        <div class="card">
                            <div class="card-heading">
                                <div class="row card-oboro-heading">
                                    <div class="col-11 card-title">
                                        <i class="fa fa-tasks"></i> Password Reset
                                    </div>
                                    <div class="col-1">
                                        <div class="btn btn-secondary btn-cierra">
                                            <i class="fa fa-window-restore" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="card-block" style="display:none;">
                                <table class='table table-hover table-light no-footer table-bordered table-striped table-condensed' id="">

                                    <tbody>
                                        <tr>

                                            <td><input class="form-control" type="password" name="oldpassword" placeholder="Old password"></td>
                                            <td><input type="password" class="form-control" name="newpassword" placeholder="New password"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="recoverSec" /> Recover security Code</td>
                                            <td>
                                                <input type="hidden" name="OPT" value="CHANGEPASSWORDPANEL">
                                                <input type="submit" class="btn btn-primary" value="Update Information">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php
                $consult = "
                    SELECT 
                        `loginlog`.`time`, `loginlog`.`ip`, `loginlog`.`user`, `loginlog`.`log`, `loginlog`.`mac`
                    FROM
                        `loginlog`
                    INNER JOIN
                        `login` ON `login`.`userid` = `loginlog`.`user`
                    WHERE
                        `login`.`account_id`=?
                ";
                $result = $DB->execute($consult, [$_SESSION['account_id']]);
            ?>

                <div class="row">
                    <div class="col-lg-12">
                        <form class="ipform">
                            <div class="card">
                            <div class="card-heading">
                                <div class="row card-oboro-heading">
                                    <div class="col-11 card-title">
                                        <i class="fa fa-tasks"></i> Information Security
                                    </div>
                                    <div class="col-1">
                                        <div class="btn btn-secondary btn-cierra">
                                            <i class="fa fa-window-restore" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                                <div class="card-block" style="display:none;">
                                    <table class='table table-hover table-light no-footer table-bordered table-striped table-condensed' id="OboroDT">
                                        <thead>
                                            <th>Date</th>
                                            <th>User</th>
                                            <th>Int. Prot.</th>
                                            <th>MAC Addrs.</th>
                                            <th>Log</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                        while( $row = $result->fetch())
                                        {
                                            echo '
                                                <tr>
                                                    <td>'.$row["time"].'</td>
                                                    <td>'.$row["userid"].'</td>
                                                    <td>'.$row["ip"].'</td>
                                                    <td>'.$row["mac"].'</td>
                                                    <td>'.$row["log"].'</td>
                                                </tr>
                                            ';
                                        }
                                        $DB->free($result);
                                    ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <?php 
            if ($CONFIG->getConfig('UseGeoLocalization') == 'yes') 
            {
                $consult = "SELECT `geo_localization`, `question`, `question_response` FROM `login` WHERE `account_id`=?";
                $result = $DB->execute($consult, [$_SESSION['account_id']]);
            ?>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-heading">
                                <div class="row card-oboro-heading">
                                    <div class="col-11 card-title">
                                        <i class="fa fa-tasks"></i> Geolocalization Management
                                    </div>
                                    <div class="col-1">
                                        <div class="btn btn-secondary btn-cierra">
                                            <i class="fa fa-window-restore" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="card-block" style="display:none;">
                                <form class="OBOROBACKWORK">
                                    <table class='table table-hover table-light no-footer table-bordered table-striped table-condensed' id="OboroNDT">
                                        <thead>
                                            <th>User From</th>
                                            <th>Question Sec.</th>
                                            <th>Answer</th>
                                            <th>Update Security</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if ($DB->num_rows())
                                                {
                                                    $row = $result->fetch();
                                                    $DB->free($result);
                                                    echo '
                                                        <tr>
                                                            <td>'.$row["geo_localization"].'</td>
                                                            <td>'.$FNC->CDD("question", $row, $GV, $row["question"]).'</td>
                                                            <td>'.$FNC->C_INPUT("text", "", "form-control", "question_response_update", $row["question_response"], "Please input a secure information") .'</td>
                                                            <td>
                                                                <input type="hidden" name="OPT" value="UPDATE_GEO_INFO">
                                                                <input type="submit" value="Update" class="btn btn-primary w-100">
                                                            </td>
                                                        </tr>
                                                    ';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php 
            }

            $consult = "SELECT `char_id`,`name`, `zeny`, `class`, `char_num`, `last_map`,`partner_id` FROM `char` WHERE `account_id` = ? and `online`=0";
            $result = $DB->execute($consult, [$_SESSION['account_id']]);
            ?>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-heading">
                                <div class="row card-oboro-heading">
                                    <div class="col-11 card-title">
                                        <i class="fa fa-tasks"></i> Champions Information Sys.
                                    </div>
                                    <div class="col-1">
                                        <div class="btn btn-secondary btn-cierra">
                                            <i class="fa fa-window-restore" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="card-block">
                                <table class='table table-hover table-light no-footer table-bordered table-striped table-condensed Form_in_table' id="OboroNDT">
                                    <thead>
                                        <tr>
                                            <th style="width:11.2%;">Class</th>
                                            <th style="width:17%;">Change Name</th>
                                            <th style="width: 11.2%;">Divorce</th>
                                            <th style="width:16%;">Slot</th>
                                            <th style="width:11%;">Current Map</th>
                                            <th style="width:11%;">Map Crash</th>
                                            <th style="width:11%;">Char Crash</th>
                                            <th>Update</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                    $consult="SELECT `char_id`,`char_num` FROM `char` WHERE `account_id`=?";
                                    $result2 = $DB->execute($consult, [$_SESSION['account_id']]);
                                    $cid = array();
                                    $cnum = array();

                                    while ($row = $result2->fetch()) 
                                        array_push($cnum, $row["char_num"]);
                                    $DB->free($result2);	

                                    while ($row = $result->fetch())
                                    {

                                        echo '
                                            <tr><td colspan="8" class="nopadding">
                                                <form class="OBOROBACKWORK">
                                                    <table class="table table-hover table-light no-footer table-bordered table-striped table-condensed Form_in_table" id="OboroNDT">
                                                        <tr>
                                                            <td>'.$jobs[$row["class"]].'</td>
                                                            <td style="width:17%;"><input name="nn" class="form-control" type="text" value="'.$row["name"].'"></td>
                                                            <td>'.($row["partner_id"] > 0 ? '<input type="checkbox" name="divorse" /> Divorse' : 'Single').'</td>
                                                            <td class="fix_selectpicker_width">
                                                                <select name="slot" class="selectpicker">
                                                                      <optgroup label="available fields">			
                                        ';
                                                                        for ( $i = 0; $i < 14; $i++ )
                                                                        {
                                                                            if (in_array($i, $cnum) && $row["char_num"] != $i )
                                                                                continue;
                                                                            else
                                                                                echo '<option value="'.$i.'"'.($row["char_num"] == $i ? 'selected':'').'>'.$i;
                                                                        }
                                        echo '
                                                                    </optgroup>
                                                                </select>
                                                                <div class="clearfix"></div>
                                                            </td>
                                                            <td>'.$row["last_map"].'</td>
                                                            <td><input type="checkbox" name="reset_map" /> Reset</td>
                                                            <td><input type="checkbox" name="reset_char" /> Reset</td>
                                                            <td>
                                                                <input type="hidden" name="OPT" value="CHARPANEL">
                                                                <input type="hidden" name="cid" value="'.$row['char_id'].'">
                                                                <input type="submit" class="btn btn-primary" value="Update">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </td></tr>
                                        ';
                                    }
                                    $DB->free($result);
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </div>
