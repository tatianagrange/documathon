package com.tgrange.documathon.java.controler;

import javax.swing.JFrame;

import jssc.SerialPort;
import jssc.SerialPortException;
import jssc.SerialPortList;

import com.tgrange.documathon.java.controler.centerPanels.CPControlerHome;
import com.tgrange.documathon.java.controler.centerPanels.CPControlerShare;
import com.tgrange.documathon.java.controler.centerPanels.CPControlerStep;
import com.tgrange.documathon.java.controler.listeners.ButtonsListener;
import com.tgrange.documathon.java.controler.listeners.MenuListener;
import com.tgrange.documathon.java.gui.DocumathonJFrame;
import com.tgrange.documathon.java.model.Author;
import com.tgrange.documathon.java.model.Material;
import com.tgrange.documathon.java.model.Project;
import com.tgrange.documathon.java.model.Tool;
import com.tgrange.documathon.java.tools.SerialPortReader;

public class MainControler implements ButtonsListener, MenuListener{

	public enum State {HOME, LOGIN, CREATE_PROJECT, ADD_STEP, LOADING}


	private DocumathonJFrame frame;
	private ICPControler center;
	private State state;
	private SerialPort serialPort;

	private Author actualAuthor;
	private Project actualProject;

	public MainControler(){
		try {
			String[] portNames = SerialPortList.getPortNames();
			if(portNames.length != 0){
				serialPort = new SerialPort(portNames[0]);
				serialPortConfiguration();
			}

			center = new CPControlerHome((ButtonsListener)this);
			state = State.HOME;

			frame = new DocumathonJFrame(center.getCenterPanel(), portNames);
			frame.setListener(this);
			frame.setVisible(true);
			frame.setExtendedState(frame.getExtendedState() | JFrame.MAXIMIZED_BOTH);
			
		} catch (Exception e) {
			e.printStackTrace();
		}
	}


	private void serialPortConfiguration() {
		try {
			serialPort.openPort();
			serialPort.setParams(9600, 8, 1, 0); //Baudrate 9600, 8N1
			serialPort.addEventListener(new SerialPortReader(serialPort, this));
		} catch (SerialPortException e) {
			e.printStackTrace();
		}//Open port

	}

	/* ******************************** */
	/*			MenuListener			*/
	/* ******************************** */
	@Override
	public void onPort(String portName) {
		System.out.println(portName);
		if(!portName.equals(serialPort.getPortName())){
			try {
				serialPort.closePort();
				serialPort = new SerialPort(portName);
				serialPortConfiguration();
			} catch (SerialPortException e) {
				e.printStackTrace();
			}
		}
	}


	@Override
	public void onClose() {
		try {
			serialPort.closePort();
		} catch (SerialPortException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}

	/* ******************************** */
	/*			ButtonsListener			*/
	/* ******************************** */
	@Override
	public void onLog(Author author) {
		state = State.LOGIN;
		if(author == null)
			author = new Author(6, "Faclab", null);
		actualAuthor = author;
		((CPControlerHome)center).logWith(author);
	}


	@Override
	public void onProject(Project project) {
		if(state == State.LOGIN){
			state = State.ADD_STEP;
			if(project == null)
				project = new Project(1,"Enceinte");
			actualProject = project;

			center = new CPControlerStep(this, actualProject.getId());
			frame.setCenter(center.getCenterPanel());
		}
	}
	
	@Override
	public void onShareOn(String substring) {
		if(state == State.ADD_STEP && ((CPControlerStep)center).getSteps().size() > 0){
			state = State.LOADING;
			((CPControlerStep)center).stopWebcam();
			actualProject.setSteps(((CPControlerStep)center).getSteps());
			center = new CPControlerShare(actualAuthor,actualProject);
			((CPControlerShare)center).setTwitter(substring.contains("twi"));
			frame.setCenter(center.getCenterPanel());
			((CPControlerShare)center).run();
		}
	}


	@Override
	public void onBtnCancel() {
		if(state == State.ADD_STEP)
			((CPControlerStep)center).onBtnCancel();
	}


	@Override
	public void onBtnDown() {
		if(state == State.ADD_STEP)
			((CPControlerStep)center).onBtnDown();
	}


	@Override
	public void onBtnDone() {
		if(state == State.ADD_STEP)
			((CPControlerStep)center).onBtnDone();
	}


	@Override
	public void onBtnTop() {
		if(state == State.ADD_STEP)
			((CPControlerStep)center).onBtnTop();
	}


	@Override
	public void onTool(Tool tool) {
		
	}


	@Override
	public void onMaterial(Material mat) {
		if(state == State.ADD_STEP){
			actualProject.addMaterial(mat);
			((CPControlerStep)center).addMaterial(mat);
		}
	}

	@Override
	public void onNotification() {
		// TODO Auto-generated method stub

	}


	@Override
	public void onServerInstruction() {
		// TODO Auto-generated method stub

	}
}
