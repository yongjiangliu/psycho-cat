<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <title>试卷编号</title>
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
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container-fluid">
      <form id="testCode" class="form-horizontal" method="post" action="<?=$TEST?>">

        <!-- Test code -->
        <div id="warning" class="form-group bg-info">
          <?php
            $buttonVal        = "";
            $test_code_val    = "";
            $readOnly         = "";

            if ($status == "out"){
              echo "<p>请记下试卷编号<br><br>你可以使用该编号从中断的位置继续答题<br><br><kbd>主页->输入试卷编号</kbd><br><br>测试完成后试卷编号失效</p>";
              $test_code_val  = "value='".$test_code."'";
              $readOnly       = "readonly";
              $buttonVal      = "提交";
            }
            else if ($status == "in"){
              echo "<p></p>";
              $test_code_val  = "";
              $buttonVal      = "提交";
            }
            else {
              echo "错误，无法解析命令: ".$status;
              $test_code_val  = "";
              $buttonVal      = "提交";
            }
          ?>

          <label for="test_code" class="col-sm-4 control-label">试卷编号</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="test_code" name="test_code" <?=$test_code_val?> <?=$readOnly?> >
        </div>
        <div class="form-group" style="text-align:right; padding:5px;">
          <div class="col-sm-7">
            <br>
            <button type="submit" class="btn btn-default"><?=$buttonVal?></button>
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
    <script src="<?=$JS?>common.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?=$JS?>ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
