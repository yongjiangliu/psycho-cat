<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="navbar" class="collapse navbar-collapse">
  <ul class="nav navbar-nav">
    <li><a href="<?=$HOME?>"><?=$this->lang->line("nav_home")?></a></li>
    <li class="active"><a><?=$this->lang->line("subject_name")?>:&nbsp;<?=$exam['subject_name']?></a></li>
    <li class="active"><a><?=$this->lang->line("question_progress")?>:&nbsp;<?=$question['question_id']?>/<?=$count?></a></li>
    <li class="active">
      <a>
          <?=$this->lang->line("question_type")?>:&nbsp;
          <?php
            switch ($question['question_type'])
            {
                case 'sc' : echo $this->lang->line("question_type_sc"); break;
                case 'mc' : echo $this->lang->line("question_type_mc"); break;
                case 'jd' : echo $this->lang->line("question_type_jd"); break;
                default: echo "NULL"; break;
            }
          ?>
      </a></li>
  </ul>
    </div>
</div>
</nav>
    
    <div class="container-fluid">
      <form id="question_form" style="min-height:400px;" class="form-horizontal" method="post" action="<?=$EXAM?>/next">
        <div class="form-group">
          <h4><?=$question['question_id']?>.&nbsp;&nbsp;<?=$question['question_content']?></h4>
        </div>
        <div class="btn-group" data-toggle="buttons">
        <!-- Options -->
        <?php
            $keyMap  = array( 'A','B','C','D','E','F','G','H','I','J');
            $options = array(
                                $question['option_1'], $question['option_2'], $question['option_3'],
                                $question['option_4'], $question['option_5'], $question['option_6'],
                                $question['option_7'], $question['option_8'], $question['option_9'],
                                $question['option_10']);
            switch ($question['question_type'])
            {
                case 'jd':
                    for ($i = 0; $i < 2; $i ++)
                    {
                        echo "<div class='radio'><label>";
                        if ($i == 0){$checked = "checked";}else {$checked = "";}
                        echo "\t\t<input type='radio' name='answer' id='option_".($i+1)."' value='".($i+1)."' ".$checked.">\n";
                        echo "<strong>".$keyMap[$i]."</strong>.&nbsp;&nbsp;".$options[$i]."</label></div>";
                    }
                    echo "<input type='hidden' name='type' value='jd'>";
                break;
                case 'sc':
                    foreach ($options as $key => $val)
                    {
                        if ($key == 0){$checked = "checked";}else {$checked = "";}
                        if ($val != "" && $val != null)
                        {
                            echo "<div class='radio'><label>";
                            echo "<input type='radio' name='answer' id='option_".($key+1)."' value='".($key+1)."'".$checked.">";
                            echo "<strong>".$keyMap[$key]."</strong>.&nbsp;&nbsp;".$val."</label></div>";
                        }
                    }
                    echo "<input type='hidden' name='type' value='sc'>";
                break;
                case 'mc':
                    foreach ($options as $key => $val)
                    {
                        if ($key == 0){$checked = "checked";}else {$checked = "";}
                        if ($val != "" && $val != null)
                        {
                            echo "<div class='checkbox'><label>";
                            echo "<input type='checkbox' name='answer' id='option_" . ($key + 1) . "' value='" . ($key + 1). "'".$checked.">";
                            echo "<strong>" . $keyMap[$key] . "</strong>.&nbsp;&nbsp;" . $val."</label></div>";
                        }
                    }
                    echo "<input type='hidden' name='type' value='mc'>";
                break;
                default: echo "NULL"; break;
            }
        ?>
      </div>
        <div class="form-group">
          <div class="col-sm-offset-8 col-sm-10" id="submitDiv">
            <button type="submit" class="btn btn-default"><?=$this->lang->line('form_continue')?></button>
          </div>
        </div>
        </form>
      </div>
    </div><!-- /.container -->