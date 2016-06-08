// ECE459 Lecture 1 live coding
// illustrates a race condition using pthreads

#include <stdio.h>
#include <stdlib.h>
#include <pthread.h>

int i;

void* patrick(void* arg) {
    i = (int) arg;
}

int main(int argv, char** argc) {

    // how do I use pthread?
    pthread_t tid;
    pthread_create(&tid, NULL, &patrick, (void *) 42);

    i = 1;

    sleep(1);

    printf("%d\n", i);

    return 0;

}

#if 0
plam@polya:~/foo$ gcc -o race -lpthread race.c
race.c: In function ‘patrick’:
race.c:8:10: warning: cast from pointer to integer of different size [-Wpointer-to-int-cast]
      i = (int) arg;
          ^
plam@polya:~/foo$ ./race
42
#endif
