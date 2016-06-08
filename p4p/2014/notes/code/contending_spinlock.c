// ECE 459 live coding example:
// contended spin; run time to observe its behaviour
//  [contrast with contended_mutex.c]
// Typed by Patrick Lam.
#include <stdio.h>
#include <stdlib.h>
#include <pthread.h>

#define NUM_THREADS 8
#define BIG 104857600
static pthread_spinlock_t spin;

void *run(void *args) {
	int i;
        unsigned int seed;
        pthread_spin_lock(&spin);
	for(i = 0; i < BIG; i++)
	{
	    int r = rand_r(&seed);
	}
	pthread_spin_unlock(&spin);
}

int main()
{
	pthread_t t[NUM_THREADS];
        pthread_spin_init(&spin, 0);
	int i;

	for(i = 0; i < NUM_THREADS; i++)
		pthread_create(&t[i], NULL, &run, NULL);
	for(i = 0; i < NUM_THREADS; i++)
		pthread_join(t[i], NULL);

	pthread_spin_destroy(&spin);
	return 0;
		

}

