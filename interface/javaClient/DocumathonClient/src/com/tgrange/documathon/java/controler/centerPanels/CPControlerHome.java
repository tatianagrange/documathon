package com.tgrange.documathon.java.controler.centerPanels;

import javax.swing.JPanel;

import com.tgrange.documathon.java.controler.ICPControler;
import com.tgrange.documathon.java.controler.listeners.ButtonsListener;
import com.tgrange.documathon.java.gui.centerPanels.CPHome;
import com.tgrange.documathon.java.model.Author;

public class CPControlerHome implements ICPControler{

	private CPHome center;

	public CPControlerHome(){
		center = new CPHome();
	}
	
	public CPControlerHome(ButtonsListener ec){
		this();
		center.setEventCheat(ec);
	}
	
	@Override
	public JPanel getCenterPanel() {
		return center;
	}

	public void logWith(Author author) {
		center.changeWithLogString(author.getName());
	}
	
	

}
