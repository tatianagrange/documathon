package com.tgrange.documathon.java.gui.centerPanels;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.SwingConstants;

import com.tgrange.documathon.java.App;
import com.tgrange.documathon.java.controler.listeners.ButtonsListener;

public class CPHome extends JPanel {

	private static final long serialVersionUID = 1L;
	private ButtonsListener ec = null;
	private JLabel label;
	
	public void setEventCheat(ButtonsListener ec){
		if(App.IS_DEV)
			this.ec = ec;
	}
	
	public void changeWithLogString(String labelText) {
		this.label.setText("Bonjour " + labelText + "! Passe le badge de ton projet sur le symbole NFC!");
		
		if(App.IS_DEV){
			JButton btnLoginFaclab = new JButton("Projet Machin");
			remove(((BorderLayout) getLayout()).getLayoutComponent(BorderLayout.SOUTH));
			add(btnLoginFaclab, BorderLayout.SOUTH);
			btnLoginFaclab.addActionListener(new ActionListener() {
				public void actionPerformed(ActionEvent arg0) {
					ec.onProject(null);
				}
			});
		}
	}
	
	/**
	 * Create the panel.
	 */
	public CPHome() {
		setOpaque(false);
		setLayout(new BorderLayout(0, 0));
		
		label = new JLabel("Bienvenue sur le Documathon. Passez votre badge d'identification, ou le badge Faclab, au dessus du symbole NFC");
		add(label, BorderLayout.CENTER);
		label.setForeground(new Color(255, 255, 255));
		label.setHorizontalAlignment(SwingConstants.CENTER);
		label.setAlignmentX(CENTER_ALIGNMENT);
		label.setAlignmentY(CENTER_ALIGNMENT);
		//label.setFont(FontsSingleton.getInstance().getSintony());

		if(App.IS_DEV){
			JButton btnLoginFaclab = new JButton("Login Faclab");
			add(btnLoginFaclab, BorderLayout.SOUTH);
			btnLoginFaclab.addActionListener(new ActionListener() {
				public void actionPerformed(ActionEvent arg0) {
					ec.onLog(null);
				}
			});
		}
		

	}

}
