package com.tgrange.documathon.java.model;

public class Tool {

    public int id;
    public String name;
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
	
	public Tool(int id, String name) {
		super();
		this.id = id;
		this.name = name;
	}
    
    
}
