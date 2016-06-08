// ECE459 Lecture 9 live coding
// illustrates use of SIMD instructions
// Compile to assembler and look at the resulting .S files:
// gcc -m32 -march=i386 -S simd.c: no SSE, stack-based x87 code
// gcc -m32 -mfpmath=sse -march=prescott -S simd.c: with SSE, packed instructions

#include <stdio.h>

void func(double * restrict arr1, double * restrict arr2, int size) {
    for (int i=0; i<size; i++) {
        arr1[i] += arr2[i];
    }
}

int main() {
    double *arr1 = calloc(100, sizeof(double));
    double *arr2 = calloc(100, sizeof(double));

    func(arr1, arr2, 100);
    return 0;
}

