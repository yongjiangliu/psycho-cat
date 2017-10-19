/**
 * 给受试者看的页面
 * views for subjects
 * @author bcli
 * @email relidin@126.com
 */
// 需要使用express的API来定义路由
var express = require('express');
var router = express.Router();
/**
 * 1. /view/subject/
 *    重定向到/view/subject/info
 *    redirect to /view/subject/info
 */
router.get('/', function(req, res, next) {
  res.redirect('/subject/intro');
});

/**
 * 2. /view/subject/info
 *    受试者在此提供基本信息, 只有提交信息的受试者才能够获得受试者编号,进而开始测试
 *    subject needs to provide basic personal information, only then he/she can get the 'subject ID'
 *    and start/resume the test
 */
router.get('/info', function(req, res, next) {
  res.render('sbj-info', { title: '受试者信息', nav:[true,false,false]});
});

/**
 * 3. /view/subject/intro
 *    操作说明页面, 提供受试者编号, 说明基本操作方法
 *    test introductions, provide subject ID (for resuming test) and basic operation methods
 */
router.get('/intro', function(req, res, next) {
  res.render('sbj-intro', { title: '测试说明', nav:[true,false,false]});
});

/**
 * 4.  /view/subject/test
 *     测试页面, 在这里答题, 注意为了保证心理测试正确性, **只能顺序答题,无法返回**
 *     test page, for answering questions
 */
router.get('/test', function(req, res, next) {
  res.render('sbj-test', { title: '测试中',nav:[true,false,false]});
});

/**
 * 5.  /view/subject/done
 *     完成页面, 告知受试者测试已经完成
 *     show this page when the test is done
 */
router.get('/done', function(req, res, next) {
  res.render('sbj-done', { title: '测试完成', nav: 0, lang: req.lang});
});

/**
 * 6.  /view/subject/resume
 *     受试者可以在这个页面输入受试者编号继续答题, 这样当测试时间过长时,中间可以去吃个午饭:3
 *     for subjects using 'subject ID' to resume his/her test, in case they want to take a
 *     break for launch
 */
router.get('/resume', function(req, res, next) {
  res.render('sbj-resume', { title: '继续测试', nav:[false,true,false]});
});
// 把这个文件定义的函数共享出去, 以便express调用
module.exports = router;
