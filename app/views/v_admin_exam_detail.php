<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?=$HOME?>"><?=$this->lang->line('nav_home')?></a></li>
            <li class="active"><a href="<?=$ADMIN?>/panel/exam/get/all"><?=$this->lang->line('nav_admin_exams')?></a></li>
            <li><a href="<?=$ADMIN?>/panel/question/get/all"><?=$this->lang->line('nav_admin_questions')?></a></li>
            <li><a href="<?=$ADMIN?>/panel/upload"><?=$this->lang->line('nav_admin_upload')?></a></li>
          </ul>
          <form id="searchAnswer" class="navbar-form navbar-right" action="<?=$ADMIN?>/panel/exam/get/name" method="post">
            <div class="form-group">
              <input type="text" id="name" name="name" placeholder="<?=$this->lang->line('nav_admin_subject_name')?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-default"><?=$this->lang->line('nav_admin_search')?></button>
          </form>
        </div>
      </div>
    </nav>
    <?php
        $marriage[1]    = $this->lang->line('marriage_married');
        $marriage[0]    = $this->lang->line('marriage_unmarried');
        $gender[1]      = $this->lang->line('gender_male');
        $gender[0]      = $this->lang->line('gender_female');
        $education[1]   =  $this->lang->line('education_grade_school');
        $education[2]   = $this->lang->line('education_middle_school');
        $education[3]   = $this->lang->line('education_high_school');
        $education[4]   = $this->lang->line('education_bachelor');
        $education[5]   = $this->lang->line('education_master');
        $education[6]   = $this->lang->line('education_phd');
        $noData = false;
        if ($count_question_all == 0 || count($exams) == 0)
        {
            $noData = true;
        }
        else
        {
            $exam = $exams[0];
        }
    ?>
    <div class="container-fluid">
      <div id="table_detail_container">
    <?php if (!$noData){?>
        <h4><?=$this->lang->line('admin_subject_summary')?></h4><hr>
        <table class="table table-bordered" id="tb_userInfo">
          <thead>
             <tr>
                 <th><?=$this->lang->line('subject_name')?></th>
                 <th><?=$this->lang->line('subject_gender')?></th>
                 <th><?=$this->lang->line('subject_occupation')?></th>
                 <th><?=$this->lang->line('subject_age')?></th>
                 <th><?=$this->lang->line('subject_birthday')?></th>
                 <th><?=$this->lang->line('subject_education')?></th>
                 <th><?=$this->lang->line('subject_blood_type')?></th>
                 <th><?=$this->lang->line('subject_marriage')?></th>
             </tr>
           </thead>
           <tbody>
            <?php
                echo "<tr>";
                echo "<td><strong>".$exam['subject_name']."</strong></td>";
                echo "<td>".$gender[$exam['subject_gender']]."</td>";
                echo "<td>".$exam['subject_occupation']."</td>";
                echo "<td>".$exam['subject_age']."</td>";
                echo "<td>".$exam['subject_birthday']."</td>";
                echo "<td>".$education[$exam['subject_education']]."</td>";
                echo "<td>".$exam['subject_blood_type']."</td>";
                echo "<td>".$marriage[$exam['subject_marriage']]."</td>";
                echo "</tr>";
             ?>
          </tbody>
        </table>
          <hr><h4><?=$this->lang->line('admin_exam_summary')?></h4><hr>
        <table class="table table-bordered" id="tb_answerInfo">
          <thead>
             <tr>
               <th>ID</th>
               <th><?=$this->lang->line('exam_resume_code')?></th>
               <th><?=$this->lang->line('admin_finished')?></th>
               <th><?=$this->lang->line('exam_progress')?></th>
               <th><?=$this->lang->line('exam_duration')?></th>
               <th><?=$this->lang->line('exam_start_at')?></th>
               <th><?=$this->lang->line('exam_finish_at')?></th>
             </tr>
           </thead>
           <tbody>
            <?php
              $exam['start_at']     = dtFilter($exam['start_at']);
              $exam['finish_at']    = dtFilter($exam['finish_at']);
              $exam['duration']     = dtDiff($exam['start_at'], $exam['finish_at']);
              if ($exam['finished'] == 1)
              {
                $exam['finished'] = $this->lang->line('admin_yes');
              }
              else {
                $data['finished'] = "<kbd>".$this->lang->line('admin_no')."</kbd>";
              }
              echo "<tr>";
              echo "<td>".$exam['exam_id']          ."</td>";
              echo "<td><kbd>".$exam['resume_code']    ."</kbd></td>";
              echo "<td>".$exam['finished']  ."</td>";
              echo "<td>".$exam['question_id']."/".$count_question_all ."</td>";
              echo "<td>".$exam['duration']       ."</td>";
              echo "<td>".$exam['start_at']  ."</td>";
              echo "<td>".$exam['finish_at'] ."</td>";
              echo "</tr>";
             ?>
          </tbody>
          </table>
          <hr><h4><?=$this->lang->line('admin_answer_summary')?></h4><hr>
          <table class="table table-bordered" id="tb_answer">
              <?php
                // json convert to array
                if ($exam['answer_array'] != "" && $exam['answer_array'] != null)
                {
                    $answer_array = explode(" ", $exam['answer_array']);
                    $len = count($answer_array);
                    $i = 0;
                    foreach ($answer_array as $key => $val)
                    {
                        if ($i == 1)
                        {
                            echo "<tr class='info'>\n";
                            for($j = 1; $j <= $answer_per_row; $j++)
                            {
                                $qid = (intval($key) + $j);
                                if ($qid <= $len)
                                {
                                    echo "<td style='width:10%'><b>";
                                    echo (intval($key) + $j);
                                    echo "</b></td>";
                                }
                        }
                        echo "</tr><tr>";
                    }
                    echo "<td>";
                    echo $val;
                    echo "</td>";
                    // if answer output done
                    if ($i == $answer_per_row)
                    {
                      // end answer row
                      echo "</tr>";
                      //reset i
                      $i = 0;
                    }
                  }
                }
               ?>
        </table>
    <?php }?>
        <?php
        if($noData)
        {
            echo '<div class="alert alert-danger" role="alert">';
            echo '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>';
            echo '<span class="sr-only">Error</span>';
            echo '&nbsp;&nbsp;';
            echo $this->lang->line('admin_no_record');
            echo "</div>";
        }
        ?>
      </div>
      </div>
    </div>
    <?php
        function dtFilter ($datetime)
        {
            if ($datetime == null || $datetime == "")
            {
                return "<kbd>N/A</kbd>";
            }
            else {
                return $datetime;
            }
        }
        function dtDiff($start_at, $finish_at)
        {
            if ($start_at == "<kbd>N/A</kbd>" || $finish_at == "<kbd>N/A</kbd>")
            {
                return "<kbd>N/A</kbd>";
            }
            else
            {
                $start  = new DateTime($start_at);
                $finish = new DateTime($finish_at);
                $diff   = $finish->diff($start);

                $year   = $diff->y;
                $month  = $diff->m;
                $day    = $diff->d;

                $hour   = $diff->h;
                $min    = $diff->i;
                $sec    = $diff->s;

                $output = $sec." s";
                if ($min != 0)
                {
                    $output = $min." m ".$output;
                }
                if ($hour != 0)
                {
                    $output = $hour." h ".$output;
                }
                if ($day != 0)
                {
                    $output = $day." d ".$output;
                }
                if ($month !=0)
                {
                    $output = $month." m ".$output;
                }
                if ($year !=0)
                {
                    $output = $year." y ".$output;
                }
                return $output;
            }
        }
    ?>