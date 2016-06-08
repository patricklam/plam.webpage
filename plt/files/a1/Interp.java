package ca.uwaterloo.ece251;

import javax.xml.parsers.FactoryConfigurationError;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.parsers.SAXParserFactory;
import javax.xml.parsers.SAXParser;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

import java.util.HashMap;
import java.util.Map;

/** Main interpreter class. Stores state. */
public class Interp {
    /** String to Value mapping for variables. */
    Map<String, Value> store = new HashMap<String, Value>();

    SAXParserFactory factory;
    SAXParser parser;

    public Interp() {
	try {
	    // http://www.ibm.com/developerworks/java/library/x-jaxp/
	    factory = SAXParserFactory.newInstance();
	    factory.setValidating(true);
	    factory.setNamespaceAware(false);
	    parser = factory.newSAXParser();
	} 
	catch (ParserConfigurationException e) {}
        catch (SAXException e) {}
    }

    /** Implement read statement. */
    public void read(String id, String ext) {
	// put code here
    }

    /** Implement write statement. */
    public void write(String id) {
	// put code here
    }

    /** Implement print statement. */
    public void print(String id) {
	// put code here
    }

    /** Implement assignment statement. */
    public void assign(String lhs, Expr rhs) {
	// put code here
    }

    /** Quick and dirty error notification. */
    public void error(String msg) {
	System.err.println(msg);
	System.exit(1);
    }
}
