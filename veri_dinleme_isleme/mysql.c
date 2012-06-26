#include <mysql.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "ev.c"


int main()
{
	
	MYSQL *conn;
	MYSQL_RES *res;
	MYSQL_ROW row;
	int len_asilveri = 3;
	char *asilveri[len_asilveri];
	int i, j = 0;      
	const char *server ="www.messah.net";
	const char *user = "messahne_root";
	const char *password="19900926";
	const char database[] = "messahne_ev";
	char b[1];
	char sorgu[50];
	
	int n;
	
	int fd = 0;
    int baudrate = B9600;  // default
	fd = serialport_init("/dev/ttyACM0", baudrate);
	if(fd==-1) {
		printf("Port açılamadı\n");
		exit(1);
	}
    usleep(3000 * 1000);
	printf("başlıyoruz\n");	
	
	
	for(i = 0; i < 10; i++)
		asilveri[i] = malloc(sizeof(char) * 10);
	
	conn = mysql_init(NULL);
   //veri tabanına baglanti
	if (!mysql_real_connect(conn, server, user, password, database, 0, NULL, 0)) {
		fprintf(stderr, "%s\n", mysql_error(conn));
		exit(1);
	}

   //veri tabanina sql sorgusu
	if(mysql_query(conn, "show tables")) {
		fprintf(stderr, "%s\n", mysql_error(conn));
		exit(1);
	}
	
	res = mysql_use_result(conn);

	//tablonun ismi
	printf("\nVeri tabaninin ismi:\n");
	while ((row = mysql_fetch_row(res)) != NULL) {
		printf("%s\n", row[0]);
	}			 
	if(mysql_query(conn, "SELECT * FROM KULLANICI WHERE username='messah'")) {
		printf("Sorgu calistirilamadi!, Hata: %s\n", mysql_error(conn));
	    exit(1);
	}
	
	res = mysql_store_result(conn);     
	printf("Id\tUsername\tPassword\tKombi\tKlima\tAdres\n");
	printf("======\t======\t\t======\t\t=====\t=====\t=====\n");	     
	
	while ((row = mysql_fetch_row(res))) {
		printf("%s\t%s\t\t%s\t\t%s\t%s\t%s\n", row[0], row[1], row[2], row[3], row[4], row[5]);
		asilveri[j]=row[1];   
		asilveri[j+1]=row[3];   
		asilveri[j+2]=row[4];
		j = j + 3; 
	}
	
// tanımlamalar
	int len_tmp = 3;
	int len_gonderilen = 10;
	char *gonderilen[len_gonderilen];
	char *tmp[len_tmp];
	int y, a, m;
	int k ,z;
	int boyut;
	int durum;
	for(i = 0; i < 2; i++)
			gonderilen[i] = malloc(sizeof(char) * 5);
		for(i = 0; i < 6; i++)
			tmp[i] = malloc(sizeof(char) * 10);
	while(1) {

		y = 0;  
		mysql_close(conn);
		conn = mysql_init(NULL);

		if (!mysql_real_connect(conn, server, user, password, database, 0, NULL, 0)) {
			fprintf(stderr, "%s\n", mysql_error(conn));
			exit(1);
		}	 

		if(mysql_query(conn, "SELECT * FROM KULLANICI WHERE username='messah'")) {
			printf("Sorgu calistirilamadi!, Hata: %s\n", mysql_error(conn));
			exit(1);
		}
		res = mysql_store_result(conn);     
		//~ printf("Id\tUsername\tPassword\tKombi\tKlima\tAdres\n");	
		//~ printf("======\t======\t\t======\t\t=====\t=====\t=====\n");	     
		while ((row = mysql_fetch_row(res))) {
			//~ printf("%s\t%s\t\t%s\t\t%s\t%s\t%s\n", row[0], row[1], row[2],row[3],row[4],row[5]);
			strncpy(tmp[y], row[1], 7);
			strncpy(tmp[y+1], row[3], 2);
			strncpy(tmp[y+2], row[4], 2);
			y = y + 3;

		}	
		
		n = read(fd, b, 1);
		if(n != 0)
			if(b[0] == '2') {
				*tmp[1] = (1 - (*tmp[1] - '0')) + '0';
				*asilveri[1] = *tmp[1];
				sprintf(sorgu, "UPDATE KULLANICI SET kombi='%c%s", *tmp[1], "' WHERE username='messah'");
				if(mysql_query(conn, sorgu))
					printf("Sorgu calistirilamadi!, Hata: %s\n", mysql_error(conn));
			}
		k = 1;
		
		while(k < len_asilveri) {
			//~ printf("=====> %s\t%s\n", asilveri[k],tmp[k]);
			if (strcmp(asilveri[k],tmp[k]) != 0) {
				if(k%2 != 0) {
					//~ printf("kombi :%s \n",tmp[k]);
					led_yak(fd, "kombi", tmp[k]);
					if(*tmp[k] == '0')
						printf("\nKombi kapatıldı.\n");
					else
						printf("\nKombi açıldı.\n");
					*asilveri[k] = *tmp[k];
					k = k + 1;
				}
				else {
					//~ printf("klima: %s\n",tmp[k]);
					led_yak(fd, "klima", tmp[k]);
					if(*tmp[k] == '0')
						printf("\nKlima kapatıldı.\n");
					else
						printf("\nKlima açıldı.\n");
					*asilveri[k] = *tmp[k];
					k = k + 1;
				}
			}
			else{
				k = k + 1;
			}
		}
		
		printf("\n2 saniye sonra dönecem.\n");	
		sleep(2);
		
		printf("\ndöndüm\n");
		
	}
	
	for(i = 0; i < 10; i++)
			free(gonderilen[i]);
	for(i = 0; i < 10; i++)
			free(tmp[i]);
	for(i = 0; i < 10; i++)
			free(asilveri[i]);
			

	close(fd);

	mysql_free_result(res);
	mysql_close(conn);
	return 0;
}
