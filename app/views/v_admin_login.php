<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?=$HOME?>"><?=$this->lang->line('nav_home')?></a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <form id="admin-login-form" class="form-horizontal" method="post" action="<?=$ADMIN?>/check">
        <?php
        $errMsg = $this->lang->line("error_".$errCode);
        if ($errMsg != "" && $errMsg != null)
        {
            echo '<div class="alert alert-danger" role="alert">';
            echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
            echo '<span class="sr-only">Error</span>';
            echo '&nbsp;&nbsp;';
            echo  $errMsg;
            echo "</div>";
        }
        else
        {
            echo "";
        }
        ?>
        <div class="form-group">
          <label for="username" class="col-sm-3 col-md-3 col-lg-3 control-label"><?=$this->lang->line('admin_user')?></label>
          <div class="col-sm-9 col-md-9 col-lg-9">
            <input id="username" type="text" class="form-control" id="username" name="username" required>
          </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-3 col-md-3 col-lg-3 control-label"><?=$this->lang->line('admin_pass')?></label>
            <div class="col-sm-9 col-md-9 col-lg-9">
              <input id="password" type="password" class="form-control" id="password" name="password" required>
            </div>
        </div>
          <div class="form-group">
              <label for="captcha" class="col-sm-3 col-md-3 col-lg-3 control-label"><?=$this->lang->line('form_captcha')?></label>
              <div class="col-sm-5 col-md-5 col-lg-5" id="captcha_container" title="<?=$IMG?>/loading.gif">
                  <?php echo $captcha?>
              </div>
              <div class="col-sm-3 col-md-3 col-lg-3">
                  <input type="text" class="form-control" id="captcha" name="captcha" required>
              </div>
              <div id="refresh_captcha" class="col-sm-1 col-md-1 col-lg-1" style="margin-top:10px;" title="<?=$ADMIN?>/getCaptcha">
                  <a href="#"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span></a>
              </div>
          </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-10"">
            <button id="login_btn" type="submit" class="btn btn-default"><?=$this->lang->line('admin_login')?></button>
          </div>
        </div>
        </form>
      </div>
    </div>