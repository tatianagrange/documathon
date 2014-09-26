var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function(req, res) {
	res.render('index', { title: 'Documathon' });
});

/* GET home page. */
router.get('/images', function(req, res) {
	res.render('images', { title: 'Documathon' });
});

module.exports = router;
