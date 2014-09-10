/* ************************* */
/*          Context          */
/* ************************* */
var documentationSteps;
var documentationStep;
var writing;
var Author = require('./Author.js').Author;
var myAuthor;
var Project = require('./Project.js').Project;
var myProject;


/* ***************************** */
/*          Constructor          */
/* ***************************** */
exports.Context = Context = function() {
	this.documentationSteps = ["waitLog", "waitProject", "newProject", "stepPhoto", "validatePhoto"];
	this.documentationStep = 0;
  	this.writing = false;
  	this.myAuthor = null;
  	this.myProject = null;
};


/* *************************** */
/*          Functions          */
/* *************************** */
Context.prototype.makeProject = function(json){
	this.myProject = new Project();
    return this.myProject.hydrateWithJson(json);
}

Context.prototype.addStep = function(base64){
	
}

Context.prototype.makeAuthor = function(json){
	this.myAuthor = new Author();
    return this.myAuthor.hydrateWithJson(json);
}