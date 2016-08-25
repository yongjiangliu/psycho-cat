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
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div id="resume-code-panel" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=$this->lang->line('exam_tip_title')?></h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="<?=$EXAM?>/next">
                        <div class="form-group">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <p><?=$this->lang->line('exam_tip')?></p>
                                <input type="hidden" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 pull-right">
                                <br>
                                <button type="submit" class="btn btn-default"><?=$this->lang->line('exam_start')?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>