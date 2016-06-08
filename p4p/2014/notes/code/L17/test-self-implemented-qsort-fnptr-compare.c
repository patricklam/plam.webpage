/* C, self-implemented qsort, uses a provided fn pointer to compare */
#include <stdio.h>
#include <time.h>
#include <stdlib.h>

typedef int T;

void mysort(T* data, int N, int (*comparator) (const void *, const void *))
{
    int i, j;
    T v, t;
    if (N <= 1) return;

    // Partition elements
    v = data[0];
    i = 0;
    j = N;

    for (;;)
    {
        while (comparator(&data[++i], &v) < 0 && i < N) {}
        while (comparator(&data[--j], &v) > 0) {}
        if (i >= j) break;
        t = data[i]; data[i] = data[j]; data[j] = t;
    }

    t = data[i-1]; data[i-1] = data[0]; data[0] = t;
    mysort(data, i-1, comparator);
    mysort(data + i, N-i, comparator);
}

int compare_T (const void *a, const void *b) 
{
    return (*(int *)a - *(int *)b);
}

void test(int N)
{
    T* data;
    time_t begin, end;
    double time_elapsed;
    int i;

    if (N < 1) { printf("N must be at least 1\n"); return; }

    data = (T*) malloc(N*sizeof(T));
    if (!data) return;
    for (i = 0; i < N; i++)
        data[i] = rand();

    begin = clock();
    mysort(data, N, compare_T);
    end = clock();
    time_elapsed = (double) (end-begin) / CLOCKS_PER_SEC;

    printf("%.2lf\n", time_elapsed);
    free(data);
}

int main(int argc, char * argv[])
{
    int i;
    if (argc != 2) exit(0);
    for (i = 0; i < 10; ++i)
        test(atoi(argv[1]));
    return 0;
}
