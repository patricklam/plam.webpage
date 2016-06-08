// ECE 459 live coding (Anurag, Lecture 22)

// Demonstrates a simple hello world example in OpenMPI.
// compile with mpicc, run with mpirun -np 8.

// source: http://www.dartmouth.edu/~rc/classes/intro_mpi/

#include <stdio.h>
#include <mpi.h>

int main (int argc, char * argv[]) {
    int rank, size;
    MPI_Init(&argc, &argv);
    MPI_Comm_rank(MPI_COMM_WORLD, &rank);
    MPI_Comm_size(MPI_COMM_WORLD, &size);
    printf("hello world %d %d\n", rank, size);
    MPI_Finalize();
    return 0;
}

