<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
              <li><a href="<?=$HOME?>"><?=$lang->line("nav_home")?></a></li>
          </ul>
          <div class="navbar-right" >
            <ul class="nav navbar-nav">
              <li>
                <a href="https://github.com/bclicn/PsychTest/issues" target="_blank">
                <img src="<?=$IMG?>/icon_github.png" alt="GitHub" class="img-rounded" style="padding:0px; margin:0px;">&nbsp;&nbsp;<?=$lang->line("nav_github_issue")?>
                </a>
              </li>
            </ul>
          </div>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container-fluid">
      <form class="form-horizontal">
        <!-- Test code -->
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
                <?=$errorMsg?>
            <p>&nbsp;</p>
                <button type="button" class="btn btn-default" onclick="goBack()"><?=$lang->line("back")?></button>
        </div>
            <script>
              function goBack() {
                  window.history.back();
              }
            </script>
        </form>
      </div>
    </div><!-- /.container -->
