<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
              <li><a href="<?=$HOME?>"><?=$this->lang->line("nav_home")?></a></li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <div id="error-message-panel" class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=$this->lang->line("error")?></h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div id="warning" class="form-group bg-default">
                                <?php
                                    $errMsg = $this->lang->line("error_".$errCode);
                                    if ($errMsg == "" || $errMsg == null)
                                    {
                                        $errMsg = $this->lang->line("error_0");
                                    }
                                ?>
                                <p><?=$errMsg?></p>
                                <div class="form-group">
                                    <div class="col-sm-5 pull-right">
                                        <br>
                                        <button type="button" class="btn btn-default" onclick="goBack()"><?=$this->lang->line("form_back")?></button>
                                        <script>function goBack() {window.history.back();}</script>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>