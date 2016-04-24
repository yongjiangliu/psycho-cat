<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?=$HOME?>">主页</a></li>
            <li><a href="<?=$ADMIN?>/panel/answer/">试卷列表</a></li>
            <li><a href="<?=$ADMIN?>/panel/question">题目列表</a></li>
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
      <form class="form-horizontal">
        <div id="warning" class="form-group bg-success">
          <p>数据库更新成功！</p>
        <div class="form-group" style="text-align:right; padding:5px;">
          <div class="col-sm-7">
          <br>
          </div>
        </div>
        </form>
      </div>
    </div>
    <!-- /.container -->
