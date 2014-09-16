var id;
var base;
var text;
var materials;
var tools;

exports.Step = Step = function() {
	this.id = null;
  	this.base = null;
  	this.text = null;
  	this.materials = null;
  	this.tools = null;
};

Step.prototype.getMaterialsNames = function(){
	var toReturn = new Array();
	for(var index in this.materials) { 
		toReturn[index] = (this.materials[index]).name;
	}
	return toReturn;
}

Step.prototype.addMaterial = function(mat){
	if(this.materials == null){
		this.materials = new Array();
	}


	for(var index in this.materials) { 
		var locMat = this.materials[index];
		if(locMat.id == mat.id){
			this.materials.splice(index, 1);
			return;
		}
	}

	this.materials.push(mat);
}

