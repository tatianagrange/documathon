package com.tgrange.documathon.java.gui.centerPanels;

import java.awt.BorderLayout;
import java.awt.Component;
import java.awt.Dimension;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTextArea;
import javax.swing.SwingConstants;

import com.github.sarxos.webcam.Webcam;
import com.github.sarxos.webcam.WebcamPanel;
import com.tgrange.documathon.java.App;
import com.tgrange.documathon.java.controler.listeners.ButtonsListener;

public class CPStep extends JPanel {

	private static final long serialVersionUID = 1L;
	private ButtonsListener ec = null;
	
	private WebcamPanel videoPanel;
	private JPanel centerPanel;
	private JLabel image;
	private JPanel footer;
	private JTextArea textArea;

	public CPStep(Webcam webcam) {
		
		videoPanel = new WebcamPanel(webcam);
		videoPanel.setFPSDisplayed(true);
		videoPanel.setFPSLimited(true);
		videoPanel.setFPSLimit(1);
		videoPanel.setAlignmentX(Component.CENTER_ALIGNMENT);
		videoPanel.setAlignmentY(Component.CENTER_ALIGNMENT);
		videoPanel.setSize(webcam.getViewSize());
		
		setLayout(new BorderLayout(0, 0));
		setOpaque(false);
		
		centerPanel = new JPanel();
		centerPanel.setOpaque(false);
		centerPanel.setSize(webcam.getViewSize());
		centerPanel.setAlignmentX(Component.CENTER_ALIGNMENT);
		centerPanel.setAlignmentY(Component.CENTER_ALIGNMENT);
		add(centerPanel, BorderLayout.CENTER);
		centerPanel.add(videoPanel);
		
		footer = new JPanel();
		footer.setOpaque(false);
		
		JButton b = new JButton("Valider");
		footer.add(b);
		
		
		if(App.IS_DEV){
			b.addActionListener(new ActionListener() {
				@Override
				public void actionPerformed(ActionEvent arg0) {
					ec.onBtnDone();
				}
			});
			
			JPanel pan = new JPanel();
			pan.setLayout(new BorderLayout());
			
			pan.add(footer, BorderLayout.CENTER);
			
			JButton share = new JButton("Share");
			share.addActionListener(new ActionListener() {
				
				@Override
				public void actionPerformed(ActionEvent arg0) {
					ec.onShareOn("twifac");
				}
			});
			pan.add(share, BorderLayout.SOUTH);
			pan.setOpaque(false);
			
			add(pan, BorderLayout.SOUTH);
			
		}else{
			add(footer, BorderLayout.SOUTH);
		}
			
		
	}

	public void setEventCheat(ButtonsListener ec){
		if(App.IS_DEV)
			this.ec = ec;
	}
	
	public void changeToValidatePhoto(String name){
		JButton b2 = null;
		if(footer.getComponentCount() < 2){
			b2 = new JButton();
			b2.setText("Annuler");
			footer.add(b2,0);
			footer.revalidate();
		}
		
		centerPanel.removeAll();
		
		if(name != null)
			image = new JLabel(new ImageIcon(name));
		centerPanel.add(image);

		if(App.IS_DEV && b2 != null){
			b2.addActionListener(new ActionListener() {
				@Override
				public void actionPerformed(ActionEvent arg0) {
					ec.onBtnCancel();
				}
			});
		}
		
		centerPanel.repaint();
		centerPanel.revalidate();
	}

	public void changeToVideo() {
		if(footer.getComponentCount() >= 2){
			footer.remove(0);
			footer.repaint();
			footer.revalidate();
		}
		
		centerPanel.removeAll();
		centerPanel.add(videoPanel);
	}

	public void changeToValidateText() {
		centerPanel.removeAll();
		
		JLabel lab = new JLabel("Ajoute du texte (optionnel), ou passe des tags NFC de matériaux ou d'outils");
		lab.setPreferredSize(new Dimension((int) Toolkit.getDefaultToolkit().getScreenSize().getWidth(),30));
		lab.setHorizontalAlignment(SwingConstants.CENTER);
		centerPanel.add(lab);
		
		if(textArea == null){
			textArea = new JTextArea(30,40);
			textArea.setLineWrap(true);
	        textArea.setWrapStyleWord(true);
		}
		
		centerPanel.add(textArea);
		centerPanel.repaint();
		centerPanel.revalidate();
		
	}
	
	public String getTextFromTextAera(){
		return textArea.getText();
	}

	public void changeToValidateText(String path, String text) {
		centerPanel.removeAll();
		
		JLabel lab = new JLabel("Ajouter l'étape?");
		lab.setPreferredSize(new Dimension((int) Toolkit.getDefaultToolkit().getScreenSize().getWidth(),30));
		lab.setHorizontalAlignment(SwingConstants.CENTER);
		centerPanel.add(lab);
		
		centerPanel.add(image);
		
		JTextArea ta = new JTextArea();
		ta.setLineWrap(true);
        ta.setWrapStyleWord(true);
        ta.setEditable(false);
        ta.setText(text);
        ta.setPreferredSize(image.getSize());
		
		centerPanel.add(ta);
		centerPanel.repaint();
		centerPanel.revalidate();
		
	}

	public void reset() {
		image = null;
		textArea = null;
		changeToVideo();
		repaint();
		revalidate();
	}

}
