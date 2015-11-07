#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include <string.h>





		/****Argument****/




//argv[1]=Path of input image.
//argv[2]=Width of input image.
//argv[3]=Height of input image.
//argv[4]=Directory of memory.

//argv[5]=Answer of input image.





main(int argc,char *argv[]){


printf("ReaLet OCR-Engine 2\n");
printf("(C) 2014 ReiSato\n");


		/****Parameter****/


int cont_num = 1;
int exps_num = 1;
int base_num = 100;




		/****Input****/




if(argc != 5 && argc != 6){

	printf("ERROR:Arg count is bad.\n");
	exit(1);
}



char *file=argv[1];


int width=atoi(argv[2])+2*exps_num+2;
int height=atoi(argv[3])+2*exps_num+2;


FILE *fp=fopen(file,"rb");



if(fp == NULL){

	printf("ERROR:InputFile[");
	printf(file);
	printf("] is not found.\n");
	exit(1);
}




unsigned char *img=(unsigned char *)calloc(width*height,sizeof(unsigned char));


int x;
int y;











int p = fgetc(fp);


for(y=0;y<height;y++){

for(x=0;x<width;x++){





if(p == EOF || x < exps_num+1 || x >= width-(exps_num+1) || y < exps_num+1 || y >= height-(exps_num+1)){

	img[y*width+x]=0;

}else{


if(p > 1){

	img[y*width+x]=0;
}else{

	img[y*width+x]=p;
}

p = fgetc(fp);

}



}

}



fclose(fp);









		/****Contraction****/




int n;



for(n=0;n<cont_num;n++){



for(y=1;y<height-1;y++){

for(x=1;x<width-1;x++){


if(img[y*width+x] == 1){

if(img[y*width+(x+1)] == 0){

	img[y*width+x]=2;
}

if(img[y*width+(x-1)] == 0){

	img[y*width+x]=2;
}

if(img[(y+1)*width+x] == 0){

	img[y*width+x]=2;
}

if(img[(y-1)*width+x] == 0){

	img[y*width+x]=2;
}

}


}

}



for(y=0;y<height;y++){

for(x=0;x<width;x++){


if(img[y*width+x] == 2){

	img[y*width+x]=0;
}


}

}



}//.cont_num







		/****Expansion****/






for(n=0;n<exps_num;n++){



for(y=1;y<height-1;y++){

for(x=1;x<width-1;x++){


if(img[y*width+x] == 1){

if(img[y*width+(x+1)] == 0){

	img[y*width+(x+1)]=2;
}

if(img[y*width+(x-1)] == 0){

	img[y*width+(x-1)]=2;
}

if(img[(y+1)*width+x] == 0){

	img[(y+1)*width+x]=2;
}

if(img[(y-1)*width+x] == 0){

	img[(y-1)*width+x]=2;
}

}


}

}



for(y=0;y<height;y++){

for(x=0;x<width;x++){


if(img[y*width+x] == 2){

	img[y*width+x]=1;
}


}

}



}//.exps_num











		/****Trimming****/





int top = height;
int bottom = 0;
int left = width;
int right = 0;




for(y=0;y<height;y++){

for(x=0;x<width;x++){

if(img[y*width+x] != 0){


if(y < top){

	top = y;
}

if(y > bottom){

	bottom = y;
}

if(x < left){

	left = x;
}

if(x > right){

	right = x;
}


}

}

}





		/****Move****/






int width2 = right-left+1;
int height2 = bottom-top+1;









for(y=0;y<height2;y++){

for(x=0;x<width2;x++){

img[y*width2+x] = img[(y+top)*width+(x+left)];

}

}









		/****Resize****/




double coef;
int pad;

double pool;

unsigned char *img2=(unsigned char *)calloc(base_num*base_num,sizeof(unsigned char));




if(width2 > height2){

	coef=(double)width2/(double)base_num;
	pool=(double)(width2-height2+1)/2/coef;
	pad=(int)pool;

}else{

	coef=(double)height2/(double)base_num;
	pool=(double)(height2-width2+1)/2/coef;
	pad=(int)pool;

}




for(y=0;y<base_num;y++){

for(x=0;x<base_num;x++){


img2[y*base_num+x] = 0;


}

}




if(width2 > height2){


for(y=pad;y<base_num-pad;y++){

for(x=0;x<base_num;x++){


n = (int)((double)(y-pad)*coef)*width2+(int)((double)x*coef);
img2[y*base_num+x] = img[n];


}

}


}else{


for(y=0;y<base_num;y++){

for(x=pad;x<base_num-pad;x++){


n = (int)((double)y*coef)*width2+(int)((double)(x-pad)*coef);
img2[y*base_num+x] = img[n];


}

}


}






		/****Matching****/





int m;
int ID;
char memory_file[256];
char *memory_dir=argv[4];



char letter[10];









for(m=0;m<sizeof(memory_file)/sizeof(memory_file[0]);m++){memory_file[m]='\0';}
	strcat(memory_file,memory_dir);
	strcat(memory_file,"/memory1.mmr");


fp=fopen(memory_file,"rb");

if(fp == NULL){

	ID = 0;

}else{

	ID = fgetc(fp);

if(ID == EOF){

	ID = 0;
}else{

	ID = ID*256*256;
	ID += fgetc(fp)*256;
	ID += fgetc(fp);

}


}



fclose(fp);










if(argc == 5){


double miss_len;
int i;
int r;
double good_miss_len[5]={10000,10000,10000,10000,10000};
int good_ID[5]={-1,-1,-1,-1,-1};



for(m=0;m<sizeof(memory_file)/sizeof(memory_file[0]);m++){memory_file[m]='\0';}
	strcat(memory_file,memory_dir);
	strcat(memory_file,"/memory2.mmr");



fp=fopen(memory_file,"rb");



ID = fgetc(fp);



while(ID != EOF){




miss_len = 0;




ID = ID*256*256;
ID += fgetc(fp)*256;
ID += fgetc(fp);


for(y=0;y<base_num;y++){

for(x=0;x<base_num;x++){


miss_len += (double)abs(img2[y*base_num+x] - fgetc(fp));


}

}






for(r=0;r<5;r++){

if(miss_len < good_miss_len[r]){

for(m=4;m>r;m--){

good_miss_len[m]=good_miss_len[m-1];
good_ID[m]=good_ID[m-1];

}

good_miss_len[r]=miss_len;
good_ID[r]=ID;

break;

}

}





ID = fgetc(fp);




}//while





fclose(fp);










for(m=0;m<sizeof(memory_file)/sizeof(memory_file[0]);m++){memory_file[m]='\0';}
	strcat(memory_file,memory_dir);
	strcat(memory_file,"/memory3.mmr");


fp=fopen(memory_file,"rb");



ID = fgetc(fp);


while(ID != EOF){


ID = ID*256*256;
ID += fgetc(fp)*256;
ID += fgetc(fp);





for(i=0;i<10;i++){

	letter[i] = fgetc(fp);
}




for(m=0;m<5;m++){

if(ID == good_ID[m]){

pool = good_miss_len[m]/(double)(base_num*base_num);
pool = pool*100;
pool = 100-pool;

	printf(letter);
	printf(":");
	printf("%f",pool);
	printf(":");
	printf("%d",ID);
	printf("\n");

}

}



ID = fgetc(fp);


}//while




fclose(fp);






}//argc == 5







		/****Memorize****/







if(argc == 6){







for(m=0;m<sizeof(memory_file)/sizeof(memory_file[0]);m++){memory_file[m]='\0';}
	strcat(memory_file,memory_dir);
	strcat(memory_file,"/memory2.mmr");




fp=fopen(memory_file,"ab");


fputc(ID/(256*256),fp);
fputc(ID%(256*256)/256,fp);
fputc(ID%(256*256)%256,fp);


for(y=0;y<base_num;y++){

for(x=0;x<base_num;x++){


fputc(img2[y*base_num+x],fp);


}

}


fclose(fp);









for(m=0;m<sizeof(letter)/sizeof(letter[0]);m++){letter[m]='\0';}

strcat(letter,argv[5]);










for(m=0;m<sizeof(memory_file)/sizeof(memory_file[0]);m++){memory_file[m]='\0';}
	strcat(memory_file,memory_dir);
	strcat(memory_file,"/memory3.mmr");



fp=fopen(memory_file,"ab");


fputc(ID/(256*256),fp);
fputc(ID%(256*256)/256,fp);
fputc(ID%(256*256)%256,fp);

for(m=0;m<10;m++){

	fputc(letter[m],fp);
}

fclose(fp);











for(m=0;m<sizeof(memory_file)/sizeof(memory_file[0]);m++){memory_file[m]='\0';}
	strcat(memory_file,memory_dir);
	strcat(memory_file,"/memory1.mmr");


fp=fopen(memory_file,"wb");


ID += 1;

fputc(ID/(256*256),fp);
fputc(ID%(256*256)/256,fp);
fputc(ID%(256*256)%256,fp);

fclose(fp);












printf("%d",base_num);
printf(":");
printf("%d",base_num);












fp=fopen(file,"wb");


for(y=0;y<base_num;y++){

for(x=0;x<base_num;x++){


fputc(img2[y*base_num+x],fp);


}

}


fclose(fp);







}//argc == 6





}





		/****ReaLet OCR-Engine 2****/
		/****2014/06/20 ~ 2014/07/31****/
		/****(C) 2014 ReiSato****/

