//
//  fileHandling.cpp
//  ArrhythmiaDetection
//
//  Created by Abdulrahman on 4/5/15.
//  Copyright (c) 2015 Abdulrahman. All rights reserved.
//


#include <stdio.h>
#include <iostream>
#include <fstream>
using namespace std;
void timeSignalWriter();

void timeSignalWriter(){
    ifstream signal("standData.txt");
    ifstream csvBased ("csvData.txt");
    ofstream timedSignal("timedSignal.txt");
    
    
    
    double time , lowSignal , highSignal;
    int id , high , low;
    while ((signal >> id >> high >> low )&&(csvBased >> time >> lowSignal >> highSignal)) {
        
        
        string idS = to_string(id);
        string timeS  = to_string(time);
        string highS  = to_string(high);
        string highS2 = to_string(highSignal);
        string lowS  = to_string(low);
        
        timedSignal << idS << "\t" << timeS << "\t" << highS << "\n";
        
        
    }
    timedSignal.close();
}
