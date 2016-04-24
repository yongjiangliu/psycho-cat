<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?=$HOME?>"><?=$lang->line("nav_home")?></a></li>
          </ul>
        </div>
        <!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container-fluid">
      <form id="adminLogin" class="form-horizontal" method="post" action="<?=$ADMIN?>/check">
      <?php
          $style = "";
          if (!$loginFailed)
          {
            $style="style='display:none;'";
          }
      ?>
        <div class="alert alert-danger" role="alert" <?=$style?>>
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
                <?=$lang->line("form_error")?>
        </div>
        <!-- username -->
        <div class="form-group">
          <label for="username" class="col-sm-2 control-label"><?=$lang->line("form_username")?></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="username" name="username">
          </div>
        </div>
        <!-- password -->
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label"><?=$lang->line("form_password")?></label>
            <div class="col-sm-10">
              <input type="password" class="form-control" id="password" name="password">
            </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default"><?=$lang->line("form_login")?></button>
          </div>
        </div>
        </form>
      </div>
    </div>
    <!-- /.container -->
