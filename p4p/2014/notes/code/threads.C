// ECE 459 Lecture 13 live coding
// may demonstrate surprising interleaving
// compile with -std=c++11 -pthread
#include <thread>
#include <stdio.h>

int foo, bar;

void thread1() {
  foo = 43;
  bar = 41;
}

void thread2() {
  printf("%d\n", foo);
  printf("%d\n", bar);
  printf("%d\n", foo);
}

int main() {
  std::thread t1(thread1);
  std::thread t2(thread2);
  t1.join();
  t2.join();
}
