<?php

namespace Jungle\Example;

class Json
{

    /**
     * Syntax analyse action table
     */
    protected $action = array(0=>array(11=>array(0=>0,1=>1,),12=>array(0=>0,1=>2,),0=>array(0=>0,1=>3,),),1=>array(13=>array(0=>2,),),2=>array(13=>array(0=>1,1=>0,2=>1,3=>11,),),3=>array(14=>array(0=>0,1=>4,),10=>array(0=>0,1=>5,),15=>array(0=>0,1=>6,),16=>array(0=>0,1=>7,),2=>array(0=>0,1=>8,),),4=>array(10=>array(0=>0,1=>9,),1=>array(0=>0,1=>10,),),5=>array(13=>array(0=>1,1=>1,2=>2,3=>12,),10=>array(0=>1,1=>1,2=>2,3=>12,),1=>array(0=>1,1=>1,2=>2,3=>12,),8=>array(0=>1,1=>1,2=>2,3=>12,),),6=>array(10=>array(0=>1,1=>0,2=>1,3=>14,),1=>array(0=>1,1=>0,2=>1,3=>14,),),7=>array(6=>array(0=>0,1=>11,),),8=>array(17=>array(0=>0,1=>12,),5=>array(0=>0,1=>13,),2=>array(0=>1,1=>0,2=>0,3=>17,),3=>array(0=>1,1=>0,2=>0,3=>17,),4=>array(0=>1,1=>0,2=>0,3=>17,),),9=>array(13=>array(0=>1,1=>2,2=>3,3=>12,),10=>array(0=>1,1=>2,2=>3,3=>12,),1=>array(0=>1,1=>2,2=>3,3=>12,),8=>array(0=>1,1=>2,2=>3,3=>12,),),10=>array(15=>array(0=>0,1=>14,),16=>array(0=>0,1=>7,),2=>array(0=>0,1=>8,),),11=>array(18=>array(0=>0,1=>15,),19=>array(0=>0,1=>16,),12=>array(0=>0,1=>17,),9=>array(0=>0,1=>18,),16=>array(0=>0,1=>19,),7=>array(0=>0,1=>20,),0=>array(0=>0,1=>3,),2=>array(0=>0,1=>8,),),12=>array(2=>array(0=>0,1=>21,),3=>array(0=>0,1=>22,),4=>array(0=>0,1=>23,),5=>array(0=>0,1=>24,),),13=>array(2=>array(0=>1,1=>0,2=>1,3=>17,),3=>array(0=>1,1=>0,2=>1,3=>17,),4=>array(0=>1,1=>0,2=>1,3=>17,),5=>array(0=>1,1=>0,2=>1,3=>17,),),14=>array(10=>array(0=>1,1=>3,2=>3,3=>14,),1=>array(0=>1,1=>3,2=>3,3=>14,),),15=>array(10=>array(0=>1,1=>4,2=>3,3=>15,),1=>array(0=>1,1=>4,2=>3,3=>15,),),16=>array(10=>array(0=>1,1=>0,2=>1,3=>18,),1=>array(0=>1,1=>0,2=>1,3=>18,),8=>array(0=>1,1=>0,2=>1,3=>18,),),17=>array(10=>array(0=>1,1=>0,2=>1,3=>18,),1=>array(0=>1,1=>0,2=>1,3=>18,),8=>array(0=>1,1=>0,2=>1,3=>18,),),18=>array(10=>array(0=>1,1=>5,2=>1,3=>18,),1=>array(0=>1,1=>5,2=>1,3=>18,),8=>array(0=>1,1=>5,2=>1,3=>18,),),19=>array(10=>array(0=>1,1=>0,2=>1,3=>18,),1=>array(0=>1,1=>0,2=>1,3=>18,),8=>array(0=>1,1=>0,2=>1,3=>18,),),20=>array(20=>array(0=>0,1=>25,),18=>array(0=>0,1=>26,),19=>array(0=>0,1=>16,),12=>array(0=>0,1=>17,),9=>array(0=>0,1=>18,),16=>array(0=>0,1=>19,),7=>array(0=>0,1=>20,),0=>array(0=>0,1=>3,),2=>array(0=>0,1=>8,),),21=>array(6=>array(0=>1,1=>2,2=>3,3=>16,),10=>array(0=>1,1=>2,2=>3,3=>16,),1=>array(0=>1,1=>2,2=>3,3=>16,),8=>array(0=>1,1=>2,2=>3,3=>16,),),22=>array(17=>array(0=>0,1=>27,),5=>array(0=>0,1=>13,),2=>array(0=>1,1=>0,2=>0,3=>17,),3=>array(0=>1,1=>0,2=>0,3=>17,),4=>array(0=>1,1=>0,2=>0,3=>17,),),23=>array(17=>array(0=>0,1=>28,),5=>array(0=>0,1=>13,),2=>array(0=>1,1=>0,2=>0,3=>17,),3=>array(0=>1,1=>0,2=>0,3=>17,),4=>array(0=>1,1=>0,2=>0,3=>17,),),24=>array(2=>array(0=>1,1=>6,2=>2,3=>17,),3=>array(0=>1,1=>6,2=>2,3=>17,),4=>array(0=>1,1=>6,2=>2,3=>17,),5=>array(0=>1,1=>6,2=>2,3=>17,),),25=>array(8=>array(0=>0,1=>29,),1=>array(0=>0,1=>30,),),26=>array(8=>array(0=>1,1=>7,2=>1,3=>20,),1=>array(0=>1,1=>7,2=>1,3=>20,),),27=>array(3=>array(0=>0,1=>22,),4=>array(0=>0,1=>23,),5=>array(0=>0,1=>24,),2=>array(0=>1,1=>8,2=>3,3=>17,),),28=>array(3=>array(0=>0,1=>22,),4=>array(0=>0,1=>23,),5=>array(0=>0,1=>24,),2=>array(0=>1,1=>9,2=>3,3=>17,),),29=>array(10=>array(0=>1,1=>2,2=>3,3=>19,),1=>array(0=>1,1=>2,2=>3,3=>19,),8=>array(0=>1,1=>2,2=>3,3=>19,),),30=>array(18=>array(0=>0,1=>31,),19=>array(0=>0,1=>16,),12=>array(0=>0,1=>17,),9=>array(0=>0,1=>18,),16=>array(0=>0,1=>19,),7=>array(0=>0,1=>20,),0=>array(0=>0,1=>3,),2=>array(0=>0,1=>8,),),31=>array(8=>array(0=>1,1=>10,2=>3,3=>20,),1=>array(0=>1,1=>10,2=>3,3=>20,),),);

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
            $data = trim(substr($data, strlen($token[1])));
            $tokens[] = $token;
        }
        $tokens[] = array(13, '');
        return $tokens;
    }

    public function getNextToken($data)
    {
        if (':' === substr($data, 0, 1)) {
            return [6, ':'];
        }

        if ('[' === substr($data, 0, 1)) {
            return [7, '['];
        }

        if (']' === substr($data, 0, 1)) {
            return [8, ']'];
        }

        if (preg_match('/^[0-9]+(\\.\\d+|e\\d+)?/', $data, $match)) {
            return [9, $match[0]];
        }

        if ('{' === substr($data, 0, 1)) {
            return [0, '{'];
        }

        if ('\\\\' === substr($data, 0, 2)) {
            return [4, '\\\\'];
        }

        if (',' === substr($data, 0, 1)) {
            return [1, ','];
        }

        if ('"' === substr($data, 0, 1)) {
            return [2, '"'];
        }

        if ('\\"' === substr($data, 0, 2)) {
            return [3, '\\"'];
        }

        if ('}' === substr($data, 0, 1)) {
            return [10, '}'];
        }

        if (preg_match('/^[^"\\\\][ ]*/', $data, $match)) {
            return [5, $match[0]];
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

    protected function reduce1()
    {
        $returnValue = array();
        return $returnValue;
    }

    protected function reduce2($a = null, $b = null)
    {
        $returnValue = $b;
        return $returnValue;
    }

    protected function reduce3($a = null, $b = null, $c = null)
    {
        $returnValue = array_merge($a, $c);
        return $returnValue;
    }

    protected function reduce4($a = null, $b = null, $c = null)
    {
        $returnValue = array($a => $c);
        return $returnValue;
    }

    protected function reduce5($a = null)
    {
        $returnValue = (float)$a;
        return $returnValue;
    }

    protected function reduce6($a = null, $b = null)
    {
        $returnValue = $a . $b;
        return $returnValue;
    }

    protected function reduce7($a = null)
    {
        $returnValue = array($a);
        return $returnValue;
    }

    protected function reduce8($a = null, $b = null, $c = null)
    {
        $returnValue = $a . '"' . $c;
        return $returnValue;
    }

    protected function reduce9($a = null, $b = null, $c = null)
    {
        $returnValue = $a . '\\' . $c;
        return $returnValue;
    }

    protected function reduce10($a = null, $b = null, $c = null)
    {
        $a[] = $c; $returnValue = $a;
        return $returnValue;
    }


}
