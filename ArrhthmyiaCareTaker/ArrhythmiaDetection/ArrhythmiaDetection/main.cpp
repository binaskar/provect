//
//  main.cpp
//  ArrhythmiaDetection
//
//  Created by Abdulrahman on 4/4/15.
//  Copyright (c) 2015 Abdulrahman. All rights reserved.
//

#include  <fstream>
#include <iostream>
#include <sstream>
#include <string>
#include "qrsdet.h"
#include <stdlib.h>
#include <string.h>
#include <time.h>

using namespace std;

//int QRSFilter(int datum,int init);
//int Peak( int datum, int init );
int QRSDet(int dataum, int init);
void checkTachycardiaBradycardia ();
void RDetection();
void timeSignalWriter();
void AnalyzeBeat(int *beat, int *onset, int *offset,
                 int *isoLevel, int *beatBegin, int *beatEnd, int *amp) ;

int main(int argc, const char * argv[]) {
    
    ofstream signal("QRSDelay.txt");
    ofstream timerReport("timeReport.txt");
    
    
    timeSignalWriter();
    
    ifstream timedSignal("timedSignal.txt");
    
    bool start = false;
    double a , c ;
    double b;
    int init = 1,i = 0;
    //double startTime = 0.0 , endTime = 0.0;
    string s;
    int signals[1000];
    int QRSPeak[1000];
    int ids[1000];
    double times[1000];
    stringstream convert;
    const clock_t timer = clock();
    while (timedSignal>>a>>b>>c) {
       
        if (init) {
            QRSDet(0, 1);
            init = 0;
        }
        
        int qrsDelay = QRSDet(c, init);
        if (qrsDelay) {
            start = true;
        }
        
        if (start) {
            if (qrsDelay) {
                
                QRSPeak[i-qrsDelay] = signals[i-qrsDelay];
                for (int j=0; j<i; j++) {
                    //s = to_string(ids[j]);
                    
					
					convert << ids[j];
			  		s= convert.str();
                    signal << s <<"\t";
                    //s = to_string(times[j]);
                    convert << times[j];
			  		s= convert.str();
                    signal << s << "\t";
                    //s = to_string(signals[j]);
                    convert << signals[j];
			  		s= convert.str();
                    signal<<s<<"\t";
                    //s = to_string(QRSPeak[j]);
                    convert << QRSPeak[j];
			  		s= convert.str();
                    signal<<s<<"\n";
                }
                i=0;
                
                uninitialized_fill_n(QRSPeak, 1000, 0);
                uninitialized_fill_n(signals, 1000, 0);
                uninitialized_fill_n(times, 1000, 0);
                uninitialized_fill_n(ids, 1000, 0);
            
            }
            else if(i==1000){
                for (int j=0; j<500; j++) {
                    s = to_string(ids[j]);
                    ids[j] = ids[j+500];
                    signal << s <<"\t";
                    s = to_string(times[j]);
                    times[j] = times[j+500];
                    signal << s << "\t";
                    s = to_string(signals[j]);
                    signals[j] = signals[j+500];
                    signal<<s<<"\t";
                    s = to_string(QRSPeak[j]);
                    QRSPeak[j] = QRSPeak[j+500];
                    signal<<s<<"\n";
                }
                i=500;
            }
            else{
                ids[i]     = a;
                times[i]   = b;
                signals[i] = c;
                QRSPeak[i] = qrsDelay;
                i++;
                
            }
           
        }
    }
    float detectionTime = float((clock() - timer)/CLOCKS_PER_SEC);
    checkTachycardiaBradycardia ();
    float arrthmieaDTime = float((clock() - timer)/CLOCKS_PER_SEC) - detectionTime ;
    timerReport << "Timer Report For Record [103] :-\n";
    timerReport << "QRS Detection Time =\t"<<to_string(detectionTime)<<"s\n";
    timerReport << "ARR Detection Time =\t"<<to_string(arrthmieaDTime)<<"s\n";
    timerReport << "Total Time =\t"<<to_string(timer)<<"s\n";
    
    signal.close();
    timerReport.close();
    RDetection();
    
    return 0;
}
