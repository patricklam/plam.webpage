// ECE 459 Lecture 2 live coding
// demonstrates the effect of cache misses
#include <stdio.h>
#include <stdlib.h>
 
#define SIZE (1 << 24)

int main(int argc, char** argv) {
	int* p = calloc(SIZE, sizeof(int));
	int q[1000];

	int i;
	int c = 0;
	int d = 0;

	srand(42);

	for (i = 0; i < 1000; i += 1) {
		q[i] = rand() % SIZE;
	}

	for (i = 0; i < SIZE; i += 1) {
		p[i] = i;
	}

	for (i = 0; i < 1000000; i += 1) {
		c = 0;
		for (int j = 0; j < 1000; j += 1) {
#ifdef FORCE_CACHE_MISSES
			c += p[q[j]];	
#else
			c += q[j];
#endif
		}
		d += c;
	}

	printf("d = %d\n", d);
}

#if 0
plam@polya:~/foo$ gcc -o cache -std=c99 cache.c
plam@polya:~/foo$ perf stat -B ./cache
d = -1981978752

 Performance counter stats for './cache':

       3353.079950 task-clock                #    1.000 CPUs utilized          
                15 context-switches          #    0.004 K/sec                  
                 3 cpu-migrations            #    0.001 K/sec                  
            16,526 page-faults               #    0.005 M/sec                  
     7,614,495,079 cycles                    #    2.271 GHz                     [83.29%]
     4,534,957,472 stalled-cycles-frontend   #   59.56% frontend cycles idle    [83.38%]
       254,340,307 stalled-cycles-backend    #    3.34% backend  cycles idle    [66.69%]
     7,233,696,788 instructions              #    0.95  insns per cycle        
                                             #    0.63  stalled cycles per insn [83.29%]
     1,027,975,393 branches                  #  306.576 M/sec                   [83.41%]
         1,052,675 branch-misses             #    0.10% of all branches         [83.29%]

       3.354739605 seconds time elapsed

plam@polya:~/foo$ gcc -o cache -std=c99 cache.c -DFORCE_CACHE_MISSES
plam@polya:~/foo$ perf stat -B ./cache
d = -1981978752

 Performance counter stats for './cache':

      11794.261066 task-clock                #    1.001 CPUs utilized          
                22 context-switches          #    0.002 K/sec                  
                 2 cpu-migrations            #    0.000 K/sec                  
            16,526 page-faults               #    0.001 M/sec                  
    26,915,150,025 cycles                    #    2.282 GHz                     [83.34%]
    22,837,794,985 stalled-cycles-frontend   #   84.85% frontend cycles idle    [83.34%]
    10,302,983,757 stalled-cycles-backend    #   38.28% backend  cycles idle    [66.67%]
    12,242,969,623 instructions              #    0.45  insns per cycle        
                                             #    1.87  stalled cycles per insn [83.34%]
     1,029,090,379 branches                  #   87.253 M/sec                   [83.34%]
         1,052,605 branch-misses             #    0.10% of all branches         [83.33%]

      11.786138581 seconds time elapsed

#endif
