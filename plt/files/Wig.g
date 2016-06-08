/* Skeleton for Wig grammar. */
/* Your task is to:
    * add token definitions
    * stratify the expression grammar
       precedence, high to low
                   [!, -]
                   [+, -]
                   [\+, \-]
                   [<<]
                   [*, /, %]
                   [&&]
                   [||]
                   [==, !=, <, >, <=, >=]
                   [=]
      literals: INT_LITERAL, true, false, tuples, STRING_LITERAL.

    * fix the dangling-else ambiguity
    * create an AST using my skeletons
  By the way, you won't be supporting the full language in your project.
  I will describe later what you need to do.
*/

grammar Wig;

@header {
package ca.uwaterloo.ece251;
}
@lexer::header { package ca.uwaterloo.ece251; }

service : 'service' '{' html* schema* variable* function* session* '}'
;

html : 'const' 'html' ID '=' '<html>' htmlbody* '</html>' ';'
;
htmlbody : '<' ID attribute* '>'
         | '</' ID '>'
         | '<[' ID ']>'
         | WHATEVER
         | META
         | '<' 'input' inputattr* '>'
         | '<' 'select' inputattr* '>' htmlbody* '</' 'select' '>'
;
inputattr : 'name' '=' attr
          | 'type' '=' inputtype
          | attribute
;
inputtype : 'text' | 'radio'
;
attribute : attr | attr '=' attr
;
attr : ID | STRING_LITERAL
;

schema : 'schema' ID '{' field* '}'
;
field : simpletype ID ';'
;

variable : type identifiers ';'
;
identifiers : ID (',' ID)*
;

simpletype : 'int' | 'bool' | 'string' | 'void'
;
type : simpletype | 'tuple' ID
;

function : type ID '(' arguments ')' compoundstm
;
arguments : argument (',' argument)*
;
argument : type ID
;

session : 'session' ID '(' ')' compoundstm
;

stm : ';'
    | 'show' document receive ';'
    | 'exit' document ';'
    | 'return' ';'
    | 'return' exp ';'
    | 'if' '(' exp ')' stm
    | 'if' '(' exp ')' stm 'else' stm
    | 'while' '(' exp ')' stm
    | compoundstm
    | exp ';'
;
document : ID 
         | 'plug' ID '[' plugs ']'
;
receive : /* empty */
        | 'receive' '[' inputs? ']'
;
compoundstm : '{' variable* stm* '}'
;
plugs : plug (',' plug)*
;
plug : ID '=' exp
;
inputs returns [List<Input> li] 
@init { List<Input> l = new LinkedList<Input>(); } 
    : i0=input { l.add($i0.i); }  (',' in=input { l.add($in.i); } )*
        { $li = l; }
;
input : lvalue '=' ID
;

exp returns [Exp e] 
@init { Binop.BinopExp b = null; }
    : lvalue
    | lvalue '=' exp
    | exp '==' exp
    | exp '!=' exp
    | exp '<' exp
    | exp '>' exp
    | exp '<=' exp
    | exp '>=' exp
    | '!' exp
    | '-' exp
    | exp '+' exp
    | exp '-' exp
    | e0=exp {$e = $e0;} (('*' { b = BinopExp.Binop.TIMES; } | '/' { b = BinopExp.Binop.DIV; } |'%' { b = BinopExp.Binop.MOD; }) en=exp {$e = new BinopExp(b, $e.e, $e0.e); })*
    | exp '&&' exp
    | exp '||' exp
    | exp '<<' exp
    | exp '\+' identifiers
    | exp '\-' identifiers
    | '(' exp ')'
    | ID '(' exps ')'
    | INT_LITERAL
    | 'true'
    | 'false'
    | STRING_LITERAL
    | 'tuple' '{' fieldvalues? '}'
;
exps : exp (',' exp)*
;
lvalue : ID | ID '.' ID
;
fieldvalues : fieldvalue (',' fieldvalue)*
;
fieldvalue : ID '=' exp
;

/*TOKENS:*/

ID : usual identifiers
;
INT_LITERAL : usual integer constants
;
STRING_LITERAL : usual string constants
;
META : '<!--' ( options { greedy=false; } : . )* '-->'
;
WHATEVER : any string not containing < or >
;
