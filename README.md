Jungle
======

Jungle - is a SLR parser generator, which written on php and for php

Usage
=====

First of all, prepare `.jungle` file with your syntax. It's simillar to yaml file, but more simple

```
// jungle format not supported comments now,
// so this is fake comment

rules:
  global: // this is root rule, it specify what will be searching first of all
    - expression

  expression: // new line and char '-' tell about productions
    - component
    - expression + component {$$ = $1 + $3;} // { between braces php code }
    - expression - component {$$ = $1 - $3;} // '+' and '-' automaticly will be added to terminals as literal

  factor:
    - number { $$ = (float)$1; } // $1 means first token
    - ( expression ) { $$ = $2; } // $2 means the second, and $$ means return value

  component:
    - power
    - component * power {$$ = $1 * $3;}
    - component / power {$$ = $1 / $3;}

  power:
    - factor
    - power ^ factor {$$ = pow($1, $3);}

terminals:
  number: /^[0-9]+/ // /^I AM REGEXP/, if no /^/ specify - then it is string
```

when syntax file is ready, you can call

```
bin/jungle.php parse -o parser.php example/json/schema.jungle
```