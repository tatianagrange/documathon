package com.tgrange.documathon.java.controler;

import java.sql.Timestamp;

import jssc.SerialPort;
import jssc.SerialPortEvent;
import jssc.SerialPortEventListener;
import jssc.SerialPortException;

import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;

import com.tgrange.documathon.java.controler.listeners.ButtonsListener;
import com.tgrange.documathon.java.model.Author;
import com.tgrange.documathon.java.model.Project;

public class SerialPortReader implements SerialPortEventListener {

	enum End {NONE, SLASH, SLASH_N}
	private End end = End.NONE;
	private String instruction = "";
	private SerialPort serialPort;
	private ButtonsListener listener;
	
	public SerialPortReader(SerialPort serialPort, ButtonsListener listener) {
		super();
		this.serialPort = serialPort;
		this.listener = listener;
	}

	@Override
	public void serialEvent(SerialPortEvent event) {
		if(event.isRXCHAR()){
			try {
				byte buffer[] = serialPort.readBytes(1);
				
				// Check if it is the end of the instruction.
				// The instruction's end is mark by the bytes 13,10 
				if(buffer[0] == 13)
					end = End.SLASH;
				else if(buffer[0] == 10 && end == End.SLASH){
					end = End.SLASH_N;
					parseInstruction(instruction);
					instruction = "";
					
				}else{
					end = End.NONE;
					instruction += (char)buffer[0];
				}
			}
			catch (SerialPortException ex) {
				System.out.println(ex);
			}
		}
	}

	private void parseInstruction(String s) {
		String mainInstruction = s.substring(0,3);
		JSONParser parser=new JSONParser();
		if(mainInstruction.equals("log")){
			Author author = null;
			try {
				JSONObject jsonAuthor = (JSONObject)parser.parse(s.substring(3));
				author = new Author(
						((Long)jsonAuthor.get("id")).intValue(), 
						(String)jsonAuthor.get("name"), 
						(Timestamp)jsonAuthor.get("birth"));
			} catch (ParseException e) {
				e.printStackTrace();
			}
			listener.onLog(author);
		}else if(mainInstruction.equals("prj")){
			Project project = null;
			try {
				JSONObject jsonProject = (JSONObject)parser.parse(s.substring(3));
				project = new Project(
						((Long)jsonProject.get("id")).intValue(),
						(String)jsonProject.get("name"));
			} catch (ParseException e) {
				e.printStackTrace();
			}
			listener.onProject(project);
		}else if(mainInstruction.equals("too")){
			listener.onTool(s.substring(3));
		}else if(mainInstruction.equals("mat")){
			listener.onMaterial(s.substring(3));
		}else if(mainInstruction.equals("btn")){
			String secondInstruction = s.substring(3,6);
			if(secondInstruction.equals("can")){
				listener.onBtnCancel();
			}else if(secondInstruction.equals("top")){
				listener.onBtnTop();
			}else if(secondInstruction.equals("bot")){
				listener.onBtnDown();
			}else if(secondInstruction.equals("val")){
				listener.onBtnDone();
			}
		}else if(mainInstruction.equals("shr")){
			listener.onShareOn(s.substring(3));
		}else if(mainInstruction.equals("not")){
			listener.onNotification();
		}else if(mainInstruction.equals("srv")){
			listener.onServerInstruction();
		}
	}
}
