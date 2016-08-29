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
            <div class="col-sm-1 col-md-1 col-lg-1">
                <h4><?=$question['question_id']?>.</h4>
            </div>
            <div class="col-sm-11 col-md-11 col-lg-11">
                <h4><?php echo c($question['question_content'], $EXAM_IMG)?></h4>
            </div>
        </div>
        <div class="btn-group" data-toggle="buttons">
        <!-- Options -->
        <?php
            $keyMap  = array( 'A','B','C','D','E','F','G','H','I','J');
            $options = array(
                                c($question['option_1'], $EXAM_IMG), c($question['option_2'], $EXAM_IMG), c($question['option_3'], $EXAM_IMG),
                                    c($question['option_4'], $EXAM_IMG), c($question['option_5'], $EXAM_IMG), c($question['option_6'], $EXAM_IMG),
                                        c($question['option_7'], $EXAM_IMG), c($question['option_8'], $EXAM_IMG), c($question['option_9'], $EXAM_IMG),
                                            c($question['option_10'], $EXAM_IMG));
            $extra = "";
            switch ($question['question_type'])
            {
                case 'sc':
                    foreach ($options as $key => $val)
                    {
                        if ($key == 0){$extra = "checked autofocus";}else {$extra = "";}
                        if ($val != "" && $val != null)
                        {
                            echo "<div class='radio'><label>";
                            echo "<input type='radio' name='answer' id='option_".($key+1)."' value='".($key+1)."'".$extra.">";
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

    <?php
        function c ($str, $EXAM_IMG)
        {
            if ($str == "" || $str == null)
            {
                return $str;
            }
            // replace [i] with <i>
            $str = str_replace("[i]", "<i>", $str);
            // replace [/i] with </i>
            $str = str_replace("[/i]", "</i>", $str);

            // replace [b] with <strong>
            $str = str_replace("[b]", "<strong>", $str);
            // replace [/b] with </b>
            $str = str_replace("[/b]", "</strong>", $str);

            // replace [u] with [u]
            $str = str_replace("[u]", "<u>", $str);
            // replace [/u] with </u>
            $str = str_replace("[/u]", "</u>", $str);

            // replace [r] with <br>
            $str = str_replace("[r]", "<br>", $str);

            $pattern = '/\[img\].*\[\/img\]/';
            preg_match($pattern, $str, $matches);


            foreach ($matches as $val)
            {
                $rp1 = str_replace("[img]", "<img src='".$EXAM_IMG, $val);
                $rp2 = str_replace("[/img]", "'>", $rp1);
                $str = str_replace($val, $rp2, $str);
            }
            // replace [img] with
            return $str;
        }
    ?>