// ECE 459 Lecture 13 live coding
// may demonstrate surprising interleaving
// compile with -std=c++11 -pthread
#include <thread>
#include <atomic>
#include <stdio.h>

std::atomic<int> foo, bar;

void thread1() {
  foo.store(43);
  bar.store(41);
}

void thread2() {
  printf("%d\n", foo.load());
  printf("%d\n", bar.load());
  printf("%d\n", foo.load());
}

int main() {
  std::thread t1(thread1);
  std::thread t2(thread2);
  t1.join();
  t2.join();
}
