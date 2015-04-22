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
void checkTachycardiaBradycardia (string patientName);
string timeBasedArDetection(double time, int high, char blcokName);
string timeBasedRightSide();
string timeBasedLeftSide();
void timeBasedAlgPreprocessing();


void checkTachycardiaBradycardia (string patientName){
    ifstream data("QRSDelay.txt");
    ofstream temp(patientName+"_result.txt");
    
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
/***************************************
 timeBasedArDetection is function that impliment the algorthim used in research linked to
 http://www.ijcsit.com/docs/Volume%202/vol2issue1/ijcsit2011020106.pdf
 ***************************************/
void timeBasedAlgPreprocessing(){
    ifstream data("finalECG.txt");
    ifstream bpm ("arrhthmia.txt");
    ofstream result("timeBasedArrhthmyia.txt");
    double time;
    int id, high;
    char blockName;
    bool beatOnSet = false,detect = false;
    double timeDifference[13];
    
    while (data>>id>>time>>high>>blockName) {
        if (blockName=='N') {
            beatOnSet = true;
        }   else{
            result<<to_string(time)<<"\t"<<to_string(high)<<"\t"
            <<blockName<<"\tNA";
        }
        if (beatOnSet) {
            
            switch (blockName) {
                case 'A':
                    timeDifference[2]=time;
                    
                    break;
                    
                case 'B':
                    timeDifference[3]=time;
                    break;
                    
                case 'C':
                    timeDifference[5]=time;
                    break;
                    
                case 'D':
                    timeDifference[7]=time;
                    break;
                    
                case 'E':
                    timeDifference[9]=time;
                    break;
                    
                case 'F':
                    timeDifference[12]=time;
                    
                    break;
                    
                case 'G':
                    timeDifference[10]=time;
                    break;
                    
                case 'N':
                    timeDifference[0]=time;
                    break;
                    
                case 'P':
                    timeDifference[1]=time;
                    break;
                    
                case 'Q':
                    timeDifference[4]=time;
                    break;
                    
                case 'R':
                    timeDifference[6]=time;
                    break;
                    
                case 'S':
                    timeDifference[8]=time;
                    break;
                    
                case 'T':
                    timeDifference[11]=time;
                    break;
                    
                    
                default:
                    break;
            }
        }
        if(detect){
            
        }
    }
}
/***************************************
 timeBasedArDetection is function that impliment the algorthim used in research linked to
 http://www.ijcsit.com/docs/Volume%202/vol2issue1/ijcsit2011020106.pdf
 ***************************************/
string timeBasedArDetection(double time1, int high, char blcokName){
    
    
    return "NR";
}

/***************************************
 timeBasedArDetection is function that impliment the algorthim used in research linked to
 http://www.ijcsit.com/docs/Volume%202/vol2issue1/ijcsit2011020106.pdf
 ***************************************/
string timeBasedTopLevel(){
    
    if (timeBasedRightSide()=="NR") {
        if (timeBasedLeftSide()=="NR") {
            return "NR";
        }
        else return timeBasedLeftSide();
    }
    else return timeBasedRightSide();
    return "NR";
}

string timeBasedRightSide(){
    return "NR";
}
string timeBasedLeftSide(){

    return "NR";
}





