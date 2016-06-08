#include <pthread.h>
#include <stdio.h>

void * run (void * v) {
    printf("In run\n");
}

int main() {
    pthread_t thread;
    pthread_create(&thread, NULL, &run, NULL);
    pthread_detach(thread);
    printf("In main\n");
    pthread_exit(NULL);
}

