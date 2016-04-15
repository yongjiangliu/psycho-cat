<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <title>试卷列表</title>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" style="color:white;"><?=$TXT_TITLE?></a>
        </div>
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
      <div id="table_container">
        <table class="table table-bordered">
          <thead>
             <tr>
               <th>aid</th>
               <th>姓名</th>
               <th>性别</th>
               <th>交卷时间</th>
               <th>完成度</th>
               <th>试卷代码</th>
               <th>详细</th>
               <th>删除</th>
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
    </div><!-- /.container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=$JS?>jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?=$JS?>jquery.min.js"><\/script>')</script>
    <script src="<?=$JS?>bootstrap.min.js"></script>
    <!-- Custom javascript-->
    <script src="<?=$JS?>common.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?=$JS?>ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
