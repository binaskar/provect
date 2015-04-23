//
//  main.cpp
//  PTTEST
//
//  Created by Abdulrahman on 3/20/15.
//  Copyright (c) 2015 Abdulrahman. All rights reserved.
//
#include  <fstream>
#include <iostream>
#include <sstream>
#include <queue> 
#include <string.h>
using namespace std;




int  lowPassFilter        (int data);
int  highPassFilter       (int data);
int  derivative           (int data);
int  squaring             (int data);
int  movingWindowIntegral (int data);

//int  findPeak (int signals,int size);
// not needed




double calMean(int data[],int size);
void  calculateThresholdI2ByMean();
void  calculateThresholdI1ByMean();
void  calculateSPKIByMean         (double peaki);
void  calculateNPKIByMean         (double peaki);

double SPKIByMean = 0.15;
double NPKIByMean = 0.15;
double thresholdI1ByMean = NPKIByMean + 0.25 * ( SPKIByMean-NPKIByMean );
double thresholdI2ByMean = 0.5*thresholdI1ByMean;

void timeSignalWriter();


int main() {
    
    
    ifstream signal1("signal.txt");
    ofstream byMean("byMean.txt");
    ofstream qrsinfo("qrsinfo.txt");
   
	
    
    int size=360*2;//2*frequency
    //timeSignalWriter();
    
    //bool zeroReached = true;

    int qrsid;
    int data[size],time[size],id[size],oldData[size];
    int a, b, c , i=0,maxR=0,countQRS=0;
    bool qrs=false,noqrs=false,startqrs=false;
    double current=0, next=0, previos=0;
    while (signal1 >> a >> b >> c)
    { //   cout<<"in While";
        
        //cout<<i<<" =  "<<a<<"  "<<b<<"  "<<c<<endl;
		//pan<<b<<"\t";
		oldData[i]=b;
        b = lowPassFilter(b)       ;
		string l;
		stringstream convertl;
		convertl << b;
		l= convertl.str();
		//pan<<l<<"\t";
        b = highPassFilter(b)      ;
		string h;
		stringstream converth;
		converth << b;
		h= converth.str();
		//pan<<h<<"\t";
        b = derivative(b)          ;
		string d;
		stringstream convertd;
		convertd << b;
		d= convertd.str();
		//pan<<d<<"\t";
        b = squaring(b)            ;
		string s2;
		stringstream converts2;
		converts2 << b;
		s2= converts2.str();
		//pan<<s2<<"\t";
        b = movingWindowIntegral(b);
		string m;
		stringstream convertm;
		convertm << b;
		m= convertm.str();
		//pan<<m<<"\n";
        
        
       
        
        
        data[i]=b;
        id[i]=a;
        if(i==size-1){
        	double mean=calMean(data,size);
        	double SPKIByMean = mean;
			double NPKIByMean = mean;
			int maxPoint=0;
					
        	for(int j=0;j<size;j++){
        		byMean<<id[j]<<"\t";
        		string d;
				stringstream convert;
				convert << data[j];
				d= convert.str();
				byMean<<oldData[j]<<"\t";
        		//byMean << d <<"\t";
        		calculateThresholdI1ByMean();
                calculateThresholdI2ByMean();
        		if(data[j]>thresholdI1ByMean){
		  
				    
		            if (data[j]>thresholdI1ByMean) {
		            	string t;
						stringstream convert2;
						convert2 << data[j];
						t= convert2.str();
		                //string s = to_string(current);
		                byMean << t <<"\n";
		                calculateSPKIByMean(j);
		                qrs=true;
		            	}   else{
		                //cout<<"current = "<<current<<" <= thresholdI1 = "<<thresholdI1<<" ==> Noise Peak\n";
		                byMean <<"0\n";
		                calculateNPKIByMean(j);
		                
		            	}
		           
		            
		       			} 	else{
		            
		            byMean <<"0\n";
		            noqrs=true;
		       		}
		       			
		       		if(qrs==true&&noqrs==false){//in qrs
		       			if(data[j]>maxR){
		       				maxR=data[j];
		       				maxPoint=j;
							}
		       				
					} else if(qrs==false&&noqrs==true){//going to next qrs
						   
					} else if(qrs==true&&noqrs==true){//transfere to going to next qrs or out from qrs
						if(startqrs==false){//find next  qrs
						qrs=false;
						noqrs=false;
						startqrs=true;
						qrsinfo<<id[j]<<"\t";
						countQRS++;
						}else{ //out from previse qrs
						qrs=false;
						noqrs=false;
						startqrs=false;
						qrsinfo<<id[j]<<"\t";
						qrsinfo<<id[maxPoint]<<"\t";
						qrsinfo<<countQRS<<"\n";
						maxR=0;
							}
						}
		       			
			}
			
			i=0;
		}else{
			i++;
		}
          
        
        
       
    	
    }
    
    ifstream readData("byMean.txt");
        ofstream xorData("last.txt");
        while(readData>>a>>b>>c){
        	if(c!=0){
        		xorData<<a<<"\t"<<b<<"\t"<<c<<"\t"<<b<<"\n";
			}else{
				xorData<<a<<"\t"<<b<<"\t"<<c<<"\t"<<"0"<<"\n";
			}
			
		}
   
    
    return 0;
}



int lowPassFilter(int data)
{
    int y0;
    static int y11 = 0, y2 = 0, x[26], n1 = 12;

x[n1] = x[n1 + 13] = data;
y0 = (y11 << 1) - y2 + x[n1] - (x[n1 + 6] << 1) + x[n1 + 12];
y2 = y11;
y11 = y0;
y0 >>= 5;
if(--n1 < 0)
n1 = 12;
return(y0);
}




int highPassFilter(int data)
{
    int y0;
    static int y1 = 0, x[66], n = 32;
    x[n] = x[n + 33] = data;
    y0 = y1 + x[n] - x[n + 32];
    y1 = y0;
    if(--n < 0)
    n = 32;
    return(x[n + 16] - (y0 >> 5));
}


int derivative(int data)
{
    int y, i;
    static int x_derv[4];
    /*y = 1/8 (2x( nT) + x( nT - T) - x( nT - 3T) - 2x( nT - 4T))*/
    y = (data << 1) + x_derv[3] - x_derv[1] - ( x_derv[0] << 1);
    y >>= 3;
    for (i = 0; i < 3; i++)
        x_derv[i] = x_derv[i + 1];
    x_derv[3] = data;
    return(y);

}

int squaring(int data){
    //if (data*data>8000)return(8000);
    return(data*data);
}

int movingWindowIntegral(int data)
{
    static int x[32], ptr = 0;
    static long sum = 0;
    long ly;
    int y;
    if(++ptr == 32)
        ptr = 0;
    sum -= x[ptr];
    sum += data;
    x[ptr] = data;
    ly = sum >> 5;
    
        y = (int) ly;
    return(y);
    
}


//***********************************************************

double calMean(int data[],int size){
	double sum=0;
	for(int i=0;i<720;i++)
	sum+=data[i];
	return sum/720;
}

void calculateThresholdI1ByMean(){
    thresholdI1ByMean = NPKIByMean + 0.25 * ( SPKIByMean-NPKIByMean );
}


void calculateThresholdI2ByMean(){
    thresholdI2ByMean = 0.5*thresholdI1ByMean;
}

void calculateSPKIByMean (double peaki){
    SPKIByMean = 0.125*peaki + 0.875*SPKIByMean;
}

void calculateNPKIByMean (double peaki){
    NPKIByMean = 0.125*peaki + 0.875*NPKIByMean;
}


