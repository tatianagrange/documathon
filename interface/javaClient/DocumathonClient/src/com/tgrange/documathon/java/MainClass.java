package com.tgrange.documathon.java;

import java.awt.EventQueue;

import com.tgrange.documathon.java.controler.MainControler;

public class MainClass {

	/**
	 * Launch the application.
	 */
	
	public static void main(String[] args) {
		EventQueue.invokeLater(new Runnable() {
			public void run() {
				new MainControler();
			}
		});
	}
}
