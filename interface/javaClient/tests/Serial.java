import java.util.Arrays;

import jssc.SerialPort;
import jssc.SerialPortEvent;
import jssc.SerialPortEventListener;
import jssc.SerialPortException;
import jssc.SerialPortList;

public class Serial {

	static SerialPort serialPort;

	public static void main(String[] args) {
		serialPort = new SerialPort(SerialPortList.getPortNames()[0]); 
		try {
			serialPort.openPort();//Open port
			serialPort.setParams(9600, 8, 1, 0);//Set params
			serialPort.addEventListener(new SerialPortReader());//Add SerialPortEventListener
		}
		catch (SerialPortException ex) {
			System.out.println(ex);
		}
	}



	/*
	 * In this class must implement the method serialEvent, through it we learn about 
	 * events that happened to our port. But we will not report on all events but only 
	 * those that we put in the mask. In this case the arrival of the data and change the 
	 * status lines CTS and DSR
	 */
	static class SerialPortReader implements SerialPortEventListener {
		enum End {NONE, SLASH, SLASH_N}
		private End end = End.NONE;
		private String instruction = "";
		
		public void serialEvent(SerialPortEvent event) {
			if(event.isRXCHAR()){
				try {
					byte buffer[] = serialPort.readBytes(1);

					if(buffer[0] == 13)
						end = End.SLASH;
					else if(buffer[0] == 10 && end == End.SLASH){
						end = End.SLASH_N;
						System.out.println(instruction);
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
	}
}