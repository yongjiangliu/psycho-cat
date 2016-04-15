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
            <li><a href="<?=$ADMIN?>/panel/answer/">试卷列表</a></li>
            <li class="active"><a href="<?=$ADMIN?>/panel/question">题目列表</a></li>
            <li><a href="<?=$ADMIN?>/panel/upload">上传题目</a></li>
          </ul>
          <form id="searchAnswer" class="navbar-form navbar-right" action="<?=$ADMIN?>/panel/answer/get/name/" method="post">
            <div class="form-group">
              <input type="text" id="name" name="name" placeholder="输入姓名" class="form-control">
            </div>
            <button type="submit" class="btn btn-info">查找试卷</button>
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container-fluid">
      <div id="question_table_container">
        <a href="<?=$ADMIN?>/panel/question/get/type/all">全部&nbsp;<kbd><?=$count_all?></kbd></a>&nbsp;|&nbsp;
        <a href="<?=$ADMIN?>/panel/question/get/type/jg">判断&nbsp;<kbd><?=$count_jg?></kbd></a>&nbsp;|&nbsp;
        <a href="<?=$ADMIN?>/panel/question/get/type/sc">单选&nbsp;<kbd><?=$count_sc?></kbd></a>&nbsp;|&nbsp;
        <a href="<?=$ADMIN?>/panel/question/get/type/mc">多选&nbsp;<kbd><?=$count_mc?></kbd></a>&nbsp;|&nbsp;
        <a>最近更新&nbsp;<kbd>
        <?php
          if ($last_upload == null | $last_upload == "")
          {
            echo "未知";
          }
          else {
            echo $last_upload;
          }
        ?>
        </kbd></a>
        <hr>
        <table class="table table-bordered">
          <thead>
             <tr>
               <th>qid</th>
               <th style="width:50px">类型</th>
               <th>题目</th>
               <th>选项1</th>
               <th>选项2</th>
               <th>选项3</th>
               <th>选项4</th>
               <th>选项5</th>
             </tr>
           </thead>
           <tbody>
            <?php
              $nothing = false;
              if ($question == null)
              {
                $nothing = true;
              }
              else {
                if ( is_array ($question[0]))
                {
                  foreach ($question as $row)
                  {
                    echo "<tr>\n";
                    echo "\t<td>".$row['qid']."</td>\n";
                    echo "\t<td>".$row['type']."</td>\n";
                    echo "\t<td>".$row['question']."</td>\n";
                    echo "\t<td>".$row['option_1']."</td>\n";
                    echo "\t<td>".$row['option_2']."</td>\n";
                    echo "\t<td>".$row['option_3']."</td>\n";
                    echo "\t<td>".$row['option_4']."</td>\n";
                    echo "\t<td>".$row['option_5']."</td>\n";
                    echo "</tr>\n";
                  }
                }
                else {
                  $row = $answer;
                  echo "<tr>\n";
                  echo "\t<td>".$row['qid']."</td>\n";
                  echo "\t<td>".$row['type']."</td>\n";
                  echo "\t<td>".$row['question']."</td>\n";
                  echo "\t<td>".$row['option_1']."</td>\n";
                  echo "\t<td>".$row['option_2']."</td>\n";
                  echo "\t<td>".$row['option_3']."</td>\n";
                  echo "\t<td>".$row['option_4']."</td>\n";
                  echo "\t<td>".$row['option_5']."</td>\n";
                  echo "</tr>\n";
                }
              }
             ?>
          </tbody>
        </table>
        <?php
          if($nothing)
          {
            echo "<p class='bg-warning'>没有找到记录</p>";
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
