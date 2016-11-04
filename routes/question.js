var express = require('express');
var router = express.Router();

/*
* GET questions
*
* 1. user request a new question by question id
* 2. server check if user is valid and taking test
* 3. server get last_question_id from cookie and test if(last_question_id + 1 == request_question_id)
*    if so, retrieve target question and return it to user
*/
router.get('/', function(req, res, next) {

    // 1. is user valid & answering question ?

    // 2. is (last_question_id + 1 == request_question_id ?)

    // 3. is (request_question_id >= max_question_id ?)

    // 4. retrieve question

    // 5. send question back to user (AJAX JSON)

    res.send('respond with a resource');
});

module.exports = router;