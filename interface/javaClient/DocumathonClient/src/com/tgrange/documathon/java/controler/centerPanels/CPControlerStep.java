package com.tgrange.documathon.java.controler.centerPanels;

import java.awt.Dimension;
import java.awt.Toolkit;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.util.ArrayList;

import javax.imageio.ImageIO;
import javax.swing.JPanel;

import com.github.sarxos.webcam.Webcam;
import com.tgrange.documathon.java.controler.ICPControler;
import com.tgrange.documathon.java.controler.listeners.ButtonsListener;
import com.tgrange.documathon.java.gui.centerPanels.CPStep;
import com.tgrange.documathon.java.model.Author;
import com.tgrange.documathon.java.model.Material;
import com.tgrange.documathon.java.model.Project;
import com.tgrange.documathon.java.model.Step;
import com.tgrange.documathon.java.model.Tool;

public class CPControlerStep  implements ICPControler, ButtonsListener{

	Webcam webcam = Webcam.getWebcams().get(0);
	public enum State {VIDEO, VALIDATE_PHOTO, VALIDATE_TEXT, VALIDATE_STEP}
	private Step actualStep;
	private ArrayList<Step> steps;
	private ArrayList<Tool> tools;
	private ArrayList<Material> materials;
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
		tools = new ArrayList<Tool>();
		materials = new ArrayList<Material>();
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
	
	public void addMaterial(Material mat) {
		boolean b = false;
		System.out.println(materials.size());
		for(Material m : materials){
			if(m.getId() == mat.getId()){
				materials.remove(m);
				b = true;
				break;
			}
		}
		if(!b)
			materials.add(mat);
		System.out.println(materials.size());
		center.updateTextForMaterial(getTextForMaterials());
	}
	
	public void addTool(Tool tool) {
		Integer index = null;
		for(Tool t : tools){
			if(t.getId() == tool.getId()){
				index = tools.indexOf(t);
				break;
			}
		}
		if(index == null)
			tools.add(tool);
		else
			tools.remove(index);
		
		center.updateTextForMaterial(getTextForTools());
	}
	
	private String getTextForTools(){
		if(tools.size() == 0)
			return "";
		
		String toReturn = ">Outils: ";
		for(Tool tool : tools){
			toReturn += tool.getName();
			toReturn += ", ";
		}
		
		toReturn = toReturn.substring(0, toReturn.length()-2) + ".\n";
		return toReturn;
	}
	
	private String getTextForMaterials(){
		if(materials.size() == 0)
			return "";
		
		String toReturn = ">Matériaux: ";
		for(Material mat : materials){
			toReturn += mat.getName();
			//Show width, lenght and thickness
			toReturn += ", ";
		}
		
		toReturn = toReturn.substring(0, toReturn.length()-2) + ".\n";
		return toReturn;
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
			tools = new ArrayList<Tool>();
			materials = new ArrayList<Material>();
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
	public void onTool(Tool tools) {}
	@Override
	public void onMaterial(Material mat) {}
	@Override
	public void onLog(Author author) {}
	@Override
	public void onProject(Project project) {}
	@Override
	public void onNotification() {}
	@Override
	public void onServerInstruction() {}




	
	
}
