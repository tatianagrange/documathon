package com.tgrange.documathon.java.model;

import java.sql.Timestamp;

public class Author {
	public int id;
    public String name;
    public Timestamp birth;
    
    
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
	/**
	 * @return the birth
	 */
	public Timestamp getBirth() {
		return birth;
	}
	/**
	 * @param birth the birth to set
	 */
	public void setBirth(Timestamp birth) {
		this.birth = birth;
	}
	
	
	public Author(int id, String name, Timestamp birth) {
		super();
		this.id = id;
		this.name = name;
		this.birth = birth;
	}
    
    
}
