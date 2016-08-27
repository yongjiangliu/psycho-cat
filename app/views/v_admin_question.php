<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="navbar" class="collapse navbar-collapse">
  <ul class="nav navbar-nav">
    <li><a href="<?=$HOME?>"><?=$this->lang->line('nav_home')?></a></li>
    <li><a href="<?=$ADMIN?>/panel/exam/get/all"><?=$this->lang->line('nav_admin_exams')?></a></li>
    <li class="active"><a href="<?=$ADMIN?>/panel/question/get/all"><?=$this->lang->line('nav_admin_questions')?></a></li>
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

    <div class="container-fluid">
        <?php
            $noData = false;
            if ($count == 0 || count($questions) == 0)
            {
                $noData = true;
            }
        ?>
        <?php
        if (!$noData){
        ?>
      <div id="question_table_container">
          <p>
          <strong><a href="<?=$ADMIN?>/panel/question/get/all"><?=$this->lang->line('admin_all')?></a></strong>&nbsp;<kbd><?=$count?></kbd>&nbsp;|&nbsp;
          <strong><a href="<?=$ADMIN?>/panel/question/get/type/sc"><?=$this->lang->line('question_type_sc')?></a></strong>&nbsp;<kbd><?=$count_sc?></kbd>&nbsp;|&nbsp;
          <strong><a href="<?=$ADMIN?>/panel/question/get/type/mc"><?=$this->lang->line('question_type_mc')?></a></strong>&nbsp;<kbd><?=$count_mc?></kbd>&nbsp;|&nbsp;
          <strong><a style="color:black"><?=$this->lang->line('question_upload_at')?></a></strong>&nbsp;<kbd><?=$settings['last_upload_at']?></kbd>&nbsp;|&nbsp;
          <strong><a style="color:black"><?=$this->lang->line('question_upload_from')?></a></strong>&nbsp;<kbd><?=$settings['last_upload_from']?></kbd>
        </p>
          <hr>
        <table class="table table-bordered">
          <thead>
             <tr>
               <th style="width:50px">ID</th>
               <th style="width:50px"><?=$this->lang->line('question_type')?></th>
                 <th style="width:50px"><?=$this->lang->line('question_score')?></th>
               <th><?=$this->lang->line('question_content')?></th>
               <th>A</th>
               <th>B</th>
               <th>C</th>
               <th>D</th>
               <th>E</th>
               <th>F</th>
               <th>G</th>
               <th>H</th>
               <th>I</th>
               <th>J</th>
             </tr>
           </thead>
           <tbody>
            <?php
                foreach ($questions as $question)
                {
                    echo "<tr>";
                    echo "<td>" . $question['question_id'] . "</td>";
                    echo "<td><strong>" . $question['question_type'] . "</strong></td>";
                    echo "<td><strong>" . $question['score']. "</strong></td>";
                    echo "<td>" . $question['question_content'] . "</td>";
                    for ($i = 1; $i <= 10; $i++)
                    {
                        echo "<td>";
                        $score = $question['score_'.strval($i)];
                        if ($score != null)
                        {
                            echo "<kbd>".$score."</kbd>&nbsp;";
                        }
                        echo $question['option_'.strval($i)]."</td>";
                    }
                    echo "</tr>\n";
                }
             ?>
          </tbody>
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
    </div><!-- /.container -->
