var id;
var name;
var birth;

exports.Author = Author = function() {
	this.id = null;
  	this.name = null;
  	this.birth = null;
};

Author.prototype.hydrateWithJson = function(json){
	try{
		var obj = JSON.parse(json);
		this.id = obj.id;
		this.name = obj.name;
		this.birth = obj.birth;
		return 1;
	}
	catch(e){
		return 0;
	}
}
