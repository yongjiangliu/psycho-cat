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
    </div>
    <!-- /.container -->
