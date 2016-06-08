#include <stdio.h>
#include <stdbool.h>
#include <string.h>
#include <stdlib.h>
#include <time.h>
#include "runwig.h"

char *url;
char *sessionid;
int pc;
FILE *f;

void output_Welcome()
{
  printf("\n    Welcome!\n  ");
}

void output_Pledge()
{
  printf("\n    How much do you want to contribute?\n    ");
  printf("<input name=\"contribution\" type=\"text\" size=\"4\">\n");
}

void output_Total(char * total)
{
  printf("\n    The total is now ");
  printf("%s", total);
  printf(".\n  ");
}

int local_Contribute_i;
int main() {
  srand48(time(0L));
  parseFields();
  url = "http://localhost/~plam/cgi-bin/tiny";
  sessionid = getenv("QUERY_STRING");

  if (strcmp(sessionid, "Contribute")==0)
    goto start_Contribute;
  if (strncmp(sessionid, "Contribute$",11)==0)
    goto restart_Contribute;
  printf("Content-type: text/html\n\n");
  printf("<title>Illegal Request</title>\n");
  printf("<h1>Illegal Request: %s</h1>\n",sessionid);
  exit(1);

start_Contribute:
  sessionid = randomString("Contribute",20);
  /* i = 87; */
  local_Contribute_i = 87;
  /* show Welcome... */
  printf("Content-type: text/html\n\n");
  printf("<form method=\"POST\" action=\"%s?%s\">\n",url,sessionid);
  output_Welcome();
  printf("<p><input type=\"submit\" value=\"continue\">\n");
  printf("</form>\n");
  f = fopen(sessionid,"w");
  fprintf(f, "1\n");
  fprintf(f, "%i\n",local_Contribute_i);
  fclose(f);
  exit(0);
Contribute_1:
  /* ... receive []; */ 
  /* show Pledge... */
  printf("Content-type: text/html\n\n");
  printf("<form method=\"POST\" action=\"%s?%s\">\n",url,sessionid);
  output_Pledge();
  printf("<p><input type=\"submit\" value=\"continue\">\n");
  printf("</form>\n");
  f = fopen(sessionid,"w");
  fprintf(f, "2\n");
  fprintf(f, "%i\n",local_Contribute_i);
  fclose(f);
  exit(0);
Contribute_2:
  /* ... receive [i = contribution]; */ 
  local_Contribute_i = atoi(getField("contribution"));
  /* amount = amount + i; */
  putGlobalInt("global_tiny_amount", getGlobalInt("global_tiny_amount") + local_Contribute_i);
  /* exit plug Total[total=amount]; */
  printf("Content-type: text/html\n\n");
  output_Total(itoa(getGlobalInt("global_tiny_amount")));
  exit(0);
restart_Contribute:
  f = fopen(sessionid, "r");
  fscanf(f, "%i\n",&pc);
  fscanf(f, "%i\n",&local_Contribute_i);
  if (pc==1) goto Contribute_1;
  if (pc==2) goto Contribute_2;
}
