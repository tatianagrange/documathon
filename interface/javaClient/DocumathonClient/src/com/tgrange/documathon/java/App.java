package com.tgrange.documathon.java;

import com.temboo.core.TembooException;
import com.temboo.core.TembooSession;

public class App {
	public static boolean IS_DEV = true;
	private static TembooSession session = null;
	public static App instance = null;
	
	public static App getInstance(){
		if (instance == null)
			instance = new App();
		return instance;
	}
	
	private App(){
		try {
			session = new TembooSession("maktub", "myFirstApp", "68357e3c2b544674b4265cc1b5ae41fa");
		} catch (TembooException e) {
			e.printStackTrace();
		}
	}
	
	public TembooSession getTembooSession() throws Exception{
		if (session == null)
			throw new Exception("Temboo is null");
		return session;
	}
}
