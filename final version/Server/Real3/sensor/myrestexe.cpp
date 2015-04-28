#include <iostream>
#include <string>
using namespace std;

int main(int argc, char *argsv[])
{
	//string name= string(argsv[1]);
	//ifstream name(name);
	if(argc>1){
		cout<<"You clicked "<<argsv[1]<<" ttt"<<argsv[2]<<" ttt"<<argsv[3]<<endl;
	}else{
		cout<<"You clicked Error ttt"<<endl;
	}
    
   return 0;

}
