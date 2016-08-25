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
<?php
    $panelTitle;
    $disabled;
    $code;
    if ($resume_code != null)
    {
        $panelTitle = $this->lang->line('exam_ready');
        $disabled = "disabled";
        $code = $resume_code;
    }
    else
    {
        $panelTitle = $this->lang->line('exam_resume');
        $disabled = "";
        $code = "";
    }
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div id="resume-code-panel" class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?=$panelTitle?></h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="<?=$EXAM?>">
                        <?php
                        if ($errCode != -1)
                        {
                            echo "<p class='bg-danger'><strong>".$this->lang->line("error_".$errCode)."</strong></p>";
                            echo "<br>";
                        }
                        ?>
                        <div class="form-group">
                            <label for="resume_code" class="col-sm-4 control-label pull-left"><?=$this->lang->line('resume_code')?></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="resume_code" name="resume_code" <?=$disabled?> value="<?=$code?>" required>
                            </div>
                            <div class="col-sm-2"></div>
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