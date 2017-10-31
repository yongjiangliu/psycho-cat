/**
 * 语言设定
 * languages
 * @author bcli
 * @music Linkin Park -- Numb
 */

var express = require('express');

var sqlite3 = require('sqlite3').verbose();
var db = new sqlite3.Database('./db/psycho-cat.db');



module.exports = db;

