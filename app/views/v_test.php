<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <title>测试</title>
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
            <?php
              if (!isset($name) || $name == null || $name == "")
              {
                $name = "NULL";
              }
              if (!isset($last_qid) || $last_qid == null || $last_qid == "")
              {
                $last_qid = -2;
              }
              if (!isset($qid) || $qid == null || $qid == "")
              {
                $qid = -1;
              }
              if (!isset($count) || $count == null || $count == "")
              {
                $count = "NULL";
              }
              if (!isset($type) || $type == null || $type == "")
              {
                $type = "NULL";
              }
              if (!isset($question) ||  $question == null || $question == "")
              {
                $question = "NULL";
              }
            ?>
            <li class="active"><a href="#">答题人：<?=$name?></a></li>
            <li class="active"><a href="#">总体进度：<?=$qid?>/<?=$count?></a></li>
            <li class="active"><a href="#">当前题目类型：<?=$type?></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container-fluid">
      <form id="test" class="form-horizontal" method="post" action="<?=$TEST?>/next">
        <div class="form-group">
          <h4><?=$qid?>.&nbsp;&nbsp;<?=$question?></h4>
        </div>
        <div class="btn-group" data-toggle="buttons">
        <!-- Options -->
        <?php
          if (is_array($options) || (count($options) >= 2))
          {
            if ($type == "判断")
            {

              $checked = "";
              foreach ($options as $key => $val)
              {
                echo "<div class='radio'>\n";
                echo "\t<label>\n";
                if ($key == 0){$checked = "checked";}else {$checked = "";}
                echo "\t\t<input type='radio' name='answer' id='option_".($key+1)."' value='".$val."' ".$checked.">\n";
                echo "\t\t".$val."\n";
                echo "\t</label>\n";
                echo "\t\t</div>\n";
              }
              echo "<input type='hidden' name='type' id='type' value='jg'>";
            }
            else if ($type == "单选")
            {
              foreach ($options as $key => $val)
              {
                echo "<div class='radio'>\n";
                echo "\t<label>\n";
                if ($key == 0){$checked = "checked";}else {$checked = "";}
                echo "\t\t<input type='radio' name='answer' id='option_".($key+1)."' value='".int2alpha($key)."' ".$checked.">\n";
                echo "\t\t".int2alpha($key).".&nbsp;".$val."\n";
                echo "\t</label>\n";
                echo "\t\t</div>\n";
              }
              echo "<input type='hidden' name='type' id='type' value='sc'>\n";
            }
            else if ($type == "多选")
            {
              foreach ($options as $key => $val)
              {
                echo "<div class='checkbox'>\n";
                echo "\t<label>\n";
                if ($key == 0){$checked = "checked";}else {$checked = "";}
                echo "\t\t<input type='checkbox' name='checkbox_".($key+1)."' id='option_".($key+1)."' value='".int2alpha($key)."' ".$checked.">\n";
                echo "\t\t".int2alpha($key).".&nbsp;".$val."\n";
                echo "\t</label>\n";
                echo "\t\t</div>\n";
              }
              echo "<input type='hidden' name='type' id='type' value='mc'>\n";
              echo "<input type='hidden' name='answer' id='answer'>\n";
            }
            else
            {
              echo "<p>无效的问题类型[".$type."]</p>\n";
            }
          }
          else {
            echo "<p>无效的选项数组[".var_dump($options)."]</p>\n";
          }

          function int2alpha($int)
          {
            switch ($int)
            {
              case "0":
                return "A";
              case "1":
                return "B";
              case "2":
                return "C";
              case "3":
                return "D";
              case "4":
                return "E";
              default:
                return "NULL";
            }
          }

        ?>
      </div>
        <div class="form-group">
          <div class="col-sm-offset-8 col-sm-10" id="submitDiv">
            <button type="submit" class="btn btn-default">提交</button>
          </div>
        </div>
        </form>
      </div>
    </div><!-- /.container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=$JS?>jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?=$JS?>jquery.min.js"><\/script>')</script>
    <script src="<?=$JS?>bootstrap.min.js"></script>
    <!-- Custom javascript-->
    <script>
    var imgPath = "<?=$IMG?>";
    </script>
    <script src="<?=$JS?>test.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?=$JS?>ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
