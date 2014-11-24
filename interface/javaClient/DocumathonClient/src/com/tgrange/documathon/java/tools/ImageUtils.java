package com.tgrange.documathon.java.tools;

import java.awt.image.BufferedImage;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.IOException;

import javax.imageio.ImageIO;

import Decoder.BASE64Encoder;

public class ImageUtils {
	
	/**
	 * Encodes the byte array into base64 string
	 * @param imageByteArray - byte array
	 * @return String a {@link java.lang.String}
	 * @throws IOException 
	 */
	public static String encodeImage(String name) throws IOException{	
		BufferedImage img = ImageIO.read(new File(name));             
		String imageString = null;
        ByteArrayOutputStream bos = new ByteArrayOutputStream();
        try {
            ImageIO.write(img, "JPEG", bos);
            byte[] imageBytes = bos.toByteArray();
            BASE64Encoder encoder = new BASE64Encoder();
            imageString = encoder.encode(imageBytes);
            bos.close();
            return imageString;
        } catch (IOException e) {
            e.printStackTrace();
        }		
        return null;
	}
}