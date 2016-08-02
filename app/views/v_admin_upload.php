<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <title>上传题目</title>
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
          </button>
          <a class="navbar-brand" style="color:white;"><?=APP_NAME?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?=$HOME?>">主页</a></li>
            <li><a href="<?=$ADMIN?>/panel/answer/">试卷列表</a></li>
            <li><a href="<?=$ADMIN?>/panel/question/">题目列表</a></li>
            <li class="active"><a href="#">上传题目</a></li>
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
      <form id="upload_question" class="form-horizontal" method="post" action="<?=$ADMIN?>/upload" enctype="multipart/form-data">
        <fieldset>
        <h4>上传制表符分割的文本文件(UTF-8编码)</h4>
        <hr>
        <p class="bg-danger">
        <?php
          if (isset($errorMsg))
          {
            $msg = str_replace("%20"," ",$errorMsg);
            echo $msg;
          }
        ?>
        </p><br>
        <div class="form-group">
          <label for="file">选择文件</label>
          <input type="file" id="file" name="file">
          <p class="help-block">只接受txt格式文件，生成、转码方式请见以下内容</p>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">上传</button>
          </div>
        </div>
      </fieldset>
      <hr>
      <fieldset>
      <h4>题目文件编写、生成步骤</h4>
      <hr>
      <ol>
        <br>
        <li>编辑EXCEL表格</li>
        <br>
            自带题库模板<a href="<?=$TEMPLATE?>template.xlsx">template.xlsx</a><br><br>
            <b><kbd>列</kbd>排列方式</b>
            <img src="<?=$IMG?>/intro_1.jpg" alt="列说明" class="img-rounded">
            <b>说明：</b>
            <ul>
              <li>题目类型、题目内容、选项1、选项2必须有值，以满足选择和判断题的基本条件</li>
              <li>题目类型只能为<kbd>判断</kbd>，<kbd>单选</kbd>或<kbd>多选</kbd>中的一种</li>
              <li>选项3，4，5可留空，但请勿跳列留空（选项需连续）</li>
              <li>G以后的列请勿添加数据</li>
              <li>在用户提交的答卷中，判断题的答案存储为选项内容（如是，否，不确定），选择题的答案存储为A-E</li>
              <li>因为数据块将由制表符分割，所以单元格中请不要使用制表符<kbd>\t</kbd></li>
              <li>选项号<kbd>A-E</kbd>不用填写，系统会按顺序自动生成</li>
            </ul><br>
            <b><kbd>行</kbd>排列方式</b>
            <img src="<?=$IMG?>/intro_2.jpg" alt="行说明" class="img-rounded">
            <b>说明：</b>
            <ul>
              <li>每行一个题目，受试者会按照EXCEL表中排列的题目顺序答题</li>
              <li>题目编号<kbd>1，2，3...</kbd>由系统计算，不用包含在题目内容中</li>
              <li>如果题目之间没有空行，那么EXCEL表中的题目行号就是实际答题中该题的编号</li>
            </ul>
            <b><kbd>常见错误：</kbd></b><br>
            <ol>
              <li>EXCEL文件含有多个工作表（请删除多余的，只保留一个）</li>
              <img src="<?=$IMG?>/intro_6.jpg" alt="多个工作表" class="img-rounded">
              <li>跳列留空（选项必须连续）</li>
              <img src="<?=$IMG?>/intro_3.jpg" alt="跳列留空" class="img-rounded">
              <li>题目空行（系统检查时不会报错，但是会影响EXCEL可读性）</li>
              <img src="<?=$IMG?>/intro_4.jpg" alt="题目空行" class="img-rounded">
              <li>超出G列</li>
              <img src="<?=$IMG?>/intro_5.jpg" alt="超出G列" class="img-rounded">
            </ol>
            <b><kbd>实际应用：</kbd></b><br>
            <img src="<?=$IMG?>/intro_7.jpg" alt="举例" class="img-rounded">
        <br>
          <li>EXCEL文件安上述注意事项编辑完成后即可导出，请将文件另存为<kbd>制表符分割的文本文件</kbd></li>
          <img src="<?=$IMG?>/intro_8_0.jpg" alt="表格另存为" class="img-rounded">
          出现“丢失功能”的提示框是正常的，文本文件无法保存如单元格类型，背景颜色等内容。<br>此时请点<kbd>是</kbd>或<kbd>继续</kbd>
          <img src="<?=$IMG?>/intro_8_1.jpg" alt="表格另存为" class="img-rounded">
          <img src="<?=$IMG?>/intro_8_2.jpg" alt="表格另存为" class="img-rounded">
        <br>
        <li>用记事本打开保存的文本文件(txt)，另存为新的文本文件并改变其编码方式为UTF-8</li>
          <img src="<?=$IMG?>/intro_9.jpg" alt="操作说明2" class="img-rounded">
          <img src="<?=$IMG?>/intro_10.jpg" alt="操作说明2" class="img-rounded">
        <li>在本页面中上传此UTF-8编码的txt文件</li>
        <li>接下来的页面会验证该文本文件有无错误，验证比较严格，请谅解：）</li>
        <li>如果有错误，请根据错误提示修改EXCEL文件，然后重新步骤2-5</li>
        <li>如果无错误，请点击更新题目库，更新题目库可能耗时较长，请耐心等待，不要重复点击更新按钮。</li>
        <li>如提示数据库更新成功，则题目库已更新，可前往题目列表核实</li>
      </ol>
      </fieldset>
      </form>
      <br><br><br>
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
