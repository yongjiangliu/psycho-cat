var express = require('express');
var router = express.Router();

/* GET home page.
*
*  print user info form
*/
router.get('/', function(req, res, next) {
  res.render('home', { title: 'Express' });
});

module.exports = router;
