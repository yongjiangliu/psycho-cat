<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <title>测试完成</title>
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
      <form id="test_done_container" class="form-horizontal">
        <!-- Test code -->
        <div id="warning" class="form-group">
        <img src="<?=$IMG?>/done.jpg" alt="搞定" class="img-rounded">
        <h4>测试完成！</h4>
        <table class="table table-bordered">
          <tr>
            <td>试卷编号</td>  <td><?=$test_code?></td>
          </tr>
          <tr>
            <td>姓名</td>  <td><?=$name?></td>
          </tr>
          <tr>
            <td>完成度</td>  <td><?=$qid?>/<?=$count?></td>
          </tr>
          <tr>
            <td>用时</td>  <td><?=$time?></td>
          </tr>
          <tr>
            <td>开始时间</td>  <td><?=$start_time?></td>
          </tr>
          <tr>
            <td>结束时间</td>  <td><?=$finish_time?></td>
          </tr>
        </table>
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
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?=$JS?>ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
