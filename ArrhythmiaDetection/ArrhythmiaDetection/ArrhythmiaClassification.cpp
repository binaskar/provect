//
//  ArrhythmiaClassification.cpp
//  ArrhythmiaDetection
//
//  Created by Abdulrahman on 4/4/15.
//  Copyright (c) 2015 Abdulrahman. All rights reserved.
//

#include "ArrhythmiaClassification.h"
using namespace std;
void checkQRSBasedArrhythmia  ();
void checkQRSTBasedArrhythmia ();
void checkPQRSTBasedArrhythmia();
void checkTachycardiaBradycardia ();



void checkTachycardiaBradycardia (){
    ifstream data("QRSDelay.txt");
    ofstream temp("arrhthmia.txt");
    int id ,signal,peak ;
    float time=0 , startTime=0;
    string s;
    while (data>>id>>time>>signal>>peak) {
        
        if (peak) {
            double heartRate = 60/(time-startTime);
            s = to_string(id);
            temp<<s<<"\t";
            s = to_string(heartRate);
            if (heartRate>100) {
                temp<<s<<"\tTA\n";
            }else if(heartRate<60){
                temp<<s<<"\tBR\n";
            }else
                temp<<s<<"\tNR\n";
            startTime = time;
        }
        
    }
    
}
