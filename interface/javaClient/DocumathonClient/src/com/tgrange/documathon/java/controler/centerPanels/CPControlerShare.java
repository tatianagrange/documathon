package com.tgrange.documathon.java.controler.centerPanels;

import java.text.SimpleDateFormat;
import java.util.Date;

import javax.swing.JPanel;

import com.temboo.Library.Bitly.Links.ShortenURL;
import com.temboo.Library.Bitly.Links.ShortenURL.ShortenURLInputSet;
import com.temboo.Library.Bitly.Links.ShortenURL.ShortenURLResultSet;
import com.temboo.Library.Twitter.Tweets.StatusesUpdate;
import com.temboo.Library.Twitter.Tweets.StatusesUpdate.StatusesUpdateInputSet;
import com.temboo.Library.Twitter.Tweets.StatusesUpdate.StatusesUpdateResultSet;
import com.tgrange.documathon.java.App;
import com.tgrange.documathon.java.controler.ICPControler;
import com.tgrange.documathon.java.gui.centerPanels.CPShare;
import com.tgrange.documathon.java.model.Author;
import com.tgrange.documathon.java.model.Project;
import com.tgrange.documathon.java.model.Step;
import com.tgrange.documathon.java.tools.API;

public class CPControlerShare implements ICPControler {

	private Author author;
	private Project project;
	private CPShare center;
	private boolean twitter;

	public CPControlerShare(Author actualAuthor, Project actualProject) {
		this.project = actualProject;
		this.author = actualAuthor;

		center = new CPShare(project.getSteps().size());
	}

	/**
	 * @param twitter the twitter to set
	 */
	public void setTwitter(boolean twitter) {
		this.twitter = twitter;
	}

	public void run() {
		Thread background = new Thread(new Runnable() {
			public void run() {
				for(Step step : project.getSteps()){
					API api = new API();
					try {
						step.setId(api.sendStep(step));
						api.contribute(author, step);
						stepAdded();
					} catch (Exception e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}
				}
				//Get PDF URL
				String shortURL = "";
				try {
					ShortenURL shortenURLChoreo = new ShortenURL(App.getInstance().getTembooSession());
					ShortenURLInputSet shortenURLInputs = shortenURLChoreo.newInputSet();
					shortenURLInputs.setCredential("DocumathonShort");
					shortenURLInputs.set_LongURL(API.PDF_URL.replace("X", "1"));
					ShortenURLResultSet shortenURLResults = shortenURLChoreo.execute(shortenURLInputs);
					shortURL = shortenURLResults.get_Response();
					System.out.println(shortURL);
				} catch (Exception e) {
					e.printStackTrace();
				}

				if(twitter){
					StatusesUpdate statusesUpdateChoreo;
					try {
						statusesUpdateChoreo = new StatusesUpdate(App.getInstance().getTembooSession());
						StatusesUpdateInputSet statusesUpdateInputs = statusesUpdateChoreo.newInputSet();
						statusesUpdateInputs.setCredential("Documathon");
						statusesUpdateInputs.set_StatusUpdate("Le projet " + project.getName() + " a été documenté par " + author.getName() + "! #documathon #faclab " + shortURL + " - " + new SimpleDateFormat("dd-MM-yyyy à HH:mm:ss").format(new Date()));
						StatusesUpdateResultSet statusesUpdateResults = statusesUpdateChoreo.execute(statusesUpdateInputs);
						System.out.println(statusesUpdateResults.get_Response());
					} catch (Exception e) {
						e.printStackTrace();
					}

				}
			}
		});

		background.start();
	}

	public void stepAdded(){
		center.increment();
	}

	@Override
	public JPanel getCenterPanel() {
		return center;
	}

}
