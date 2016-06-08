// ECE 459 live coding (Kyle, Lecture 18)
// Various compiler optimization examples.

// Compile with -fdump-tree-all -O2 to see optimizations in .169t.optimized.

int fold_constants()
{
    return 2048*2048;
}

int cse(int a, int b, int c, int d, int g)
{
    a = b * c + g;
    d = b * c * d;
    return a + d;
}

int constant_prop()
{
    int x = 14;
    int y = 7 - x / 2;

    return y * (28 / x + 2);
}

int copy_prop(int x, int y, int z)
{
    y = x;
    z = 3 + y;
    return z;
}

int dead_code_elimination(int x, int z)
{
    if (0) {
        z = 3 + x;
    }
}

// helper function for unroll_loops
int f()
{
    return 0;
}

// I can't get gcc to actually unroll loops,
// even with -funroll-loops.
int unroll_loops()
{
    int i, j;
    for (i = 0; i < 4; i++)
        j += f(i);
    return j;
}

// Actually, none of these loop opts actually work for me...
int loop_interchange(int c, double ** a, int N, int M)
{
    int i, j;
    for (i = 0; i < N; i++)
        for (j = 0; j < M; j++)
            a[j][i] = a[j][i] * c;
}

int loop_fusion(int * restrict a, int  * restrict b, int N)
{
    int i;

    for (i = 0; i < N; i++)
        a[i] = 4;

    for (i = 0; i < N; i++)
        b[i] = 7;
}
