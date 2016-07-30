# Online-Judge

This is a simple and easy to use online jugde built for small scale usage. The judge is designed for C/C++, and can be easily adapted for any programming language.

**Features**

* Compiles code and executes it for a sample input.
* Allows user defined output validation software to be used to judge the ouptut of the program. The judge includes a default output checker, which compares the program generated output to a sample output.
* Time limits can be imposed on the programs. The judge reports "Time Limit Exceeded" if program execution does not complete within provided time limit.
* Capable reporting compilation and runtime errors verbosely.

**Requirements**

* PHP 4 or above
* C/C++ Compiler must be installed in host machine (or any compiler for the desired programming language). Path to the compiler must be present in the PATH variable of the system. Alternatively, the path to the compiler can be provided in the code (this may not work always).
