var id;
var name;

exports.MaterialAndTool = MaterialAndTool = function(base64) {
	this.id = null;
  	this.name = null;
};

MaterialAndTool.prototype.hydrateWithJson = function(json){
	try{
		var obj = JSON.parse(json);
		this.id = obj.id;
		this.name = obj.name;
		return 1;
	}
	catch(e){
		return 0;
	}
}