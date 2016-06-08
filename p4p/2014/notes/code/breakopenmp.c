// ECE 459 live coding (Randy Mahler, Lecture 11)

// OpenMP requires that loops to be parallelized conform to a
// number of conditions, e.g. that they iterate over a range
// that stays fixed throughout the loop.

// In this demo, we attempted to explore what happened if we
// broke these conditions. Unfortunately, I forgot to add the
// #pragma omp parallel for directive, and for some reason the
// loop wouldn't auto-parallelize.

// In any case, the code is now "fixed" and you can observe
// different behaviour depending on whether you include the
// OpenMP directive or not.

#include <stdio.h>

void foo(int * pq)
{
    *pq *= -1;
}

void bar(int * pj)
{
    *pj *= -2;
}

int main() {
  int array[200];
  int i = 0, j = 1, q = 200;
  for (i = 0; i < 200; i++) array[i] = 0;

  #pragma omp parallel for
  for (i=0; i < q; i += j)
  {
      array[i] = 5;
      // can also call bar (&j) to mess up the outputs.
      // takeaway lesson: it is up to you to ensure conditions hold!
      foo(&q);
  }

  printf("%d\n", array[0]);
  printf("%d\n", array[19]);
}
