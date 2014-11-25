package com.tgrange.documathon.java.controler.centerPanels;

import java.awt.Dimension;
import java.awt.Toolkit;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.nio.channels.FileChannel;
import java.util.ArrayList;

import javax.imageio.ImageIO;
import javax.swing.JPanel;

import com.github.sarxos.webcam.Webcam;
import com.github.sarxos.webcam.WebcamUtils;
import com.tgrange.documathon.java.controler.ICPControler;
import com.tgrange.documathon.java.controler.listeners.ButtonsListener;
import com.tgrange.documathon.java.gui.centerPanels.CPStep;
import com.tgrange.documathon.java.model.Author;
import com.tgrange.documathon.java.model.Project;
import com.tgrange.documathon.java.model.Step;

public class CPControlerStep  implements ICPControler, ButtonsListener{

	Webcam webcam = Webcam.getWebcams().get(0);
	public enum State {VIDEO, VALIDATE_PHOTO, VALIDATE_TEXT, VALIDATE_STEP}
	private Step actualStep;
	private ArrayList<Step> steps;
	private int projectId;
	private State state = State.VIDEO;
	
	private CPStep center;

	private ButtonsListener ec;
	
	public CPControlerStep(int projectId){
		Dimension[] dimensions = webcam.getViewSizes();
		for(Dimension d : dimensions){
			if(d.width <= Toolkit.getDefaultToolkit().getScreenSize().getWidth()/3){
				webcam.setViewSize(d);
			}
			else
				break;
		}
		
		center = new CPStep(webcam);
		actualStep = new Step(projectId);
		this.projectId = projectId;
		steps = new ArrayList<Step>();
	}
	
	public CPControlerStep(ButtonsListener ec, int projectId){
		this(projectId);
		this.ec = ec;
		center.setEventCheat(this);
	}
	
	/**
	 * @return the steps
	 */
	public ArrayList<Step> getSteps() {
		return steps;
	}
	
	public void stopWebcam(){
		webcam.close();
	}
	
	@Override
	public JPanel getCenterPanel() {
		return center;
	}

	@Override
	public void onBtnCancel() {
		switch(state){
		case VALIDATE_PHOTO:
			state = State.VIDEO;
			center.changeToVideo();
			return;
		case VALIDATE_TEXT:
			state = State.VALIDATE_PHOTO;
			center.changeToValidatePhoto(null);
			return;
		case VALIDATE_STEP:
			state = State.VALIDATE_TEXT;
			center.changeToValidateText();
			return;
		default:
			break;
		}
	}

	@Override
	public void onBtnDown() {
	}

	@Override
	public void onBtnDone() {
		switch(state){
		case VIDEO:
			state = State.VALIDATE_PHOTO;
			BufferedImage image = webcam.getImage();
			try {
				String name = System.currentTimeMillis() + ".png";
				ImageIO.write(image, "PNG", new File(name));
				actualStep.setPath(name);
				center.changeToValidatePhoto(name);
			} catch (IOException e) {
				e.printStackTrace();
			}
			return;
		case VALIDATE_PHOTO:
			state = State.VALIDATE_TEXT;
			center.changeToValidateText();
			return;
		case VALIDATE_TEXT:
			state = State.VALIDATE_STEP;
			actualStep.setText(center.getTextFromTextAera());
			center.changeToValidateText(actualStep.getPath(), actualStep.getText());
			return;
		case VALIDATE_STEP:
			state = State.VIDEO;
			steps.add(actualStep);
			actualStep = new Step(this.projectId);
			center.reset();
			return;
		}
	}
	
	@Override
	public void onBtnTop() {
		
	}

	@Override
	public void onShareOn(String substring) {
		ec.onShareOn("twifac");
	}

	
	@Override
	public void onTool(String substring) {}
	@Override
	public void onMaterial(String substring) {}
	@Override
	public void onLog(Author author) {}
	@Override
	public void onProject(Project project) {}
	@Override
	public void onNotification() {}
	@Override
	public void onServerInstruction() {}
	
	
}
