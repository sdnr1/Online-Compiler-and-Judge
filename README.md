# Online-Judge

This is a simple online jugde built for small scale usage. The judge is designed for C/C++, and can be easily adapted for any programming language.

**Features**

* Compiles code and executes it for a sample input.
* Output generated can be compared with a sample output, so as to judge the program.
* Time limits can be imposed on the programs. The judge reports "Time Limit Exceeded" if program execution does not complete within provided time limit.
* Capable reporting compilation and runtime errors verbosely.

**Requirements**

* PHP 4 or above
* C/C++ Compiler must be installed in host machine (or any compiler for the desired programming language). Path to the compiler must be present in the PATH variable of the system. Alternatively, the path to the compiler can be provided in the code (this may not work always).
