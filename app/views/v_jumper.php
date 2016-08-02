<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
          <a class="navbar-brand" style="color:white;"><?=$APP_NAME?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?=$HOME?>">主页</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container-fluid">
      <form class="form-horizontal" action="<?=$TEST?>/next" method="get">
        <!-- Test code -->
        <div id="warning" class="form-group bg-info">
        <p>姓名：<?=$name?><br><br>生日：<?=$birthday?><br><br>提示：你可以使用<kbd>箭头键</kbd>切换选项，<kbd>回车</kbd>提交答案<br></p>
        <div class="form-group" style="text-align:right; padding:5px;">
          <div class="col-sm-7">
             <br>
            <button type="submit" class="btn btn-default" href>开始答题</button>
            </script>
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
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?=$JS?>ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
