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
            <li><a href="<?=$ADMIN?>">管理员登录</a></li>
            <li><a href="<?=$HOME?>/inputTestCode">输入试卷编号</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container-fluid">
      <form id="userInfo" class="form-horizontal" method="post" action="<?=$HOME?>/getTestCode">
        <!-- Name -->
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">姓名</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name">
          </div>
        </div>
        <!-- Occupation -->
        <div class="form-group">
            <label for="occupation" class="col-sm-2 control-label">职业</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="occupation" name="occupation">
            </div>
        </div>
        <!-- Gender -->
        <div class="form-group">
          <label for="gender" class="col-sm-2 control-label">性别</label>
          <div class="col-sm-10">
            <select class="form-control" id="gender" name="gender">
              <option value="">请选择</option>
              <option value="男">男</option>
              <option value="女">女</option>
            </select>
          </div>
        </div>
        <!-- Birthday -->
        <div class="form-group">
            <label for="birthday" class="col-sm-2 control-label">生日</label>
            <div class="col-sm-10">
              <input type="text" class="date-picker form-control" id="birthday" name="birthday" placeholder="YYYY-MM-DD"/>
            </div>
        </div>

        <!-- Education -->
        <div class="form-group">
          <label for="education" class="col-sm-2 control-label">教育</label>
          <div class="col-sm-10">
            <select class="form-control" id="education" name="education">
              <option value="">请选择</option>
              <option value="博士">博士</option>
              <option value="硕士">硕士</option>
              <option value="本科">本科</option>
              <option value="专科">专科</option>
            </select>
          </div>
        </div>
        <!-- Blood Type -->
        <div class="form-group">
          <label for="bloodType" class="col-sm-2 control-label">血型</label>
          <div class="col-sm-10">
            <select class="form-control" id="bloodType" name="bloodType">
              <option value="">请选择</option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="AB">AB</option>
              <option value="O">O</option>
            </select>
          </div>
        </div>
        <!-- Marriage -->
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">婚姻</label>
          <div class="col-sm-10">
            <select class="form-control" id="marriage" name="marriage">
              <option value="">请选择</option>
              <option value="已婚">已婚</option>
              <option value="未婚">未婚</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
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
    <script src="<?=$JS?>common.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?=$JS?>ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
