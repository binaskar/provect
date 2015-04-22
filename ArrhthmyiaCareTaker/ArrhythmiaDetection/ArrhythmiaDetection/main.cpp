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
#include <algorithm>
#include <iterator>
#include <vector>
#include <ostream>
#include "BDAC.H"
//#include "ANALBEAT.H"

using namespace std;

//int *onset=0 ;
//int *offset=0 ;
//int *isoLevel=0 ;
//int *beatBegin=0 ;
//int *beatEnd=0;
//int *amp=0;
int QRSFilter(int datum,int init);
int Peak( int datum, int init );
int QRSDet(int dataum, int init);
void checkTachycardiaBradycardia (string patientName);
void RDetection();
void timeSignalWriter();
void AnalyzeBeat(int *beat, int *onset, int *offset,
                 int *isoLevel, int *beatBegin, int *beatEnd, int *amp) ;



int main(int argc, const char * argv[]) {
    
    ofstream signal("QRSDelay.txt");
    ofstream timerReport("timeReport.txt");
    ofstream beatAnalysis("AnalyzeBeat");
    //cout<<"Working4";
    
    timeSignalWriter();
    string  patientName = argv[1];
    ifstream timedSignal(patientName+"_data.txt");
    //ifstream timedSignal("timedSignal.txt");
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
    //int *beat;
    //beat= new int[BEAT_MS100];
    //for (int i=0; i<BEAT_MS100; i++) {
      //  beat[i]=0;
    //}
   
    const clock_t timer = clock();
    //cout<<"Working3";
    while (timedSignal>>a>>b>>c) {
       
        if (init) {
            QRSDet(0, 1);
            init = 0;
        }
        
        int qrsDelay = QRSDet(c, init);
        //cout<<"Working1";
        //beat[0] = c;
        //cout<<"Working2";
        //AnalyzeBeat(beat, onset, offset, isoLevel, beatBegin, beatEnd, amp);
        //rotate(beat,beat+1, beat+100);
        //rotate(<#_ForwardIterator __first#>, <#_ForwardIterator __middle#>, <#_ForwardIterator __last#>)
        
        //beatAnalysis << to_string(b)<<"\t" << to_string(*beatBegin)<<"\t"<<to_string(*beatEnd)<<"\t"<<to_string(*onset)<<"\t"<<to_string(*offset)<<"\n";
        //cout<<*beatBegin<<"\t"<<*beatEnd<<"\n";
        
        if (qrsDelay) {
            start = true;
            
        }
        
        if (start) {
            if (qrsDelay) {
                
                QRSPeak[i-qrsDelay] = signals[i-qrsDelay];
                for (int j=0; j<i; j++) {
                    s = to_string(ids[j]);
                    signal << s <<"\t";
                    s = to_string(times[j]);
                    signal << s << "\t";
                    s = to_string(signals[j]);
                    signal<<s<<"\t";
                    s = to_string(QRSPeak[j]);
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
    checkTachycardiaBradycardia (patientName);
    float arrthmieaDTime = float((clock() - timer)/CLOCKS_PER_SEC) - detectionTime ;
    timerReport << "Timer Report For Record [103] :-\n";
    timerReport << "QRS Detection Time =\t"<<to_string(detectionTime)<<"s\n";
    timerReport << "ARR Detection Time =\t"<<to_string(arrthmieaDTime)<<"s\n";
    timerReport << "Total Time =\t"<<to_string(timer)<<"s\n";
    
    signal.close();
    timerReport.close();
    //RDetection();
    
    return 0;
}
