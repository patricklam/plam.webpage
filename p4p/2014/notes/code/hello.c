// ECE 459 live coding (Lecture 12)
// OpenMP Hello

// Illustrates that #pragma omp parallel starts multiple threads (as
// controlled by OMP_NUM_THREADS).

// Expected output: as many "Hello!"s as there are running threads.
// But, if you put #pragma omp master or single in the parallel
// section, you would only see one "Hello!".

#include <stdlib.h>

int main()
{
#pragma omp parallel
    printf("Hello!\n");
}
