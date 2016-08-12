<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?=$HOME?>"><?=$this->lang->line('nav_home')?></a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div id="resume-code-panel" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=$this->lang->line('resume_exam')?></h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" style="padding-top:20px;" method="post" action="<?=$TEST?>">
                        <div class="form-group">
                        <label for="test_code" class="col-sm-4 control-label pull-left"><?=$this->lang->line('resume_code')?></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="test_code" name="test_code" >
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-5 pull-right">
                            <br>
                            <button type="submit" class="btn btn-default"><?=$this->lang->line('form_submit')?></button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container -->