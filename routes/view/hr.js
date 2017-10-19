var express = require('express');
var router = express.Router();

/**
 * ------------------
 * 给HR看的页面
 * views for HR
 * ------------------
 */
/**
 * /view/hr/
 * /view/hr/overall
 * 管理页面
 *   HR能够在这里能查询
 *   a. 所有已注册的受试者
 *   b. 所有受试者的答题情况
 *   c. 所有受试者的测试的代码
 *   d. 完成答题的受试者的总得分
 *   e. 题目预览
 *
 *   HR在这里能够操作
 *   a. 阻止受试者继续答题(未完成的)
 *   b. 删除受试者的资料(包括答题记录)
 *   c. 上传新的题目合集(会覆盖已有的题目数据)
 *   d. 导出受试者的答题记录
 *   e. 导出受试者列表
 */

/**
 * /view/hr/users
 * /view/hr/tests
 * /view/hr/
 */
router.get('/test', function(req, res, next) {
  res.render('test', { title: 'Express' });
});


module.exports = router;
