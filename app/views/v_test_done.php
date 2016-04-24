<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
            <td>试卷编号</td>  <td><?=$test_id?></td>
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
    </div>
    <!-- /.container -->
