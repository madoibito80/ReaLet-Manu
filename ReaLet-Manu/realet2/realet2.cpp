#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include <string.h>





		/****Argument****/




//argv[1]=Path of input image.
//argv[2]=Width of input image.
//argv[3]=Height of input image.
//argv[4]=Directory of output ".rl" image files.







main(int argc,char *argv[]){


printf("ReaLet M-1\n");
printf("(C) 2014 ReiSato\n");





		/****Parameter****/




int exps_num = 1;
double hori_exis_rate = 0.05;
double perp_exis_rate = 0.05;
int base_num = 100;
double exis_rate = 0.40;




		/****Input****/


if(argc != 5){

	printf("ERROR:Arg count is bad.\n");
	exit(1);
}




char *file=argv[1];


int width=atoi(argv[2])+2*exps_num*3+2;
int height=atoi(argv[3])+2*exps_num*3+2;


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


int p=fgetc(fp);



for(y=0;y<height;y++){

for(x=0;x<width;x++){



if(p == EOF || x < exps_num*3+1 || x >= width-(exps_num*3+1) || y < exps_num*3+1 || y >= height-(exps_num*3+1)){

	img[y*width+x]=0;
}else{


if(p > 1){

	img[y*width+x]=0;
}else{

	img[y*width+x]=p;
}
	p=fgetc(fp);


}



}

}



fclose(fp);










		/****Expansion****/






int i;




int posi_x[8]={-1,0,+1,-1,+1,-1,0,+1};
int posi_y[8]={-1,-1,-1,0,0,+1,+1,+1};




for(i=0;i<exps_num;i++){

for(p=0;p<8;p++){

for(y=1;y<height-1;y++){

for(x=1;x<width-1;x++){


if(img[y*width+x] != 0 && img[y*width+x] != p+2 && img[(y+posi_y[p])*width+(x+posi_x[p])] == 0){

	img[(y+posi_y[p])*width+(x+posi_x[p])]=p+2;
}


}

}

}



for(y=0;y<height;y++){

for(x=0;x<width;x++){


if(img[y*width+x] != 0){

	img[y*width+x]=1;
}


}

}



}







		/****Get_Line****/





int *hori=(int *)calloc(height,sizeof(int));
int *perp=(int *)calloc(width,sizeof(int));

int max_len;

char manu_type;

int top;
int bottom;
int left;
int right;

int hori_count;
int perp_count;






for(i=0;i<10;i++){




	max_len = 0;




for(y=0;y<height;y++){


	hori[y]=0;


for(x=0;x<width;x++){

if(img[y*width+x] == 1){

	hori[y] += 1;
}

}


if(hori[y] > max_len){

	max_len=hori[y];
}


}




for(y=0;y<height;y++){

if(max_len - hori[y] <= max_len*hori_exis_rate){

	hori[y]=1;
}else{

	hori[y]=0;
}

}





	max_len = 0;




for(x=0;x<width;x++){

	perp[x]=0;

for(y=0;y<height;y++){

if(img[y*width+x] == 1){

	perp[x] += 1;
}

}


if(perp[x] > max_len){

	max_len=perp[x];
}

}




for(x=0;x<width;x++){

if(max_len - perp[x] <= max_len*perp_exis_rate){

	perp[x] = 1;
}else{

	perp[x] = 0;
}

}




	hori_count=0;




for(y=0;y<height-1;y++){

if(hori[y] == 1){

	hori[y] = 0;

if(hori[y+1] == 0){

	hori[y+1] = 2;
}

}else if(hori[y+1] == 1){

	hori[y] = 3;
	hori_count++;
}

}




	perp_count=0;




for(x=0;x<width-1;x++){

if(perp[x] == 1){

	perp[x] = 0;

if(perp[x+1] == 0){

	perp[x+1] = 2;

	perp_count++;
}

}else if(perp[x+1] == 1){

	perp[x] = 3;
}

}



if(i == 0){

if(hori_count > perp_count){

manu_type='Y';

}else if(perp_count > hori_count){

manu_type='T';

}else{

manu_type='T';

}

}





if(perp_count < 10){

perp_exis_rate += 0.10;

}

if(hori_count < 10){

hori_exis_rate += 0.10;

}

if(perp_count >= 10 && hori_count >= 10){

break;

}



}//for










for(y=0;y<height;y++){

if(hori[y] == 3){

	hori[y] = 0;
	break;
}

}


for(y=height-1;y>=0;y--){

if(hori[y] == 2){

	hori[y] = 0;
	break;
}

}


for(x=0;x<width;x++){

if(perp[x] == 3){

	perp[x] = 0;
	break;
}

}


for(x=width-1;x>=0;x--){

if(perp[x] == 2){

	perp[x] = 0;
	break;
}

}








		/****Check_Side****/






double top_exis_rate;
double bottom_exis_rate;
double left_exis_rate;
double right_exis_rate;

int top_count;
int bottom_count;
int left_count;
int right_count;



for(x=0;x<width;x++){




if(perp[x] == 2){

	left = x;
}



if(perp[x] == 3){

	right = x;



for(y=0;y<height;y++){


if(hori[y] == 2){

	top = y;
}

if(hori[y] == 3){

	bottom = y;







top_count=0;
bottom_count=0;
left_count=0;
right_count=0;






for(i=left;i<=right;i++){


if(img[(top-(3*exps_num))*width+i] == 1){

	top_count += 1;
}


if(img[(bottom+(3*exps_num))*width+i] == 1){

	bottom_count += 1;
}


}




top_exis_rate = (double)top_count / (double)(right-left+1);
bottom_exis_rate = (double)bottom_count / (double)(right-left+1);




if(top_exis_rate < exis_rate || bottom_exis_rate < exis_rate){

	perp[left] = 0;
	perp[right] = 0;
	manu_type='T';

}








for(i=top;i<=bottom;i++){


if(img[i*width+(left-(3*exps_num))] == 1){

	left_count += 1;
}


if(img[i*width+(right+(3*exps_num))] == 1){

	right_count += 1;
}


}





left_exis_rate = (double)left_count / (double)(bottom-top+1);
right_exis_rate = (double)right_count / (double)(bottom-top+1);




if(left_exis_rate < exis_rate || right_exis_rate < exis_rate){

	hori[top] = 0;
	hori[bottom] = 0;
	manu_type='Y';
}








}

}

}

}















		/****ReInput****/






fp=fopen(file,"rb");



p=fgetc(fp);



for(y=0;y<height;y++){

for(x=0;x<width;x++){



if(p == EOF || x < exps_num*3+1 || x >= width-(exps_num*3+1) || y < exps_num*3+1 || y >= height-(exps_num*3+1)){

	img[y*width+x]=0;
}else{


if(p > 1){

	img[y*width+x]=0;
}else{

	img[y*width+x]=p;
}
	p=fgetc(fp);


}



}

}



fclose(fp);








for(x=0;x<width;x++){

if(perp[x] == 3){

	perp[x] = 0;
	perp[x-2] = 3;
}

}




for(x=width-1;x>=0;x--){

if(perp[x] == 2){

	perp[x] = 0;
	perp[x+2] = 2;
}

}








for(y=0;y<height;y++){

if(hori[y] == 3){

	hori[y] = 0;
	hori[y-2] = 3;
}

}




for(y=height-1;y>=0;y--){

if(hori[y] == 2){

	hori[y] = 0;
	hori[y+2] = 2;
}

}







		/****Output****/




char *dir=argv[4];
double coef_width;
double coef_height;
int box_num = 0;
char path[256];
int r_x;
int r_y;

char before1;
char before2;


if(manu_type == 'T'){

	before1 = '0';

for(x=width-1;x>=0;x--){

if(perp[x] == 3){

	right = x;
	before1 = '3';
}

if(perp[x] == 2 && before1 == '3'){

	left = x;
	before1 = '2';

	before2 = '0';

for(y=0;y<height;y++){

if(hori[y] == 2){

	top = y;
	before2 = '2';
}

if(hori[y] == 3 && before2 == '2'){

	bottom = y;
	before2 = '3';


coef_width = (double)(right-left+1)/base_num;
coef_height = (double)(bottom-top+1)/base_num; 


for(i=0;i<sizeof(path)/sizeof(path[0]);i++){path[i]='\0';}
	strcat(path,dir);
	strcat(path,"/");
	itoa(box_num,&path[strlen(path)],10);
	strcat(path,".rl");

fp=fopen(path,"wb");

for(r_y=0;r_y<base_num;r_y++){

for(r_x=0;r_x<base_num;r_x++){



p=(int)(top+(double)r_y*coef_height)*width;
p+=(int)(left+(double)r_x*coef_width);

p=img[p];

fputc(p,fp);



}

}

fclose(fp);

	box_num++;


}

}

}

}

}
















if(manu_type == 'Y'){

	before1 = '0';

for(y=0;y<height;y++){

if(hori[y] == 2){

	top = y;
	before1 = '2';
}

if(hori[y] == 3 && before1 == '2'){

	bottom = y;
	before1 = '3';

	before2 = '0';

for(x=0;x<width;x++){

if(perp[x] == 2){

	left = x;
	before2 = '2';
}

if(perp[x] == 3 && before2 == '2'){

	right = x;
	before2 = '3';


coef_width = (double)(right-left+1)/base_num;
coef_height = (double)(bottom-top+1)/base_num; 


for(i=0;i<sizeof(path)/sizeof(path[0]);i++){path[i]='\0';}
	strcat(path,dir);
	strcat(path,"/");
	itoa(box_num,&path[strlen(path)],10);
	strcat(path,".rl");

fp=fopen(path,"wb");

for(r_y=0;r_y<base_num;r_y++){

for(r_x=0;r_x<base_num;r_x++){



p=(int)(top+(double)r_y*coef_height)*width;
p+=(int)(left+(double)r_x*coef_width);

p=img[p];

fputc(p,fp);



}

}

fclose(fp);

	box_num++;

}

}

}

}

}








printf("%d",box_num);
printf(":");
printf("%c",manu_type);
printf("\n");







printf("%d",width);
printf(":");
printf("%d",height);
printf("\n");
























	before1 = '0';

for(y=0;y<height;y++){

if(hori[y] == 2){

	top = y;
	before1 = '2';
}

if(hori[y] == 3 && before1 == '2'){

	bottom = y;
	before1 = '3';


printf("0:");
printf("%d",top);
printf(":");
printf("%d",width-1);
printf(":");
printf("%d",top);
printf("\n");

printf("0:");
printf("%d",bottom);
printf(":");
printf("%d",width-1);
printf(":");
printf("%d",bottom);
printf("\n");

}

}













	before1 = '0';

for(x=0;x<width;x++){

if(perp[x] == 2){

	left = x;
	before1 = '2';
}

if(perp[x] == 3 && before1 == '2'){

	right = x;
	before1 = '3';


printf("%d",left);
printf(":0:");
printf("%d",left);
printf(":");
printf("%d",height-1);
printf("\n");

printf("%d",right);
printf(":0:");
printf("%d",right);
printf(":");
printf("%d",height-1);
printf("\n");


}

}









		/****Resize_Image****/




fopen(file,"wb");

for(y=0;y<height;y++){

for(x=0;x<width;x++){

fputc(img[y*width+x],fp);

}

}

fclose(fp);








}





		/****ReaLet M-1****/
		/****2014/05/23 ~ 2014/07/28****/
		/****(C) 2014 ReiSato****/


