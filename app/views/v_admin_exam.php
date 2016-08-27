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
              <input type="text" value="<?=$name?>" id="name" name="name" placeholder="<?=$this->lang->line('nav_admin_subject_name')?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-default"><?=$this->lang->line('nav_admin_search')?></button>
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div id="table_container">
          <?php
          $noData = false;
          if ($count_question_all == 0 || count($exams) == 0)
          {
              $noData = true;
          }
          ?>
          <p>
              <a href="<?=$ADMIN?>/panel/exam/get/all"><strong><?=$this->lang->line('admin_total')?>:&nbsp; </strong></a><kbd><?php echo $count_exam_all?></kbd>&nbsp;|&nbsp;
              <a href="<?=$ADMIN?>/panel/exam/get/finish/1"><strong><?=$this->lang->line('admin_finished')?>:&nbsp; </strong></a><kbd><?php echo $count_exam_finished?></kbd>&nbsp;|&nbsp;
              <a href="<?=$ADMIN?>/panel/exam/get/finish/0"><strong><?=$this->lang->line('admin_unfinished')?>:&nbsp; </strong></a><kbd><?php echo $count_exam_unfinished?></kbd>
          </p>

        <table class="table table-bordered">
          <thead>
          <?php if (!$noData) {?>
             <tr>
                 <th>ID</th>
                 <th><?=$this->lang->line('subject_name')?></th>
                 <th><?=$this->lang->line('exam_finish_at')?></th>
                 <th><?=$this->lang->line('exam_progress')?></th>
                 <th><?=$this->lang->line('exam_resume_code')?></th>
                 <th><?=$this->lang->line('admin_detail')?></th>
                 <th><?=$this->lang->line('admin_remove')?></th>
             </tr>
          <?php }?>
           </thead>
           <tbody>
            <?php
              if (!$noData)
              {
                  foreach ($exams as $row)
                  {
                      $finish_at;
                      if ($row['finish_at'] == null)
                      {
                          $finish_at = "<kbd>".$this->lang->line('admin_exam_unfinished')."</kbd>";
                      }
                      else
                      {
                          $finish_at = $row['finish_at'];
                      }
                      echo "<tr>";
                      echo "<td>".$row['exam_id']."</td>";
                      echo "<td>".$row['subject_name']."</td>";
                      echo "<td>".$finish_at."</td>";
                      echo "<td>".$row['question_id']."/".$count_question_all."</td>";
                      echo "<td><kbd>".$row['resume_code']."</kbd></td>";
                      echo "<td><a href='".$ADMIN."/panel/exam/get/id/".$row['exam_id']."'>".$this->lang->line('admin_detail')."</a></td>";
                      echo "<td><a href='".$ADMIN."/panel/exam/delete/id/".$row['exam_id']."'>".$this->lang->line('admin_remove')."</a></td>";
                      echo "</tr>";
                  }
              }
             ?>
          </tbody>
        </table>
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
