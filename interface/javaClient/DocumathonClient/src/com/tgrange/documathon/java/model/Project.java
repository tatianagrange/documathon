package com.tgrange.documathon.java.model;

import java.sql.Timestamp;
import java.util.ArrayList;

public class Project {

	public int id;
    public Timestamp date;
    public String name;
    public ArrayList<Step> steps;
    public ArrayList<Material> materials;
    public ArrayList<Tool> tools;
    public String lang;
    
	public Project(int id, String name) {
		super();
		this.id = id;
		this.name = name;
		this.materials = new ArrayList<Material>();
		this.tools = new ArrayList<Tool>();
		this.steps = new ArrayList<Step>();
	}    

    public Project(int id, Timestamp date, String name, ArrayList<Step> steps,
			ArrayList<Material> materials, ArrayList<Tool> tools, String lang) {
		super();
		this.id = id;
		this.date = date;
		this.name = name;
		this.steps = steps;
		this.materials = materials;
		this.tools = tools;
		this.lang = lang;
	}

	/**
	 * @return the id
	 */
	public int getId() {
		return id;
	}

	/**
	 * @param id the id to set
	 */
	public void setId(int id) {
		this.id = id;
	}

	/**
	 * @return the date
	 */
	public Timestamp getDate() {
		return date;
	}

	/**
	 * @param date the date to set
	 */
	public void setDate(Timestamp date) {
		this.date = date;
	}

	/**
	 * @return the name
	 */
	public String getName() {
		return name;
	}

	/**
	 * @param name the name to set
	 */
	public void setName(String name) {
		this.name = name;
	}

	/**
	 * @return the steps
	 */
	public ArrayList<Step> getSteps() {
		return steps;
	}

	/**
	 * @param steps the steps to set
	 */
	public void setSteps(ArrayList<Step> steps) {
		this.steps = steps;
	}

	/**
	 * @return the materials
	 */
	public ArrayList<Material> getMaterials() {
		return materials;
	}

	/**
	 * @param materials the materials to set
	 */
	public void setMaterials(ArrayList<Material> materials) {
		this.materials = materials;
	}

	/**
	 * @return the tools
	 */
	public ArrayList<Tool> getTools() {
		return tools;
	}

	/**
	 * @param tools the tools to set
	 */
	public void setTools(ArrayList<Tool> tools) {
		this.tools = tools;
	}

	/**
	 * @return the lang
	 */
	public String getLang() {
		return lang;
	}

	/**
	 * @param lang the lang to set
	 */
	public void setLang(String lang) {
		this.lang = lang;
	}

	public void addMaterial(Material mat) {
		boolean alreadyInList = false;
		for(Material m : materials){
			if(m.getId() == mat.getId()){
				alreadyInList = true;
				break;
			}
		}
		if(!alreadyInList){
			materials.add(mat);
		}
		
	}
    
}
