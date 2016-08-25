<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="zh">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PsychoCat">
    <meta name="author" content="bcli">
    <link rel="icon" href="<?=$IMG?>favicon.ico">
    <link href="<?=$CSS?>bootstrap.min.css" rel="stylesheet">
    <link href="<?=$CSS?>ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="<?=$CSS?>home.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="<?=$JS?>html5shiv.min.js"></script>
      <script src="<?=$JS?>respond.min.js"></script>
    <![endif]-->
    <title><?=$APP_NAME?></title>
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
