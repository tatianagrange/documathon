package com.tgrange.documathon.java.gui.components;

import java.awt.Graphics;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;

import javax.imageio.ImageIO;
import javax.swing.JPanel;

public class ImagePanel extends JPanel{

	private static final long serialVersionUID = -3339026606222363200L;
	private BufferedImage image;
	private String name;

	public ImagePanel(String name) {
       try {        
    	   this.name = name;
          image = ImageIO.read(new File(name));
       } catch (IOException ex) {
       }
    }
	
    /**
	 * @return the name
	 */
	public String getName() {
		return name;
	}

    @Override
    protected void paintComponent(Graphics g) {
        super.paintComponent(g);
        g.drawImage(image, 0, 0, null);
    }
}