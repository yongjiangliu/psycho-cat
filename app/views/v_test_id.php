<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
              <li><a href="<?=$HOME?>"><?=$lang->line("nav_home")?></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container-fluid">
      <form id="testCode" class="form-horizontal" method="post" action="<?=$TEST?>">

        <!-- Test code -->
        <!--<div id="warning" class="form-group bg-info"> -->
          <?php
            $buttonVal        = "";
            $test_id_val      = "";
            $readOnly         = "";
            $message          = "";

            if ($status == "out")
            {
              $message        = $lang->line("form_test_id_hint");
              $test_id_val    = "value='".$test_id."'";
              $readOnly       = "readonly";
              $buttonVal      = $lang->line("form_continue");
            }
            else if ($status == "in")
            {
              $test_id_val    = "";
              $buttonVal      = $lang->line("form_submit");
            }
            else
            {
              $message        = $lang->line("form_invalid_status").$status;
              $test_id_val    = "";
              $buttonVal      = $lang->line("form_submit");
            }
          ?>
        <div class="form-group">
          <label for="test_id" class="col-sm-4 control-label">
            <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            <?=$lang->line("form_test_id")?>
          </label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="test_id" name="test_id" <?=$test_id_val?> <?=$readOnly?> >
          </div>
        </div>
        <div class="form-group">
          <?=$message?>
        </div>
        <div class="form-group" style="text-align:right; padding:5px;">
          <div class="col-sm-7">
            <button type="submit" class="btn btn-default"><?=$buttonVal?></button>
          </div>
        </div>
        </form>
    </div>
    <!-- /.container -->
