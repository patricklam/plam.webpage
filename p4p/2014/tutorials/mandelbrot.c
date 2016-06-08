#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>

#define WIDTH 1400
#define HEIGHT 800

int main(int argc, char *argv[])
{
    int i_max = 0;
    {
        int c;
        while ((c = getopt (argc, argv, "i:")) != -1) {
            switch (c) {
            case 'i':
                i_max = atoi(optarg);
                break;
            default:
                return EXIT_FAILURE;
            }
        }
    }
    if (i_max <= 0) {
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

    int i;
    double x0, y0, x, xtemp, y;
    for (int h = 0; h < HEIGHT; ++h) {
        for (int w = 0; w < WIDTH; ++w) {
            i = 0; x = 0.0, y = 0.0;
            x0 = 3.5*((double) w)/((double) WIDTH - 1.0) - 2.5;
            y0 = 2.0*((double) h)/((double) HEIGHT - 1.0) - 1.0;
            while ((x*x + y*y < 4.0) && (i < i_max)) {
                xtemp = x*x - y*y + x0;
                y = 2*x*y + y0;
                x = xtemp;
                ++i;
            }
            if (i == i_max) fputc(255, pgmFile);
            else fputc(0, pgmFile);
        }
    }

    fclose(pgmFile);

    return EXIT_SUCCESS;
}
