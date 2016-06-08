// ECE 459 Lecture 5 live coding
// note the lack of effect of O_NONBLOCK on file reads

#include <stdlib.h>
#include <stdio.h>
#include <fcntl.h>

int main() {
    int fd;
    char * bytes = malloc(104785760);
    if (!bytes) { printf("couldn't alloc\n"); exit(1); }

    // try with and without O_NONBLOCK---no difference!
    fd = open("/dev/urandom", O_RDONLY | O_NONBLOCK);
    read(fd, bytes, 104785760);
    close(fd);
}
