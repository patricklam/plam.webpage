/* DRAFT sample solution by Patrick Lam */
/* You may use this file verbatim in your solutions, or
 * you may modify it as desired. I will post a fixed version
 * shortly. Use that version in your submissions. */

package ca.uwaterloo.ece251;

/** Base interface of the expression AST, defining the <code>eval</code>
 * method.
 *
 * Also defines a number of constants (enums) and
 * inner classes for various kinds of expressions. */
public interface Expr {
    /** Converts this expression to a <code>Value</code> by evaluating it
     * using the state from <code>interp</code>. */
    public Value eval(Interp interp);

    /** Kinds of comparators for "sort". */
    enum Comparator { /** Increasing lexicographical or integer order. */ ASCENDING, /** Decreasing lexicographical or integer order. */ DESCENDING };
    /** Operators for "reduce". */
    enum Accumulator { 
	/** Adds integers in the tree or list; for mixed or all-string values, convert all to strings and concatenate. */ SUM, 
	/** Averages integers in the compound value. */ AVG, 
	/** Counts the number of elements. */ COUNT, 
	/** Concatenates the strings in the compound value. */ CONCAT };
    /** Kinds of traversals for "preorder", "postorder" and "levelorder". */
    enum Order { /** Pre-order traversal. */ PRE, /** Post-order traversal. */ POST, /** Level-order traversal, aka breadth-first search. */ LEVEL };
    /** Comparison operators for "filter". */
    enum FilterKind { GT, GE, LT, LE, EQ };
    /** Arithmetic/string operators for "map". */
    enum TransformerKind { /** Add integers or concatenate strings. */ PLUS, INUS, TIMES, DIVIDE; };

    /** Encapsulates a filter operation and its constant argument. */
    class Filter {
	final FilterKind fk;
	final Value v;
	public Filter(FilterKind fk, Value v) {
	    this.fk = fk; this.v = v;
	}
    }

    /** Encapsulates a transformer operation and its constant argument. */
    class Transformer {
	final TransformerKind tk; 
	final Value v;
	public Transformer(TransformerKind tk, Value v) {
	    this.tk = tk; this.v = v;
	}
    }
}
