// ECE 459 live coding (Anurag, Lecture 22)

// Demonstrates the use of OpenMPI's MPI_Send, MPI_Receive calls.
// compile with mpicc -std=c99, run with mpirun -np 8.

// source: http://en.wikipedia.org/wiki/Message_Passing_Interface

#include <stdio.h>
#include <mpi.h>

#define BUF_SIZE 80
#define TAG 0

int main (int argc, char * argv[]) {
    int rank, size;
    MPI_Init(&argc, &argv);
    MPI_Comm_rank(MPI_COMM_WORLD, &rank);
    MPI_Comm_size(MPI_COMM_WORLD, &size);
    
    char buf[BUF_SIZE]; 
    char buf2[BUF_SIZE]; 
    MPI_Status status;

    if(rank == 0) {
        for(int i = 1; i < size; i++) {
            sprintf(buf, "hello %d", i);
            MPI_Send(buf, BUF_SIZE, MPI_CHAR, i, TAG, MPI_COMM_WORLD);
        }
        for(int i = 1; i < size; i++) {
            MPI_Recv(buf, BUF_SIZE, MPI_CHAR, i, TAG, MPI_COMM_WORLD, &status);
            printf("received from slave: [%s]\n", buf);
        }
    } else {
        MPI_Recv(buf, BUF_SIZE, MPI_CHAR, 0, TAG, MPI_COMM_WORLD, &status);
        sprintf(buf2, "received from master: \"%s\". My id is %d.", buf, rank);
        MPI_Send(buf2, BUF_SIZE, MPI_CHAR, 0, TAG, MPI_COMM_WORLD);
    }

    MPI_Finalize();
    return 0;
}
