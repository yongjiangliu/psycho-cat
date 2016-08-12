<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?=$ADMIN?>"><?=$this->lang->line("nav_admin_login")?></a></li>
            <li><a href="<?=$HOME?>/enterResumeCode"><?=$this->lang->line("nav_resume_exam")?></a></li>
          </ul>
          <ul id="nav-images" class="nav navbar-nav navbar-right">
            <li>
              <a href="https://github.com/bclicn/PsychoCat">
                <img title="<?=$this->lang->line("nav_github")?>" src="<?=$IMG?>/github.png">
              </a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <img title="<?=$this->lang->line("nav_language")?>" src="<?=$IMG?>/lang.png">
              </a>
              <ul class="dropdown-menu">
                <?php
                  foreach ($LANGS as $langCode => $langTxt)
                  {
                    echo "<li><a href='".$HOME."/lang/".$langCode."'>".$langTxt."</a></li>";
                  }
                ?>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container-fluid">
      <form id="userInfo" class="form-horizontal" method="post" action="<?=$HOME?>/getTestCode">
        <!-- Name -->
        <div class="form-group">
          <label for="name" class="col-sm-3 control-label"><?=$this->lang->line("subject_name")?></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="name" name="name">
          </div>
        </div>
        <!-- Occupation -->
        <div class="form-group">
            <label for="occupation" class="col-sm-3 control-label"><?=$this->lang->line("subject_occupation")?></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="occupation" name="occupation">
            </div>
        </div>
        <!-- Gender -->
        <div class="form-group">
          <label for="gender" class="col-sm-3 control-label"><?=$this->lang->line("subject_gender")?></label>
          <div class="col-sm-9">
            <select class="form-control" id="gender" name="gender">
              <option value=""><?=$this->lang->line("form_select")?></option>
              <option value="1"><?=$this->lang->line("gender_male")?></option>
              <option value="0"><?=$this->lang->line("gender_female")?></option>
            </select>
          </div>
        </div>
        <!-- Birthday -->
        <div class="form-group">
            <label for="birthday" class="col-sm-3 control-label"><?=$this->lang->line("subject_birthday")?></label>
            <div class="col-sm-9">
              <input type="text" class="date-picker form-control" id="birthday" name="birthday" placeholder="YYYY-MM-DD"/>
            </div>
        </div>

        <!-- Education -->
        <div class="form-group">
          <label for="education" class="col-sm-3 control-label"><?=$this->lang->line("subject_education")?></label>
          <div class="col-sm-9">
            <select class="form-control" id="education" name="education">
              <option value=""><?=$this->lang->line("form_select")?></option>
              <option value="1"><?=$this->lang->line("education_grade_school")?></option>
              <option value="2"><?=$this->lang->line("education_middle_school")?></option>
              <option value="3"><?=$this->lang->line("education_high_school")?></option>
              <option value="4"><?=$this->lang->line("education_bachelor")?></option>
              <option value="5"><?=$this->lang->line("education_master")?></option>
              <option value="6"><?=$this->lang->line("education_phd")?></option>
            </select>
          </div>
        </div>
        <!-- Blood Type -->
        <div class="form-group">
          <label for="bloodType" class="col-sm-3 control-label"><?=$this->lang->line("subject_blood_type")?></label>
          <div class="col-sm-9">
            <select class="form-control" id="bloodType" name="bloodType">
              <option value=""><?=$this->lang->line("form_select")?></option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="AB">AB</option>
              <option value="O">O</option>
            </select>
          </div>
        </div>
        <!-- Marriage -->
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label"><?=$this->lang->line("subject_marriage")?></label>
          <div class="col-sm-9">
            <select class="form-control" id="marriage" name="marriage">
              <option value=""><?=$this->lang->line("form_select")?></option>
              <option value="1"><?=$this->lang->line("marriage_married")?></option>
              <option value="0"><?=$this->lang->line("marriage_unmarried")?></option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-10">
            <button type="submit" class="btn btn-default"><?=$this->lang->line("form_submit")?></button>
          </div>
        </div>
        </form>
      </div>
    </div><!-- /.container -->