import sys
import os

cfile = open('cfile.c', 'w')
cppfile = open('cppfile.cpp', 'w')
pyfile = open('pyfile.py', 'w')
rbfile = open('rbfile.rb', 'w')
javafile = open('javafile.java', 'w')

forcfile = '''

#include <stdio.h>

int main() {
    printf("Hello World!\\n");
    return 0;
}

'''

forcppfile = '''
#include <iostream>
using namespace std;
int main() {
    cout << "Hello World!" << endl;
    return 0;
}
'''


forpyfile = 'print(\'Hello World!\')'
forrbfile = 'puts "Hello World!"'
forjavafile = '''
class HelloWorld {
    public static void main(String args[]) {
        System.out.println("Hello World!");
    }
}
'''

cfile.write(forcfile)
cppfile.write(forcppfile)
pyfile.write(forpyfile)
rbfile.write(forrbfile)
javafile.write(forjavafile)

cfile.close()
cppfile.close()
pyfile.close()
rbfile.close()
javafile.close()

os.system('''

    g++ cfile.c -o cfile && ./cfile &&
    g++ cppfile.cpp -o cppfile && ./cppfile &&
    python3 pyfile.py &&
    ruby rbfile.rb &&
    javac javafile.java && java HelloWorld

''')
