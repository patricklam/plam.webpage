// revised 07 Oct 12:55
package ca.uwaterloo.ece251;

import java.io.*;
import java.util.regex.*;
import java.util.*;

// JAXP
import javax.xml.parsers.FactoryConfigurationError;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.parsers.SAXParserFactory;
import javax.xml.parsers.SAXParser;

// SAX
import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

/** Implements tree-typed values. */
public class TreeValue implements Value {
  /** Children of this node. */
  List<TreeValue> children;
  /** Tag for this node. */
  String tag;
  /** Data for this node (processed). */
  AtomValue data;
  /** Data for this node (raw String). */
  String chars;

  AtomValue.Type treeType;

  /** Create a TreeValue data item from file fn. */
  public TreeValue(File f, SAXParser parser) 
  {
    children = new ArrayList<TreeValue>();
    treeType = AtomValue.Type.INT;
    try {
      final Stack<TreeValue> pendingParents = new java.util.Stack<TreeValue>();

      parser.parse(f, new DefaultHandler() {
          public void startDocument() {
            TreeValue syntheticRoot = new TreeValue("synthetic-root", new LinkedList<TreeValue>(), new AtomValue("0"), new String());
            children.add(syntheticRoot);
            pendingParents.push(syntheticRoot);
          }

          public void endDocument() {
            TreeValue realRoot = children.get(0).children.get(0);
            TreeValue.this.tag = realRoot.tag;
            TreeValue.this.children = realRoot.children;
            TreeValue.this.data = realRoot.data;
            TreeValue.this.chars = realRoot.chars;
          }

          /** Record the fact that we're entering a new child node. Throw away attributes. */
          public void startElement(String url, String localName, String qName, Attributes attributes) {
            TreeValue t = new TreeValue(qName, new LinkedList<TreeValue>(), new AtomValue("0"), new String());
            pendingParents.peek().children.add(t);
            pendingParents.push(t);
          }

          /** Find the parent that we're closing. */
          public void endElement(String url, String localName, String qName) {
            TreeValue ending = pendingParents.pop();
            ending.chars = ending.chars.trim();
            ending.data = new AtomValue(ending.chars);

            if(ending.data.t == AtomValue.Type.STRING) {
              treeType = AtomValue.Type.STRING;
            }

            while (!ending.tag.equals(qName)) {
              ending = pendingParents.pop();
            }
          }

          public void characters(char[] ch, int start, int length) {
            pendingParents.peek().chars = 
              pendingParents.peek().chars + new String(ch, start, length);
          }
        });
    } 
    catch (IOException e) {}
    catch (SAXException e) {}
    if (treeType == AtomValue.Type.STRING) {
      fixType(treeType);
    }
  }

  /** Private constructor used for building tree. */
  private TreeValue(String tag, List<TreeValue> children, AtomValue data, String chars) {
    this.tag = tag;
    this.children = children;
    this.data = data;
    this.chars = chars;
  }

  private void fixType(AtomValue.Type t)
  {
    data.t = t;
    for (TreeValue v : children) {
      v.fixType(t);
    }
  }

  public void write(String fn) 
  {
    try {
      new File(OUTPUT_DIR).mkdir();
      Writer w = new FileWriter(OUTPUT_DIR + fn+".xml");
      w.write(toString());
      w.close();
    } catch (IOException e) {
    }
  }

  public void print() 
  {
    System.out.println(toString());
  }

  public String toString()
  {
    StringBuffer sb = new StringBuffer("<"+tag+">" + data);
    for (TreeValue t : children) {
      sb.append(t.toString());
    }
    sb.append("</"+tag+">\n");
    return sb.toString();
  }

  public Value sort(Expr.Comparator c) 
  {
    switch (c) {
    case ASCENDING:
      Collections.sort(children, new Comparator<Value>() { 
          public int compare(Value v1, Value v2) {
            return v1.compare(v2);
          }
        });
      for (TreeValue t : children) {
        t.sort(c);
      }
      break;
    case DESCENDING:
      Collections.sort(children, new Comparator<Value>() { 
          public int compare(Value v1, Value v2) {
            return v2.compare(v1);
          }
        });
      for (TreeValue t : children) {
        t.sort(c);
      }
      break;
    }
    return this; 
  }

  public Value map(Expr.Transformer t) 
  {
    data.map(t);
    for (Value l : children) {
      l.map(t);
    }
    return this; 
  }

  public Value filter(Expr.Filter f)
  {
    List<TreeValue> newChildren = new LinkedList<TreeValue>();
    if(data.satisfies(f)) {
      for (Value l : children) {
        if (l instanceof TreeValue) {
          if (((AtomValue)(((TreeValue)l).data)).satisfies(f)) {
            newChildren.add((TreeValue)l);
            ((TreeValue)l).filter(f);
          }
        }
      }
    }
    else {
      tag = new String("empty");
      data = new AtomValue("0"); 
    }
    children = newChildren;
    return this;
  }

  public Value reduce(Expr.Accumulator a)
  {
    AtomValue rv = null;
    int s = 0;
    switch (a) {
    case SUM:
      s = data.intVal;
      for (TreeValue av : children) {
        s += ((AtomValue)av.reduce(a)).intVal;
      }
      rv = new AtomValue(Integer.toString(s));
      break;
    case AVG:
      /* Evaluate SUM / COUNT. */
      int sum = ((AtomValue)reduce(Expr.Accumulator.SUM)).intVal;
      int count = ((AtomValue)reduce(Expr.Accumulator.COUNT)).intVal;
      rv = new AtomValue(Integer.toString(sum/count));
      break;
    case COUNT:
      s = 1;
      for (TreeValue av : children) {
        s += ((AtomValue)av.reduce(a)).intVal;
      }
      rv = new AtomValue(Integer.toString(s));
      break;
    case CONCAT:
      StringBuffer sb = new StringBuffer();
      sb.append(data.stringVal);
      for (TreeValue av : (List<TreeValue>)children) {
        
        sb.append(((AtomValue)av.reduce(a)).stringVal);
      }
      rv = new AtomValue(sb.toString());
      break;
    }
    return rv;
  }

  public Value traverse(Expr.Order o)
  {
    ListValue lv = new ListValue();

    switch (o) {
    case PRE:
    case POST:
      if (o == Expr.Order.PRE)
      lv.contents.add(data);

      for (TreeValue c : children) {
        ListValue cc = (ListValue)c.traverse(o);
        lv.contents.addAll(cc.contents);
      }

      if (o == Expr.Order.POST)
      lv.contents.add(data);
      return lv;
    case LEVEL:
      Queue<TreeValue> unvisitedNodes = new LinkedList<TreeValue>();
      unvisitedNodes.add(this);
      while (!unvisitedNodes.isEmpty()) {
        TreeValue v = unvisitedNodes.remove();
        lv.contents.add(v.data);
        unvisitedNodes.addAll(v.children);
      }
      return lv;
    }
    return null;
  }

  public Value truncate(int v)
  {
    List<TreeValue> newChildren = new LinkedList<TreeValue>();

    if (v > 1) {
      for (TreeValue c : children) {
        newChildren.add((TreeValue)c.truncate(v-1));
      }
    }

    children = newChildren;
    return this;

    // if (v <= 1)
    //   return data;

    // List<TreeValue> newChildren = new LinkedList<TreeValue>();
    // for (TreeValue c : children) {
    //   newChildren.add((TreeValue)c.truncate(v-1));
    // }

    // children = newChildren;

    // return this;
  }

  public int compare(Value v)
  {
    if (v instanceof TreeValue) {
      TreeValue tv = (TreeValue) v;
      return data.compare(tv.data);
    }
    return 0;
  }

  public Object clone() 
  {
    List<TreeValue> newChildren = new LinkedList<TreeValue>();
    for (Value c : children) {
      newChildren.add((TreeValue)c.clone());
    }
    return new TreeValue(tag, newChildren, (AtomValue)data.clone(), chars);
  }
}
