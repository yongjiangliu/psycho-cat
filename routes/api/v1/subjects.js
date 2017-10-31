var express = require('express');
var router = express.Router();

/* GET users listing. */
router.get('/', function(req, res, next) {
    res.send(req.get('Accept-Language'));
});

/* GET users listing. */
router.get('/users', function(req, res, next) {
    res.send('respond with a resource');
});

/* GET questions */
router.get('/questions', function(req, res, next) {
    res.send('respond with a resource');
});

/* GET questions */
router.get('/questions/next', function(req, res, next) {
    res.send('respond with a resource');
});

/* GET score */
router.get('/users', function(req, res, next) {
    res.send('respond with a resource');
});
module.exports = router;