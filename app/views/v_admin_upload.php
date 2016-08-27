<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="navbar" class="collapse navbar-collapse">
  <ul class="nav navbar-nav">
    <li><a href="<?=$HOME?>"><?=$this->lang->line('nav_home')?></a></li>
    <li><a href="<?=$ADMIN?>/panel/exam/get/all"><?=$this->lang->line('nav_admin_exams')?></a></li>
    <li><a href="<?=$ADMIN?>/panel/question/get/all"><?=$this->lang->line('nav_admin_questions')?></a></li>
    <li class="active"><a href="<?=$ADMIN?>/panel/upload"><?=$this->lang->line('nav_admin_upload')?></a></li>
  </ul>
  <form id="searchAnswer" class="navbar-form navbar-right" action="<?=$ADMIN?>/panel/exam/get/name" method="post">
    <div class="form-group">
      <input type="text" id="name" name="name" placeholder="<?=$this->lang->line('nav_admin_subject_name')?>" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-default"><?=$this->lang->line('nav_admin_search')?></button>
  </form>
</div>
</div>
</nav>

<div class="container-fluid">
    <div class="row" style="margin-top:50px;">
        <div class="col-sm-4 col-sm-offset-4 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
            <h3><?=$this->lang->line('admin_how_to_upload_questions')?></h3>
            <hr>
            <div class="panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">1. <?=$this->lang->line('admin_download_excel_template')?></h4>
                </div>
                <div class="panel-body">
                    <a href="<?=$TEMPLATE?>template.xls"><?=$this->lang->line('admin_excel_template')?></a><br>
                </div>
            </div>
            <div class="panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">2. <?=$this->lang->line('admin_save_as_csv')?></h4>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <th><?=$this->lang->line('admin_symbol')?></th>
                            <th><?=$this->lang->line('admin_create')?></th>
                        </tr>
                        <tr>
                            <td><kbd>[b]</kbd> Bold <kbd>[/b]</kbd> Text </td>
                            <td><strong> Bold </strong> Text </td>
                        </tr>
                        <tr>
                            <td><kbd>[i]</kbd> Italic <kbd>[/i]</kbd> Text </td>
                            <td><i> Italic </i> Text</td>
                        </tr>
                        <tr>
                            <td><kbd>[u]</kbd> Underline <kbd>[/u]</kbd> Text </td>
                            <td><u> Underline </u> Text</td>
                        </tr>
                        <tr>
                            <td>Line and <kbd>[r]</kbd> New line</td>
                            <td>Line and <br> New line</td>
                        </tr>
                        <tr>
                            <td><kbd>[img]</kbd> cat.jpg <kbd>[/img]</kbd></td>
                            <td><img src="<?=$EXAM_IMG?>cat.jpg"></td>
                        </tr>
                        <tr>
                            <td>Image Dir</td>
                            <td>./res/exam_img/</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">3. <?=$this->lang->line('admin_upload_csv_file')?></h4>
                </div>
                <div class="panel-body">
                    <br>
                    <form action ="<?=$ADMIN?>/upload" method="POST">
                        <input type="file" required><br>
                        <button class="btn-sm btn-default" type="submit"><?=$this->lang->line('form_submit')?></button>
                    </form>
                </div>
            </div>
        </div>
</div>
