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









int main() {
    
    
    ifstream data ("data.txt");
    
    
    
    

    
    double a , lineCounter = 0 , peakCounter=0;
    while (data >> a  ) {
      //  cout<<a<<endl;
        if (a>0) {peakCounter++;}
        lineCounter++;
        if (lineCounter==8000) {
            break;
        }
        
    }
    cout<<peakCounter<<endl;
    return 0;
}




