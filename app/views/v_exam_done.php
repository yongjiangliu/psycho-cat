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
    <div class="container-fluid" style="min-height:300px;">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <div id="exam-done-panel" class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?=$this->lang->line("exam_done")?></h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="GET" action="<?=$HOME?>">
                            <div class="form-group bg-default">
                                <p><?=$this->lang->line("exam_time_used")?></p>
                                <div class="form-group">
                                    <div class="col-sm-5 pull-right">
                                        <br>
                                        <button type="submit" class="btn btn-default"><?=$this->lang->line("nav_home")?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>