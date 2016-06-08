import org.junit.*;
import static org.junit.Assert.*;

import java.util.List;
import org.objectweb.asm.*;
import org.objectweb.asm.tree.*;
import org.objectweb.asm.tree.analysis.*;

public class CFGTest {
    private CFG cfg;
    private ClassNode m;
    private MethodNode m_m;

    @Before
    public void createCFG() {
	cfg = new CFG();

	ClassReader cr;
	try {
	    cr = new ClassReader("M");
	} catch (java.io.IOException e) { 
	    throw new RuntimeException("Can't open class M"); 
	}
	final ClassNode cn = new ClassNode();
	m = cn;
	cr.accept(cn, ClassReader.SKIP_DEBUG);

	for (final MethodNode m : (List<MethodNode>)cn.methods) {
	    if (m.name.equals("m")) m_m = m;

	    for (int i = 0; i < m.instructions.size(); i++)
		cfg.addNode(i, m, cn);

	    Analyzer a = new Analyzer(new BasicInterpreter()) {
		    protected void newControlFlowEdge(int insn, int succ) {
			cfg.addEdge(insn, m, cn,
				    succ, m, cn);
		    }
		};
	    try {
		a.analyze(cn.name, m);
	    } catch (AnalyzerException e) {}
	}
    }

    @Test
    public void addNode() {
	cfg.addNode(1000, m_m, m);
	CFG.Node n = new CFG.Node(1000, m_m, m);
	assertTrue(cfg.nodes.contains(n));
    }

    @Test
    public void addEdge() {
	cfg.addEdge(1000, m_m, m,
		    1001, m_m, m);
	CFG.Node n = new CFG.Node(1000, m_m, m);
	CFG.Node nn = new CFG.Node(1001, m_m, m);

	assertTrue(cfg.edges.get(n).contains(nn));
    }

    @Test
    public void addEdge_oneNewNode() {
	cfg.addEdge(1000, m_m, m,
		    1001, m_m, m);
	CFG.Node n = new CFG.Node(1000, m_m, m);
	CFG.Node nn = new CFG.Node(1001, m_m, m);

	assertTrue(cfg.edges.containsKey(nn));
    }

    @Test
    public void addNode_duplicate() {
	cfg.addEdge(1000, m_m, m, 
		    1001, m_m, m);
	cfg.addNode(1000, m_m, m);

	CFG.Node n = new CFG.Node(1000, m_m, m);
	assertFalse(cfg.edges.get(n).size() == 0);
    }

    @Test
    public void reachable_true() {
	assertTrue(cfg.isReachable(0, m_m, m, 
				   3, m_m, m));
    }

    @Test
    public void reachable_false() {
	assertFalse(cfg.isReachable(59, m_m, m, 
				    0, m_m, m));
    }

    @Test
    public void reachable_missingSrc() {
	assertFalse(cfg.isReachable(-1, m_m, m,
				0, m_m, m));
    }
}

class M {
    public void m(String arg, int i) {
	int q = 1;
	A o = null;
	
	if (i == 0)
	    q = 4;
	q++;
	switch (arg.length()) {
	case 0: q /= 2; break;
	case 1: o = new A(); q = 10; break;
	case 2: o = new B(); q = 5; break;
	default: o = new B(); break; 
	}
	if (arg.length() > 0) {
	    o.m();
	} else {
	    System.out.println("zero");
	}
    }
}

class A {
    public void m() { 
	System.out.println("a");
    }
}

class B extends A {
    public void m() { 
	System.out.println("b");
    }
}
