var id;
var name;
var date;
var start;
var lang;

exports.Project = Project = function() {
	this.id = null;
  	this.name = null;
  	this.date = null;
  	this.start = null;
  	this.lang = null;
};

Project.prototype.hydrateWithJson = function(json){
	try{
		var obj = JSON.parse(json);
		this.id = obj.id;
		this.name = obj.name;
		this.date = obj.date;
		this.start = obj.start;
		this.lang = obj.lang;
		return 1;
	}
	catch(e){
		return 0;
	}
}
