// ECE 459 Lecture 2 live coding
// demonstrates the effect of branch mispredictions
// compile with -O2 -DEXPECTRESULT=0 and -O2 -DEXPECTRESULT=1 to witness different behaviours

#include <stdlib.h>
#include <stdio.h>

int main(int argc, char** argv) {
	int size = 1000000;
	int q = 0, r=0;
	int *p = calloc(size, sizeof(int));
	for (int i = 0; i < 500; i++) {
		for (int j = 0; j < size; j++) {
			if (__builtin_expect(p[j], EXPECTRESULT)) {
				q++;
			} else {
				r++;
			}
		}
	}
	printf("q = %d\nr = %d\n", q, r);
	return 0;
}


#if 0

plam@polya:~/foo$ gcc -O2 -std=c99 -o branch -DEXPECTRESULT=1 branch.c
plam@polya:~/foo$ perf stat -B ./branchq = 0
r = 500000000

 Performance counter stats for './branch':

        735.480214 task-clock                #    1.001 CPUs utilized          
                 5 context-switches          #    0.007 K/sec                  
                 2 cpu-migrations            #    0.003 K/sec                  
             1,114 page-faults               #    0.002 M/sec                  
     1,609,449,528 cycles                    #    2.188 GHz                     [83.12%]
       601,640,108 stalled-cycles-frontend   #   37.38% frontend cycles idle    [83.12%]
        90,504,383 stalled-cycles-backend    #    5.62% backend  cycles idle    [67.01%]
     4,001,411,998 instructions              #    2.49  insns per cycle        
                                             #    0.15  stalled cycles per insn [83.66%]
     1,497,736,484 branches                  # 2036.406 M/sec                   [83.66%]
             5,179 branch-misses             #    0.00% of all branches         [83.12%]

       0.735056840 seconds time elapsed

plam@polya:~/foo$ gcc -O2 -std=c99 -o branch -DEXPECTRESULT=0 branch.c
plam@polya:~/foo$ perf stat -B ./branchq = 0
r = 500000000

 Performance counter stats for './branch':

        494.391289 task-clock                #    1.000 CPUs utilized          
                 4 context-switches          #    0.008 K/sec                  
                 1 cpu-migrations            #    0.002 K/sec                  
             1,115 page-faults               #    0.002 M/sec                  
     1,101,742,242 cycles                    #    2.228 GHz                     [83.00%]
        98,172,558 stalled-cycles-frontend   #    8.91% frontend cycles idle    [83.00%]
        80,984,657 stalled-cycles-backend    #    7.35% backend  cycles idle    [67.24%]
     3,497,869,493 instructions              #    3.17  insns per cycle        
                                             #    0.03  stalled cycles per insn [83.81%]
       998,320,221 branches                  # 2019.292 M/sec                   [83.81%]
             4,496 branch-misses             #    0.00% of all branches         [82.99%]

       0.494422287 seconds time elapsed
        
#endif
