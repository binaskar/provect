
#include <string>
#include  <fstream>
#include <iostream>
#include <sstream>
using namespace std;

int main(int argc, char *argv[])
{
	//CString str3(argsv[1]);
	//char *re=argsv[1];
	//ifstream namef(name);
// check if there is more than one argument and use the second one
  //  (the first argument is the executable)
  if (argc > 1)
  {
    string arg1(argv[1]);
    string fileName=arg1+".txt";
    ifstream read((arg1+".txt").c_str());
    string data,qrs,result;
    read>>data>>qrs>>result;
    cout<<"You clicked "<<data<<" ttt"<<endl;
    // do stuff with arg1
  }

  // Or, copy all arguments into a container of strings
  //std::vector<std::string> allArgs(argv, argv + argc);
    
    
   return 0;

}
