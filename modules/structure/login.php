<?php 
	if (empty($_SESSION['account_id']))
	{
?>
<div class="row">
    <div class="col-7 nopadding">
        <form class="w-100 OBOROBACKWORK padding-login-box">
            <table class="w-100">
                <tr>
                    <td class="login_title">
                        Let's get started
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="input-group login-input-margin">
                            <span class="input-group-addon"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                            <input type="text" name="user" class="form-control oboro_input oboro_input_fix" placeholder="Username" tabindex=1>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="input-group login-input-margin">
                            <span class="input-group-addon"><i class="fa fa-lock pad-fix" aria-hidden="true"></i></span>
                            <input type="password" name="pass" class="form-control oboro_input oboro_input_fix" placeholder="Password" tabindex=2>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" class="w-100 btn margarette" value="Log In" tabindex=3>
                    </td>
                </tr>
                <tr>
                    <td class="forgot_oboro"><a href="?account.recover">Forgot your password?</a></td>
                </tr>
            </table>
            <input type="hidden" name="OPT" value="LOGIN">
        </form>
        <div class="bottom-login-create">
            Don't have an account? <a href="?account.create" style="font-weight:bold;">Create your account here</a>
        </div>
    </div>
    <?php } ?>
    <div class="col-5 nopadding">
        <div class="bklogin">
            <div class="login-header">
                <i class="fa fa-window-close" id="on-close-login"></i>
            </div>
            <div class="login-footer">
                <div class="footer-preaty fb"><i class="fa fa-facebook"></i></div>
                <div class="footer-preaty gl"><i class="fa fa-google-plus"></i></div>
                <div class="footer-preaty yt"><i class="fa fa-youtube"></i></div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>