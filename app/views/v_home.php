<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?=$ADMIN?>"><?=$lang->line("nav_admin_login")?></a></li>
            <li><a href="<?=$HOME?>/enterTestId"><?=$lang->line("nav_test_id")?></a></li>
          </ul>
          <div class="navbar-right" >
            <ul class="nav navbar-nav">
              <li>
                <a href="https://github.com/bclicn/PsychTest" target="_blank">
                <img src="<?=$IMG?>/icon_github.png" alt="GitHub" class="img-rounded" style="padding:0px; margin:0px;">&nbsp;&nbsp;<?=$lang->line("nav_github")?>
                </a>
              </li>
            </ul>
          </div>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container-fluid">
      <form id="userInfo" class="form-horizontal" method="post" action="<?=$HOME?>/getTestId">
        <?php
            $style = "";
            if (!$rejectedForm)
            {
              $style="style='display:none;'";
            }
        ?>
          <div class="alert alert-danger" role="alert" <?=$style?>>
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              <span class="sr-only">Error:</span>
                  <?=$lang->line("form_error")?>
          </div>
        <!-- Name -->
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label"><?=$lang->line("form_name")?></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="name">
          </div>
        </div>
        <!-- Occupation -->
        <div class="form-group">
            <label for="occupation" class="col-sm-2 control-label"><?=$lang->line("form_occupation")?></label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="occupation" name="occupation">
            </div>
        </div>
        <!-- Gender -->
        <div class="form-group">
          <label for="gender" class="col-sm-2 control-label"><?=$lang->line("form_gender")?></label>
          <div class="col-sm-10">
            <select class="form-control" id="gender" name="gender">
              <option value=""><?=$lang->line("form_select")?></option>
              <option value="<?=$lang->line("form_gender_male")?>"><?=$lang->line("form_gender_male")?></option>
              <option value="<?=$lang->line("form_gender_female")?>"><?=$lang->line("form_gender_female")?></option>
            </select>
          </div>
        </div>
        <!-- Birthday -->
        <div class="form-group">
            <label for="birthday" class="col-sm-2 control-label"><?=$lang->line("form_birthday")?></label>
            <div class="col-sm-10">
              <input type="text" class="date-picker form-control" id="birthday" name="birthday" placeholder="YYYY-MM-DD"/>
            </div>
        </div>

        <!-- Education -->
        <div class="form-group">
          <label for="education" class="col-sm-2 control-label"><?=$lang->line("form_education")?></label>
          <div class="col-sm-10">
            <select class="form-control" id="education" name="education">
              <option value=""><?=$lang->line("form_select")?></option>
              <option value="<?=$lang->line("form_education_phd")?>"><?=$lang->line("form_education_phd")?></option>
              <option value="<?=$lang->line("form_education_master")?>"><?=$lang->line("form_education_master")?></option>
              <option value="<?=$lang->line("form_education_bachelor")?>"><?=$lang->line("form_education_bachelor")?></option>
              <option value="<?=$lang->line("form_education_senior")?>"><?=$lang->line("form_education_senior")?></option>
              <option value="<?=$lang->line("form_education_junior")?>"><?=$lang->line("form_education_junior")?></option>
              <option value="<?=$lang->line("form_education_primary")?>"><?=$lang->line("form_education_primary")?></option>
            </select>
          </div>
        </div>
        <!-- Blood Type -->
        <div class="form-group">
          <label for="bloodType" class="col-sm-2 control-label"><?=$lang->line("form_blood_type")?></label>
          <div class="col-sm-10">
            <select class="form-control" id="bloodType" name="bloodType">
              <option value=""><?=$lang->line("form_select")?></option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="AB">AB</option>
              <option value="O">O</option>
            </select>
          </div>
        </div>
        <!-- Marriage -->
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label"><?=$lang->line("form_marriage")?></label>
          <div class="col-sm-10">
            <select class="form-control" id="marriage" name="marriage">
              <option value=""><?=$lang->line("form_select")?></option>
              <option value="<?=$lang->line("form_marriage_married")?>"><?=$lang->line("form_marriage_married")?></option>
              <option value="<?=$lang->line("form_marriage_unmarried")?>"><?=$lang->line("form_marriage_unmarried")?></option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default"><?=$lang->line("form_submit")?></button>
          </div>
        </div>
        </form>
      </div>
    </div>
    <!-- /.container -->
