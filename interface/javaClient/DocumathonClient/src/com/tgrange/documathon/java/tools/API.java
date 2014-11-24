package com.tgrange.documathon.java.tools;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;

import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;

import com.tgrange.documathon.java.model.Author;
import com.tgrange.documathon.java.model.Step;

public class API {

	public static String URL = "http://api.documathon.tgrange.com";
	public static String ADD_STEP = URL + "/projects/X/add/step";
	public static String ADD_AUTHOR_FOR_STEP = URL + "/authors/X/contribute/Y";

	public static String IMAGE_URL = "http://images.documathon.tgrange.com";
	public static String PDF_URL = IMAGE_URL + "/X/project.pdf";



	public int sendStep(Step step) throws Exception{
		URL obj = new URL(ADD_STEP.replace("X",step.getProjectId()+""));
		HttpURLConnection con = (HttpURLConnection) obj.openConnection();
		con.setRequestMethod("POST");
		String urlParameters = "text=" + step.getText() + "&base64=" + URLEncoder.encode(ImageUtils.encodeImage(step.getPath()), "UTF-8");
		con.setDoOutput(true);
		DataOutputStream wr = new DataOutputStream(con.getOutputStream());
		wr.writeBytes(urlParameters);
		wr.flush();
		wr.close();
		JSONObject jsonContent = getResponse(con);
		System.out.println(jsonContent.toString());
		return Integer.parseInt(((String)jsonContent.get("datas")));
	}

	public void contribute(Author author, Step step) throws Exception{
		URL obj = new URL(ADD_AUTHOR_FOR_STEP.replace("X", author.getId() + "").replace("Y", step.getId() + ""));
		HttpURLConnection con = (HttpURLConnection) obj.openConnection();
		con.setRequestMethod("GET");
		JSONObject jsonContent = getResponse(con);
		System.out.println(jsonContent.toString());
	}

	public JSONObject getResponse(HttpURLConnection con) throws IOException, ParseException {
		BufferedReader in = new BufferedReader(
				new InputStreamReader(con.getInputStream()));
		String inputLine;
		StringBuffer response = new StringBuffer();

		while ((inputLine = in.readLine()) != null) {
			response.append(inputLine);
		}
		in.close();

		String json = response.toString();
		JSONParser parser = new JSONParser();
		JSONObject jsonContent = (JSONObject)parser.parse(json);
		return jsonContent;
	}

}
