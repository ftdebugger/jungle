<?php

namespace Jungle\Example;

class Calculator
{

    /**
     * Syntax analyse action table
     */
    protected $action = array(0=>array(7=>array(0=>0,1=>1,),8=>array(0=>0,1=>2,),9=>array(0=>0,1=>3,),10=>array(0=>0,1=>4,),0=>array(0=>0,1=>5,),1=>array(0=>0,1=>6,),),1=>array(11=>array(0=>2,),),2=>array(5=>array(0=>0,1=>7,),6=>array(0=>0,1=>8,),11=>array(0=>1,1=>0,2=>1,3=>7,),),3=>array(3=>array(0=>0,1=>9,),4=>array(0=>0,1=>10,),11=>array(0=>1,1=>0,2=>1,3=>8,),5=>array(0=>1,1=>0,2=>1,3=>8,),6=>array(0=>1,1=>0,2=>1,3=>8,),2=>array(0=>1,1=>0,2=>1,3=>8,),),4=>array(11=>array(0=>1,1=>0,2=>1,3=>9,),5=>array(0=>1,1=>0,2=>1,3=>9,),6=>array(0=>1,1=>0,2=>1,3=>9,),2=>array(0=>1,1=>0,2=>1,3=>9,),3=>array(0=>1,1=>0,2=>1,3=>9,),4=>array(0=>1,1=>0,2=>1,3=>9,),),5=>array(11=>array(0=>1,1=>1,2=>1,3=>10,),5=>array(0=>1,1=>1,2=>1,3=>10,),6=>array(0=>1,1=>1,2=>1,3=>10,),2=>array(0=>1,1=>1,2=>1,3=>10,),3=>array(0=>1,1=>1,2=>1,3=>10,),4=>array(0=>1,1=>1,2=>1,3=>10,),),6=>array(8=>array(0=>0,1=>11,),9=>array(0=>0,1=>3,),10=>array(0=>0,1=>4,),0=>array(0=>0,1=>5,),1=>array(0=>0,1=>6,),),7=>array(9=>array(0=>0,1=>12,),10=>array(0=>0,1=>4,),0=>array(0=>0,1=>5,),1=>array(0=>0,1=>6,),),8=>array(9=>array(0=>0,1=>13,),10=>array(0=>0,1=>4,),0=>array(0=>0,1=>5,),1=>array(0=>0,1=>6,),),9=>array(10=>array(0=>0,1=>14,),0=>array(0=>0,1=>5,),1=>array(0=>0,1=>6,),),10=>array(10=>array(0=>0,1=>15,),0=>array(0=>0,1=>5,),1=>array(0=>0,1=>6,),),11=>array(2=>array(0=>0,1=>16,),5=>array(0=>0,1=>7,),6=>array(0=>0,1=>8,),),12=>array(3=>array(0=>0,1=>9,),4=>array(0=>0,1=>10,),11=>array(0=>1,1=>2,2=>3,3=>8,),5=>array(0=>1,1=>2,2=>3,3=>8,),6=>array(0=>1,1=>2,2=>3,3=>8,),2=>array(0=>1,1=>2,2=>3,3=>8,),),13=>array(3=>array(0=>0,1=>9,),4=>array(0=>0,1=>10,),11=>array(0=>1,1=>3,2=>3,3=>8,),5=>array(0=>1,1=>3,2=>3,3=>8,),6=>array(0=>1,1=>3,2=>3,3=>8,),2=>array(0=>1,1=>3,2=>3,3=>8,),),14=>array(11=>array(0=>1,1=>4,2=>3,3=>9,),5=>array(0=>1,1=>4,2=>3,3=>9,),6=>array(0=>1,1=>4,2=>3,3=>9,),2=>array(0=>1,1=>4,2=>3,3=>9,),3=>array(0=>1,1=>4,2=>3,3=>9,),4=>array(0=>1,1=>4,2=>3,3=>9,),),15=>array(11=>array(0=>1,1=>5,2=>3,3=>9,),5=>array(0=>1,1=>5,2=>3,3=>9,),6=>array(0=>1,1=>5,2=>3,3=>9,),2=>array(0=>1,1=>5,2=>3,3=>9,),3=>array(0=>1,1=>5,2=>3,3=>9,),4=>array(0=>1,1=>5,2=>3,3=>9,),),16=>array(11=>array(0=>1,1=>6,2=>3,3=>10,),5=>array(0=>1,1=>6,2=>3,3=>10,),6=>array(0=>1,1=>6,2=>3,3=>10,),2=>array(0=>1,1=>6,2=>3,3=>10,),3=>array(0=>1,1=>6,2=>3,3=>10,),4=>array(0=>1,1=>6,2=>3,3=>10,),),);

    /**
     * Tokens stack
     *
     * @var \SplStack
     */
    protected $stack = null;

    public function parse($data)
    {
        $tokens = $this->tokenizer($data);
        $this->stack = new \SplStack();
        $this->stack->push(0);

        while (true) {
            $token = $tokens[0];
            $state = $this->stack->top();
            $terminal = $token[0];

            if (!isset($this->action[$state][$terminal])) {
                throw new \Exception('Token not allowed here (' . $token[1] . ')');
            }

            $action = $this->action[$state][$terminal];
            if ($action[0] === 0) {
                $this->stack->push($token[1]);
                $this->stack->push($action[1]);
                array_shift($tokens);
            } elseif ($action[0] === 1) {
                $value = $this->reduce($action[2], $action[1]);
                array_unshift($tokens, array($action[3], $value));
            } elseif ($action[0] === 2) {
                $this->stack->pop();
                return $this->stack->pop();
            } else {
                throw new \RuntimeException('Cannot compile');
            }
        }

        throw new \RuntimeException('Cannot compile. EOF');
    }

    public function tokenizer($data)
    {
        $tokens = [];
        while (strlen($data) !== 0) {
            $token = $this->getNextToken($data);
            $data = substr($data, strlen($token[1]));
            $tokens[] = $token;
        }
        $tokens[] = array(11, '');
        return $tokens;
    }

    public function getNextToken($data)
    {
        if (preg_match('/^[0-9]+/', $data, $match)) {
            return [0, $match[0]];
        }

        if ('(' === substr($data, 0, 1)) {
            return [1, '('];
        }

        if (')' === substr($data, 0, 1)) {
            return [2, ')'];
        }

        if ('*' === substr($data, 0, 1)) {
            return [3, '*'];
        }

        if ('/' === substr($data, 0, 1)) {
            return [4, '/'];
        }

        if ('+' === substr($data, 0, 1)) {
            return [5, '+'];
        }

        if ('-' === substr($data, 0, 1)) {
            return [6, '-'];
        }

        throw new \Exception("Syntax error");
    }

    protected function reduce($count, $index)
    {
        $args = array();
        for ($i = 0; $i < $count; $i++) {
            $this->stack->pop();
            $args[] = $this->stack->pop();
        }

        return call_user_func_array([$this, 'reduce' . $index], array_reverse($args));
    }

    protected function reduce0($a = null)
    {
        $returnValue = $a;
        return $returnValue;
    }

    protected function reduce1($a = null)
    {
        $returnValue = (float)$a;
        return $returnValue;
    }

    protected function reduce2($a = null, $b = null, $c = null)
    {
        $returnValue = $a + $c;
        return $returnValue;
    }

    protected function reduce3($a = null, $b = null, $c = null)
    {
        $returnValue = $a - $c;
        return $returnValue;
    }

    protected function reduce4($a = null, $b = null, $c = null)
    {
        $returnValue = $a * $c;
        return $returnValue;
    }

    protected function reduce5($a = null, $b = null, $c = null)
    {
        $returnValue = $a / $c;
        return $returnValue;
    }

    protected function reduce6($a = null, $b = null)
    {
        $returnValue = $b;
        return $returnValue;
    }


}
