// ECE 459 live coding (David, Lecture 12)

// Demonstrates the use of OpenMP parallel sections.

// Parallel sections are applicable when the paralellization structure
// is known ahead of time, as in this example.

// In fact, this example runs more slowly when parallelized.
// I presume that this is because the two threads are contending for
// the memory allocator, which has a global lock.

#include <stdlib.h>
#include <stdio.h>

typedef struct s { struct s* next; } S;

void setuplist (S* list) {
    for (int i = 0; i < 2000000; i++) {
        list->next = (S*) malloc (sizeof(S));
        list = list->next;
    }
}

int main(int argc, char *argv[]) {
    S var1, var2;
    #pragma omp parallel sections
    {
        #pragma omp section
        {
            setuplist(&var1);
        }
        #pragma omp section
        {
            setuplist(&var2);
        }
    }
    return 0;
}
