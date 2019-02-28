<?php
session_start();
if (isset($_GET['session_destroy']) && $_GET['session_destroy'] == 'true')
{
	session_destroy();
	header('Location: index.php');
}

if (!file_exists('libs/config.php'))
{
	header('Location: modules/install/installer.php');
	exit;
}

require_once('libs/controller.php');

$time = explode(' ', microtime());
$start = $time[1] + $time[0];
?>

    <!DOCTYPE html>
    <html lang="en">
    <?php include_once('modules/structure/header.php'); ?>

    <body class="bg-light">
        <div class="loader">
            <img src="img/ajax_loading.gif" alt="Loading...">
        </div>

        <div class="all_container"></div>


        <?php include_once('modules/structure/sv_status.php'); ?>
        <div class="responsiveMenu">
<div class="container">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="<?php echo $CONFIG->getConfig('Web'); ?>">
                            <div class="logo"></div>
                            <span class="logotext">Nanosoft CP <span class="sublogotext">2k18 &copy;</span></span>
                        </a>
                        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" 
                                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse bg-white" id="navbarSupportedContent">
                            <?php include_once('modules/structure/menu.php'); ?>
                        </div>
                    </nav>
            </div>
        </div>


        <div class="top-header-back">
            <div class="rM top-header-container">
                <div class="top-header-banner"><span style="font-weight:300;">Nanosoft</span> <b>2k07 - 2k19</b> &copy;<br/> <span class="top-header-banner-sub">Nanosoft Game Corner - Dev'ed by Isaac</span></div>
            </div>
        </div>

        <div class="login_box">
            <?php include_once('modules/structure/login.php'); ?>
        </div>
        <div class="container fix-wrapper-mono">
            <div id="main_div">
                <?php
				include_once($NRM->IncludeModule());
				?>
            </div>
            <?php //include_once('modules/structure/ranking.footer.php'); ?>
        </div>
        <?php include_once('modules/structure/footer.php'); ?>
    </body>

    </html>
