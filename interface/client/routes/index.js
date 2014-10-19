var express = require('express');
var router = express.Router();
var util = require('../classes/Util');

var isDev = true;

/* GET home page. */
router.get('/', function(req, res) {
	res.render('index', { title: 'Documathon', dev: util.isDev });
});

module.exports = router;
