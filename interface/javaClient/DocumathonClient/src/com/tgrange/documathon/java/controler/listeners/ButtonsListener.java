package com.tgrange.documathon.java.controler.listeners;

import com.tgrange.documathon.java.model.Author;
import com.tgrange.documathon.java.model.Project;

public interface ButtonsListener {
	public void onLog(Author author);
	public void onProject(Project project);
	public void onBtnCancel();
	public void onBtnDown();
	public void onBtnDone();
	public void onBtnTop();
	public void onTool(String substring);
	public void onMaterial(String substring);
	public void onShareOn(String substring);
	public void onNotification();
	public void onServerInstruction();
}
