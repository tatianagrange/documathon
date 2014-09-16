/* ************************* */
/*          Context          */
/* ************************* */
var documentationSteps;
var documentationStep;
var writing;
var Author = require('./Author.js').Author;
var myAuthor;
var Project = require('./Project.js').Project;
var MaterialAndTool = require('./MaterialAndTool.js').MaterialAndTool;
var Step = require('./Step.js').Step;
var actualStep;
var myProject;


/* ***************************** */
/*          Constructor          */
/* ***************************** */
exports.Context = Context = function() {
	this.documentationSteps = ["waitLog", "waitProject", "newProject", "stepPhoto", "validatePhoto", "stepText"];
	this.documentationStep = 0;
  	this.writing = false;
  	this.myAuthor = null;
  	this.myProject = null;
  	this.actualStep = null;
};


/* *************************** */
/*          Functions          */
/* *************************** */
Context.prototype.makeProject = function(json){
	this.myProject = new Project();
    return this.myProject.hydrateWithJson(json);
}

Context.prototype.saveActualStep = function(){
	this.myProject.addStep(this.actualStep);
}

Context.prototype.addMaterial = function(json){
	if(this.actualStep == null){
		this.actualStep = new Step();
	}

	var mat = new MaterialAndTool();
	mat.hydrateWithJson(json);
	this.actualStep.addMaterial(mat);
	var test =  this.actualStep.getMaterialsNames();
	return test;
}

Context.prototype.makeAuthor = function(json){
	this.myAuthor = new Author();
    return this.myAuthor.hydrateWithJson(json);
}