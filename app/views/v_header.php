<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="<?=$lang->line("page_lang")?>">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="PsychTest">
    <meta name="author" content="bcli">
    <link rel="icon" href="<?=$ICON?>favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="<?=$CSS?>bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?=$CSS?>ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom style -->
    <link href="<?=$CSS?>home.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?=$JS?>html5shiv.min.js"></script>
      <script src="<?=$JS?>respond.min.js"></script>
    <![endif]-->
    <title><?=$lang->line("page_title")?></title>
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
            <a class="navbar-brand" style="padding-top:0px;">
              <img src="<?=$IMG?>/icon_psychtest.png" alt="PsychTest" title="PsychTest"/>
            </a>
          </div>
