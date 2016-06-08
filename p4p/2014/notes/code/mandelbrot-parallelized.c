// ECE 459 Live Coding demo (Patrick Lam)
// parallelized version of mandelbrot example

#include <stdlib.h>
#include <pthread.h>
#include <stdio.h>
#include <unistd.h>

#define WIDTH 1400
#define HEIGHT 800

// store thread-specific data;
// I could also have put output_array & iterations here,
// but it's acceptable to have that as a global too.
struct arg {
    int offset, stride;
};

#define NUM_THREADS 4

int iterations = 0;
int * output_array;

// refactored from main, write to output_array
void inMandelbrot(int h, int w, int iterations, int * output_array) {
    double x0, y0, x, xtemp, y;

    /* scale i to [-2.5, 1.0] */
    x0 = 3.5*((double)w)/((double) WIDTH - 1.0) - 2.5;
    /* scale j to [-1.0, 1.0] */
    y0 = 2.0*((double)h)/((double)HEIGHT - 1.0) - 1.0;

    x = 0.0, y = 0.0;

    int iteration = 0;
    while ((x*x + y*y < 4.0) && (iteration < iterations)) {
        xtemp = x*x - y*y + x0;
        y = 2*x*y + y0;
        x = xtemp;
        ++iteration;
    }
    if (iteration == iterations)
        output_array[h*WIDTH+w] = 1;
}

// each thread computes HEIGHT/NUM_THREADS lines
// start at offset, jump by stride
void * computePoints(void * a)
{
    struct arg * arg = (struct arg *) a;
    for (int h = arg->offset; h < HEIGHT; h += arg->stride) {
        for (int w = 0; w < WIDTH; ++w) {
            inMandelbrot(h, w, iterations, output_array);
        }
    }
}

int main(int argc, char *argv[])
{
    {
        int c;
        while ((c = getopt (argc, argv, "i:")) != -1) {
            switch (c) {
            case 'i':
                iterations = atoi(optarg);
                break;
            default:
                return EXIT_FAILURE;
            }
        }
    }
    if (iterations <= 0) {
        printf("%s: option missing or requires an argument > 0 -- 'i'\n",
               argv[0]);
        return EXIT_FAILURE;
    }

    FILE* pgmFile = fopen("output.pgm", "wb");
    if (pgmFile == NULL) {
        fprintf(stderr, "Failed to open pgm file\n");
        return EXIT_FAILURE;
    }
    fprintf(pgmFile, "P5\n%d %d\n255\n", WIDTH, HEIGHT);

    int iteration;

    struct arg * a = malloc(NUM_THREADS * sizeof (struct arg));
    pthread_t tids [NUM_THREADS];
    output_array = calloc(HEIGHT * WIDTH, sizeof(int));
    for (int i = 0; i < NUM_THREADS; i++) {
        a[i].offset = i;
        a[i].stride = 4;
        pthread_create(&tids[i], NULL, computePoints, &a[i]);
    }

    for (int i = 0; i < NUM_THREADS; i++) {
        pthread_join(tids[i], NULL);
    }

    for (int h = 0; h < HEIGHT; ++h) {
        for (int w = 0; w < WIDTH; ++w) {
            if (output_array[h*WIDTH+w]) {
                fputc(255, pgmFile);
            }
            else {
                fputc(0, pgmFile);
            }
        }
    }

    fclose(pgmFile);

    return EXIT_SUCCESS;
}
