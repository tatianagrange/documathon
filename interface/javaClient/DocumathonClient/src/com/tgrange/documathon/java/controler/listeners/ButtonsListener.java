package com.tgrange.documathon.java.controler.listeners;

import com.tgrange.documathon.java.model.Author;
import com.tgrange.documathon.java.model.Material;
import com.tgrange.documathon.java.model.Project;
import com.tgrange.documathon.java.model.Tool;

public interface ButtonsListener {
	public void onLog(Author author);
	public void onProject(Project project);
	public void onBtnCancel();
	public void onBtnDown();
	public void onBtnDone();
	public void onBtnTop();
	public void onTool(Tool tool);
	public void onMaterial(Material mat);
	public void onShareOn(String substring);
	public void onNotification();
	public void onServerInstruction();
}
