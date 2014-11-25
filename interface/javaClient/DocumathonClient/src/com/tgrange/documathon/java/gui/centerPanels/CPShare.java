package com.tgrange.documathon.java.gui.centerPanels;

import java.awt.FlowLayout;

import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JProgressBar;

public class CPShare extends JPanel {

	private static final long serialVersionUID = 3831397164117351242L;
	
	private float max;
	private float current;

	private JLabel progressBarLabel;

	private JProgressBar progressBar;

	/**
	 * Create the panel.
	 * @param i 
	 */
	public CPShare(int i) {
		setLayout(new FlowLayout(FlowLayout.CENTER, 5, 5));
		setOpaque(false);
		max = i;
		current = 0;
		
		progressBarLabel = new JLabel("Les étapes sont envoyées sur le serveur");
		add(progressBarLabel);
		
		progressBar = new JProgressBar(0,100);
		progressBar.setValue((int) ((current/max) * 100));
		progressBar.setStringPainted(true);
		progressBar.setString("Envoi en cours");
		add(progressBar);

	}

	public void increment() {
		current++;
		progressBar.setString("Etape " + current + "/" + max);
		progressBar.setValue((int) ((current/max) * 100));
		progressBar.repaint();
	}

	public void end(String replace) {
		remove(progressBar);
		
		progressBarLabel.setText("Partage terminé. Voir le lien ici: " + replace + "\n Appuyer sur Valider pour passer à la suite");
	}

}
