package com.tgrange.documathon.java.model;

import java.util.ArrayList;

public class Step {

    public int id;
    public String path;
    public String text;
    public int projectId;
    public ArrayList<Author> authors;
    
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
	 * @return the path
	 */
	public String getPath() {
		return path;
	}
	/**
	 * @param path the path to set
	 */
	public void setPath(String path) {
		this.path = path;
	}
	/**
	 * @return the text
	 */
	public String getText() {
		return text;
	}
	/**
	 * @param text the text to set
	 */
	public void setText(String text) {
		this.text = text;
	}
	/**
	 * @return the projectId
	 */
	public int getProjectId() {
		return projectId;
	}
	/**
	 * @param projectId the projectId to set
	 */
	public void setProjectId(int projectId) {
		this.projectId = projectId;
	}
	/**
	 * @return the authors
	 */
	public ArrayList<Author> getAuthors() {
		return authors;
	}
	/**
	 * @param authors the authors to set
	 */
	public void setAuthors(ArrayList<Author> authors) {
		this.authors = authors;
	}
	
	public Step(int id, String path, String text, int projectId,
			ArrayList<Author> authors) {
		super();
		this.id = id;
		this.path = path;
		this.text = text;
		this.projectId = projectId;
		this.authors = authors;
	}
	
	public Step(int projectId2) {
		this.projectId = projectId2;
	}
    
    
}
