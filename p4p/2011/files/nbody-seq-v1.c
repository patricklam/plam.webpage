/* nbody simulation, version 0 */
/* Modified by Patrick Lam; original source: GPU Gems, Chapter 31 */

#include <CL/cl.h>
#include <stdlib.h>
#include <stdio.h>
#include <math.h>

#define EPS 1e-10

/// runtime on my computer: 1m
#define POINTS 500 * 64
#define SPACE 100.0f;

cl_float4 bodyBodyInteraction(cl_float4 bi, cl_float4 bj, cl_float4 ai) {
    cl_float4 r;
    
    r.x = bj.x - bi.x;
    r.y = bj.y - bi.y;
    r.z = bj.z - bi.z;
    r.w = 1.0f;

    float distSqr = r.x * r.x + r.y * r.y + r.z * r.z + EPS;

    float distSixth = distSqr * distSqr * distSqr;
    float invDistCube = 1.0f/sqrtf(distSixth);

    float s = bj.w * invDistCube;

    ai.x += r.x * s;
    ai.y += r.y * s;
    ai.z += r.z * s;

    return ai;
}

void calculateForces(int points, int global_id, cl_float4 * globalP, cl_float4 * globalA) {
    cl_float4 myPosition = globalP[global_id];
    int i;

    cl_float4 acc = {0.0f, 0.0f, 0.0f, 1.0f};
    
    for (i = 0; i < points; i ++) {
	acc = bodyBodyInteraction(myPosition, globalP[i], acc);
    }
    globalA[global_id] = acc;
}

cl_float4 * initializePositions() {
    cl_float4 * pts = malloc(sizeof(cl_float4)*POINTS);
    int i;

    srand(42L); // for deterministic results

    for (i = 0; i < POINTS; i++) {
	// quick and dirty generation of points
	// not random at all, but I don't care.
	pts[i].x = ((float)rand())/RAND_MAX * SPACE;
	pts[i].y = ((float)rand())/RAND_MAX * SPACE;
	pts[i].z = ((float)rand())/RAND_MAX * SPACE;
	pts[i].w = ((float)rand())/RAND_MAX; // size in [0, 1].
    }
    return pts;
}

cl_float4 * initializeAccelerations() {
    cl_float4 * pts = malloc(sizeof(cl_float4)*POINTS);
    int i;

    for (i = 0; i < POINTS; i++) {
	pts[i].x = pts[i].y = pts[i].z = pts[i].w = 0;
    }
    return pts;
}

int main(int argc, char ** argv)
{
    cl_float4 * x = initializePositions();
    cl_float4 * a = initializeAccelerations();

    int i;
    for (i = 0; i < POINTS; i++)
	calculateForces(POINTS, i, x, a);

    for (i = 0; i < POINTS; i++)
	printf("(%2.2f,%2.2f,%2.2f,%2.2f) (%2.2f,%2.2f,%2.2f)\n", 
	       x[i].x, x[i].y, x[i].z, x[i].w,
	       a[i].x, a[i].y, a[i].z);
    return 0;
}


// Might help you while fighting with OpenCL.
// *********************************************************************
const char* oclErrorString(cl_int error)
{
    static const char* errorString[] = {
        "CL_SUCCESS",
        "CL_DEVICE_NOT_FOUND",
        "CL_DEVICE_NOT_AVAILABLE",
        "CL_COMPILER_NOT_AVAILABLE",
        "CL_MEM_OBJECT_ALLOCATION_FAILURE",
        "CL_OUT_OF_RESOURCES",
        "CL_OUT_OF_HOST_MEMORY",
        "CL_PROFILING_INFO_NOT_AVAILABLE",
        "CL_MEM_COPY_OVERLAP",
        "CL_IMAGE_FORMAT_MISMATCH",
        "CL_IMAGE_FORMAT_NOT_SUPPORTED",
        "CL_BUILD_PROGRAM_FAILURE",
        "CL_MAP_FAILURE",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "CL_INVALID_VALUE",
        "CL_INVALID_DEVICE_TYPE",
        "CL_INVALID_PLATFORM",
        "CL_INVALID_DEVICE",
        "CL_INVALID_CONTEXT",
        "CL_INVALID_QUEUE_PROPERTIES",
        "CL_INVALID_COMMAND_QUEUE",
        "CL_INVALID_HOST_PTR",
        "CL_INVALID_MEM_OBJECT",
        "CL_INVALID_IMAGE_FORMAT_DESCRIPTOR",
        "CL_INVALID_IMAGE_SIZE",
        "CL_INVALID_SAMPLER",
        "CL_INVALID_BINARY",
        "CL_INVALID_BUILD_OPTIONS",
        "CL_INVALID_PROGRAM",
        "CL_INVALID_PROGRAM_EXECUTABLE",
        "CL_INVALID_KERNEL_NAME",
        "CL_INVALID_KERNEL_DEFINITION",
        "CL_INVALID_KERNEL",
        "CL_INVALID_ARG_INDEX",
        "CL_INVALID_ARG_VALUE",
        "CL_INVALID_ARG_SIZE",
        "CL_INVALID_KERNEL_ARGS",
        "CL_INVALID_WORK_DIMENSION",
        "CL_INVALID_WORK_GROUP_SIZE",
        "CL_INVALID_WORK_ITEM_SIZE",
        "CL_INVALID_GLOBAL_OFFSET",
        "CL_INVALID_EVENT_WAIT_LIST",
        "CL_INVALID_EVENT",
        "CL_INVALID_OPERATION",
        "CL_INVALID_GL_OBJECT",
        "CL_INVALID_BUFFER_SIZE",
        "CL_INVALID_MIP_LEVEL",
        "CL_INVALID_GLOBAL_WORK_SIZE",
    };

    const int errorCount = sizeof(errorString) / sizeof(errorString[0]);

    const int index = -error;

    return (index >= 0 && index < errorCount) ? errorString[index] : "";

}
