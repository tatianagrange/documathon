package com.tgrange.documathon.java.model;

public class Material {

    public int id;
    public String name;
    public float width;
    public float length;
    public float thickness;
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
	 * @return the width
	 */
	public float getWidth() {
		return width;
	}
	/**
	 * @param width the width to set
	 */
	public void setWidth(float width) {
		this.width = width;
	}
	/**
	 * @return the length
	 */
	public float getLength() {
		return length;
	}
	/**
	 * @param length the length to set
	 */
	public void setLength(float length) {
		this.length = length;
	}
	/**
	 * @return the thickness
	 */
	public float getThickness() {
		return thickness;
	}
	/**
	 * @param thickness the thickness to set
	 */
	public void setThickness(float thickness) {
		this.thickness = thickness;
	}
	
	
	public Material(int id, String name, float width, float length,
			float thickness) {
		super();
		this.id = id;
		this.name = name;
		this.width = width;
		this.length = length;
		this.thickness = thickness;
	}
	
	public Material(int id, String name) {
		super();
		this.id = id;
		this.name = name;
	}
    
    
}
