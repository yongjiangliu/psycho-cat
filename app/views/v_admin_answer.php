<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?=$HOME?>"><?=$lang->line("nav_home")?></a></li>
            <li class="active"><a href="<?=$ADMIN?>/panel/answer"><?=$lang->line("nav_answer_list")?></a></li>
            <li><a href="<?=$ADMIN?>/panel/question"><?=$lang->line("nav_question_list")?></a></li>
            <li><a href="<?=$ADMIN?>/panel/upload"><?=$lang->line("nav_question_upload")?></a></li>
          </ul>
          <form id="searchAnswer" class="navbar-form navbar-right" action="<?=$ADMIN?>/panel/answer/get/name" method="post">
            <div class="form-group">
              <input type="text" id="name" name="name" placeholder="<?=$lang->line("nav_enter_name")?>" class="form-control">
            </div>
            <button type="submit" class="btn btn-info"><?=$lang->line("nav_search")?></button>
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container-fluid">
      <div id="table_container">
        <table class="table table-bordered">
          <thead>
             <tr>
               <th>aid</th>
               <th><?=$lang->line("table_name")?></th>
               <th><?=$lang->line("table_gender")?></th>
               <th><?=$lang->line("table_submit_time")?></th>
               <th><?=$lang->line("table_progress")?></th>
               <th><?=$lang->line("table_test_id")?></th>
               <th><?=$lang->line("table_detail")?>/th>
               <th><?=$lang->line("table_delete")?></th>
             </tr>
           </thead>
           <tbody>
            <?php
              $nothing = false;
              if ($answer == null)
              {
                $nothing = true;
              }
              else {
                if (is_array ($answer[0]))
                {
                  foreach ($answer as $row)
                  {
                    $finish_time;
                    if ($row['finish_time'] == null) {
                      $finish_time = "未完成";
                    }
                    else {
                      $finish_time = $row['finish_time'];
                    }
                    echo "<tr>\n";
                    echo "\t<td>".$row['aid']."</td>\n";
                    echo "\t<td>".$row['name']."</td>\n";
                    echo "\t<td>".$row['gender']."</td>\n";
                    echo "\t<td>".$finish_time."</td>\n";
                    echo "\t<td>".$row['qid']."/".$count."</td>\n";
                    echo "\t<td><kbd>".$row['test_code']."</kbd></td>\n";
                    echo "\t<td><a href='".$ADMIN."/panel/answer/get/aid/".$row['aid']."'>详细</a></td>\n";
                    echo "\t<td><a href='".$ADMIN."/panel/answer/delete/aid/".$row['aid']."'>删除</a></td>\n";
                    echo "</tr>\n";
                  }
                }
                else {
                  $row = $answer;
                  $finish_time;
                  if ($row['finish_time'] == null) {
                    $finish_time = "未完成";
                  }
                  else {
                    $finish_time = $row['finish_time'];
                  }
                  echo "<tr>\n";
                  echo "\t<td>".$row['aid']."</td>\n";
                  echo "\t<td>".$row['name']."</td>\n";
                  echo "\t<td>".$row['gender']."</td>\n";
                  echo "\t<td>".$finish_time."</td>\n";
                  echo "\t<td>".$row['qid']."/".$count."</td>\n";
                  echo "\t<td><kbd>".$row['test_code']."</kbd></td>\n";
                  echo "\t<td><a href='".$ADMIN."/panel/answer/get/aid/".$row['aid']."'>详细</a></td>\n";
                  echo "\t<td><a href='".$ADMIN."/panel/answer/delete/aid/".$row['aid']."'>删除</a></td>\n";
                  echo "</tr>\n";
                }
              }
             ?>
          </tbody>
        </table>
        <?php
          if($nothing)
          {
            if ($name != null){
              echo "<p class='bg-warning'>没有找到<kbd>".$name."</kbd>的记录</p>";
            }
            else {
                echo "<p class='bg-warning'>没有找到记录</p>";
            }
          }
         ?>
      </div>
      </div>
    </div>
    <!-- /.container -->
