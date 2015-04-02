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
#include <string>

using namespace std;




int  lowPassFilter        (int data);
int  highPassFilter       (int data);
int  derivative           (int data);
int  squaring             (int data);
int  movingWindowIntegral (int data);

//int  findPeak (int signals,int size);
// not needed


void  calculateThresholdI2();
void  calculateThresholdI1();
void  calculateSPKI         (double peaki);
void  calculateNPKI         (double peaki);

double thresholdI1 = 0;
double thresholdI2 = 0;
double SPKI = 0;
double NPKI = 0;


void timeSignalWriter();


int main() {
    
    ofstream dataf ("data.txt");
    ifstream signal1("signal.txt");
    ifstream time ("time.txt");
    ofstream QRSResultf("PTResult.txt");
    
    
    string inLine;
    string outLine;
    
    timeSignalWriter();
    
    //bool zeroReached = true;

    
    int a, b, c , i=0;
    
    while (signal1 >> a >> b >> c)
    { //   cout<<"in While";
        i++;
        //cout<<i<<" =  "<<a<<"  "<<b<<"  "<<c<<endl;
        b = lowPassFilter(b)       ;
        b = highPassFilter(b)      ;
        //b = derivative(b)          ;
        //b = squaring(b)            ;
        //b = movingWindowIntegral(b);
        
        
       
        
        double current, next, previos;
        previos = current;
        current = next;
        next = double(b);
        string s = to_string(b);
        dataf << s <<"\n";
        
        if (current>next && current>previos  ) {
            
            if (current>thresholdI1) {
                string s = to_string(current);
                dataf << s <<"\n";
                calculateSPKI(current);
            }   else{
                cout<<"current = "<<current<<" <= thresholdI1 = "<<thresholdI1<<" ==> Noise Peak\n";
                dataf <<"0\n";
                calculateNPKI(current);
            }
            calculateThresholdI1();
            calculateThresholdI2();
        }
         else{
            
            dataf <<"0\n";
        }
        /*
        if (<previosSignal) {
            if (b>thresholdI1)
            {
                calculateSPKI(b,SPKI);
            }   else{
                calculateNPKI(b,NPKI);
            }
            calculateThresholdI1();
            calculateThresholdI2();
            previosSignal = 0;
            
            
        }   else{
            thresholdI1 = 0;
            thresholdI2 = 0;
        previosSignal = b;
        }*/
        
        
        //string thrs = to_string(thresholdI1);
        //string s = to_string(b);
        //dataf <<"\t\t"<<thrs<<"\n";
    }
    dataf.close();
    return 0;
}



void timeSignalWriter(){
    ifstream signal("signal.txt");
    ifstream time ("time.txt");
    ofstream dataTimeFH("signalPlusTimeHighSignal.txt");
    ofstream dataTimeFL("signalPlusTimeLowSignal.txt");
    double time1 , lowSignal , highSignal;
    int id , high , low;
    while ((signal >> id >> high >> low )&&(time >> time1 >> lowSignal >> highSignal)) {
        
        high = lowPassFilter(high);
        high = highPassFilter(high);
        low  = lowPassFilter(low);
        low  = highPassFilter(low);
        
        int algValue;
        
        string ids = to_string(id);
        string s1  = to_string(time1);
        string s2  = to_string(high);
        string s3  = to_string(low);
        
        dataTimeFH << ids << "\t" << s1 << "\t" << s2 << "\t";
        dataTimeFL << ids << "\t" << s1 << "\t" << s3 << "\t";
        
        algValue = squaring(high);
        dataTimeFH << algValue << "\n";
        
        algValue = squaring(low);
        dataTimeFL << algValue << "\n";
        
        
    }


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
    if(ly > 32400)
        y = 32400;
    else
        y = (int) ly;
    return(y);
    
}



void calculateThresholdI1(){
    thresholdI1 = NPKI + 0.25 * ( SPKI-NPKI );
}


void calculateThresholdI2(){
    thresholdI2 = 0.5*thresholdI1;
}

void calculateSPKI (double peaki){
    SPKI = 0.125*peaki + 0.875*SPKI;
}

void calculateNPKI (double peaki){
    NPKI = 0.125*peaki + 0.875*NPKI;
}


