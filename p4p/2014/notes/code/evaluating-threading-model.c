// compile with gcc -lpthread -o evaluating-threading-model -std=gnu99 evaluating-threading-model.c
// also run with perf stat -B
// and with taskset 0x01 to limit to one core

// thanks to Derek!

#include <stdlib.h>
#include <stdio.h>
#include <pthread.h>

#define STATE_SIZE 64

void* thename(void* arg)
{
  int c = 0;
  int return_value;

  struct random_data* qq = calloc(1,sizeof(struct random_data));

  char* buf = calloc(STATE_SIZE,sizeof(char));
  initstate_r(69L,buf,STATE_SIZE,qq);

  for(int i = 0 ; i < (1<<28); i++)
  {
    random_r(qq,&return_value);
    c+= return_value;
  }
  printf("Thread returns c = %d\n",c);
}

int main()
{
  int c = 0;
  int return_value;

  struct random_data* qq = calloc(1,sizeof(struct random_data));

  char* buf = calloc(STATE_SIZE,sizeof(char));
  initstate_r(69L,buf,STATE_SIZE,qq);

  pthread_t tid;
  pthread_create(&tid, NULL, &thename, NULL);

  for(int i = 0 ; i < (1<<28); i++)
  {
    random_r(qq,&return_value);
    c+= return_value;
  }
  printf("c is %d\n",c);

  pthread_join(tid,NULL);

  return 0;
}
