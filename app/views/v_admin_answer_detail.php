<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?=$HOME?>">主页</a></li>
            <li class="active"><a href="<?=$ADMIN?>/panel/answer">试卷列表</a></li>
            <li><a href="<?=$ADMIN?>/panel/question">题目列表</a></li>
            <li><a href="<?=$ADMIN?>/panel/upload">上传题目</a></li>
          </ul>
          <form id="searchAnswer" class="navbar-form navbar-right" action="<?=$ADMIN?>/panel/answer/get/name" method="post">
            <div class="form-group">
              <input type="text" id="name" name="name" placeholder="输入姓名" class="form-control">
            </div>
            <button type="submit" class="btn btn-info">查找试卷</button>
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container-fluid">
      <div id="table_detail_container">
        <!-- ************** User Info **************  -->
        <h4>个人信息</h4>
        <table class="table table-bordered" id="tb_userInfo">
          <thead>
             <tr>
               <th>姓名</th>
               <th>性别</th>
               <th>职业</th>
               <th>生日</th>
               <th>教育</th>
               <th>血型</th>
               <th>婚姻</th>
             </tr>
           </thead>
           <tbody>
            <?php
              echo "<tr>\n";
              echo "\t<td>".$data['name']."</td>\n";
              echo "\t<td>".$data['gender']."</td>\n";
              echo "\t<td>".$data['occupation']."</td>\n";
              echo "\t<td>".$data['birthday']."</td>\n";
              echo "\t<td>".$data['education']."</td>\n";
              echo "\t<td>".$data['bloodType']."</td>\n";
              echo "\t<td>".$data['marriage']."</td>\n";
              echo "</tr>\n";
             ?>
          </tbody>
        </table>
        <!-- ************** Answer Summary **************  -->
        <h4>试卷信息</h4>
        <table class="table table-bordered" id="tb_answerInfo">
          <thead>
             <tr>
               <th>aid(试卷ID)</th>
               <th>试卷代码</th>
               <th>是否完成</th>
               <th>完成度</th>
               <th>用时</th>
               <th>开始时间</th>
               <th>结束时间</th>
             </tr>
           </thead>
           <tbody>
            <?php
              $data['start_time']  = datetimeHandler($data['start_time']);
              $data['finish_time'] = datetimeHandler($data['finish_time']);
              $time                = datetimeDiff($data['start_time'],$data['finish_time']);
              if ($data['finish_test'] == 1)
              {
                $data['finish_test'] = "是";
              }
              else {
                $data['finish_test'] = "否";
              }
              echo "<tr>\n";
              echo "\t<td>".$data['aid']          ."</td>\n";
              echo "\t<td>".$data['test_code']    ."</td>\n";
              echo "\t<td>".$data['finish_test']  ."</td>\n";
              echo "\t<td>".$data['qid']."/".$count ."</td>\n";
              echo "\t<td>".$time                 ."</td>\n";
              echo "\t<td>".$data['start_time']  ."</td>\n";
              echo "\t<td>".$data['finish_time'] ."</td>\n";
              echo "</tr>\n";

              function datetimeHandler($datetime)
              {
                if ($datetime == null || $datetime == "")
                {
                  return "N/A";
                }
                else {
                  return $datetime;
                }
              }
              function datetimeDiff($start_time, $finish_time)
              {
                if ($start_time == "N/A" || $finish_time == "N/A")
                {
                  return "N/A";
                }
                else
                {
                  // calculate time difference (hour, minute, second)
                  $dteStart = new DateTime($start_time );
                  $dteEnd   = new DateTime($finish_time);
                  $dteDiff  = $dteStart->diff($dteEnd);
                  $time 		= $dteDiff->format("%H:%I:%S");
                  return $time;
                }
              }
             ?>
          </tbody>
          </table>
          <!-- ************** Answer Detail **************  -->
          <h4>答案</h4>
          <table class="table table-bordered" id="tb_answer">
              <?php
                // empty array flag
                $nothing = false;
                // counter
                $i = 0;
                // json convert to array
                if ($data['answer_json'] != "" && $data['answer_json'] != null)
                {
                  $answer_array = json_decode($data['answer_json']);
                  $len = count($answer_array);
                  foreach ($answer_array as $key => $val)
                  {
                    $i++;
                    // if new line start, first output the row of keys
                    if ($i == 1)
                    {
                      echo "<tr class='info'>\n";
                      for($j = 1; $j <= $answer_per_row; $j++)
                      {
                        $qid = (intval($key) + $j);
                        if ($qid <= $len)
                        {
                          echo "\t<td style='width:10%'><b>";
                          echo (intval($key) + $j);
                          echo "</b></td>\n";
                        }
                      }
                      echo "</tr>\n";
                      // output row of data
                      echo "<tr>\n";
                    }
                    echo "\t<td>";
                    echo $val;
                    echo "</td>\n";
                    // if answer output done
                    if ($i == $answer_per_row)
                    {
                      // end answer row
                      echo "</tr>\n";
                      //reset i
                      $i = 0;
                    }
                  }
                }
                else
                {
                  $nothing = true;
                }
               ?>
        </table>
        <?php
        if($nothing)
        {
          echo "<p class='bg-warning'>没有记录</p>";
        }
        ?>
      </div>
      </div>
    </div>
    <!-- /.container -->
