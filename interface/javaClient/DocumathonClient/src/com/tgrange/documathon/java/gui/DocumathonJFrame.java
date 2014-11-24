package com.tgrange.documathon.java.gui;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;

import javax.swing.BoxLayout;
import javax.swing.ButtonGroup;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JMenu;
import javax.swing.JMenuBar;
import javax.swing.JMenuItem;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JRadioButtonMenuItem;
import javax.swing.SwingConstants;
import javax.swing.border.EmptyBorder;

import com.tgrange.documathon.java.controler.listeners.MenuListener;

public class DocumathonJFrame extends JFrame {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private JPanel contentPane;
	private JPanel header;
	private JPanel footer;
	private JPanel center;
	private JPanel wraper;
	private MenuListener listener;

	/**
	 * @param listener the listener to set
	 */
	public void setListener(MenuListener listener) {
		this.listener = listener;
	}

	/**
	 * @param center the center to set
	 */
	public void setCenter(JPanel center) {
		wraper.remove(this.center);
		this.center = center;
		wraper.add(center, BorderLayout.CENTER);
		wraper.updateUI();
	}

	/**
	 * Create the frame.
	 * @param jPanel 
	 * @param portNames 
	 */
	public DocumathonJFrame(JPanel jPanel, String[] portNames) {
		setTitle("Documathon V0.3");
		addWindowListener (new WindowAdapter(){
			public void windowClosing (WindowEvent e){
				close();
			}
		});
		
		JMenuBar menuBar = new JMenuBar();
		setJMenuBar(menuBar);
		
		JMenu mnFile = new JMenu("File");
		menuBar.add(mnFile);
		
		JMenuItem mntmExit = new JMenuItem("Exit");
		mntmExit.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent arg0) {
				close();
			}
		});
		mnFile.add(mntmExit);
		
		JMenu mnEdit = new JMenu("Edit");
		menuBar.add(mnEdit);
		
		JMenu mnNewMenu = new JMenu("Serial Port");
		mnEdit.add(mnNewMenu);
		
		if(portNames.length == 0){
			mnNewMenu.setEnabled(false);
        }else{		
			ButtonGroup group = new ButtonGroup();
	        for(int i = 0; i < portNames.length; i++){
	        	JRadioButtonMenuItem jrbmi = new JRadioButtonMenuItem(portNames[i]);
	        	jrbmi.setActionCommand(portNames[i]);
	            jrbmi.addActionListener(new ActionListener() {
					@Override
					public void actionPerformed(ActionEvent e) {
						listener.onPort(e.getActionCommand());
					}
				});
	            if(i == 0)
	            	jrbmi.setSelected(true);
	            	
	            mnNewMenu.add(jrbmi);
	            group.add(jrbmi);
	        }
        }
		
		contentPane = new JPanel();
		contentPane.setBackground(new Color(0x34495e));
		contentPane.setBorder(new EmptyBorder(0, 50, 0, 50));
		setContentPane(contentPane);
		contentPane.setLayout(new BoxLayout(contentPane, BoxLayout.X_AXIS));
		
		wraper = new JPanel();
		wraper.setBackground(new Color(0x3498db));
		contentPane.add(wraper);
		wraper.setLayout(new BorderLayout(0, 0));
		
		header = new JPanel();
		header	.setBackground(new Color(0x3498db));
		wraper.add(header, BorderLayout.NORTH);
		header.setLayout(new BorderLayout(0, 0));
		
		JLabel title = new JLabel("Documathon");
		header.add(title, BorderLayout.NORTH);
		//title.setFont(FontsSingleton.getInstance().getTrack());
		title.setHorizontalAlignment(SwingConstants.CENTER);
		title.setForeground(new Color(255, 255, 255));
		title.setBorder(new EmptyBorder(50, 0, 0, 0));
		
		JLabel version = new JLabel("V 0.3");
		version.setHorizontalAlignment(SwingConstants.CENTER);
		//version.setFont(FontsSingleton.getInstance().getSmallTrack());
		version.setBorder(new EmptyBorder(10, 0, 0, 0));
		version.setForeground(new Color(255, 255, 255));
		header.add(version, BorderLayout.CENTER);
		
		footer = new JPanel();
		footer.setBackground(new Color(0x3498db));
		wraper.add(footer, BorderLayout.SOUTH);
		
		JLabel credits = new JLabel("Application réalisée pour le FacLab par Tatiana Grange");
		credits.setForeground(new Color(255, 255, 255));
		//credits.setFont(FontsSingleton.getInstance().getSintony());
		footer.add(credits);
		
		center = jPanel;
		center.setBackground(new Color(0x3498db));
		wraper.add(center, BorderLayout.CENTER);
		
		
		setSize(480,360);
		
		
	}
	
	/****************************
	 * 		Public Methods		*
	 ****************************/
	public void close(){
		int i = JOptionPane.showConfirmDialog(new JFrame(),
				"Do you realy want to quit?",
						"Quit",
						JOptionPane.YES_NO_OPTION);
		if (i == 0){
			System.exit(DISPOSE_ON_CLOSE);
		}
		else{
			this.setDefaultCloseOperation(DO_NOTHING_ON_CLOSE);
		}
	}

}
