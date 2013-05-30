<?php

namespace Jungle\Example;

class Json
{

    /**
     * Syntax analyse action table
     */
    protected $action = array(0=>array(12=>array(0=>0,1=>1,),13=>array(0=>0,1=>2,),0=>array(0=>0,1=>3,),),1=>array(14=>array(0=>2,),),2=>array(14=>array(0=>1,1=>0,2=>1,3=>12,),),3=>array(15=>array(0=>0,1=>4,),11=>array(0=>0,1=>5,),16=>array(0=>0,1=>6,),17=>array(0=>0,1=>7,),2=>array(0=>0,1=>8,),),4=>array(11=>array(0=>0,1=>9,),1=>array(0=>0,1=>10,),),5=>array(14=>array(0=>1,1=>1,2=>2,3=>13,),11=>array(0=>1,1=>1,2=>2,3=>13,),1=>array(0=>1,1=>1,2=>2,3=>13,),8=>array(0=>1,1=>1,2=>2,3=>13,),),6=>array(11=>array(0=>1,1=>0,2=>1,3=>15,),1=>array(0=>1,1=>0,2=>1,3=>15,),),7=>array(6=>array(0=>0,1=>11,),),8=>array(18=>array(0=>0,1=>12,),5=>array(0=>0,1=>13,),2=>array(0=>1,1=>0,2=>0,3=>18,),3=>array(0=>1,1=>0,2=>0,3=>18,),4=>array(0=>1,1=>0,2=>0,3=>18,),),9=>array(14=>array(0=>1,1=>2,2=>3,3=>13,),11=>array(0=>1,1=>2,2=>3,3=>13,),1=>array(0=>1,1=>2,2=>3,3=>13,),8=>array(0=>1,1=>2,2=>3,3=>13,),),10=>array(16=>array(0=>0,1=>14,),17=>array(0=>0,1=>7,),2=>array(0=>0,1=>8,),),11=>array(19=>array(0=>0,1=>15,),20=>array(0=>0,1=>16,),13=>array(0=>0,1=>17,),9=>array(0=>0,1=>18,),10=>array(0=>0,1=>19,),17=>array(0=>0,1=>20,),7=>array(0=>0,1=>21,),0=>array(0=>0,1=>3,),2=>array(0=>0,1=>8,),),12=>array(2=>array(0=>0,1=>22,),3=>array(0=>0,1=>23,),4=>array(0=>0,1=>24,),5=>array(0=>0,1=>25,),),13=>array(2=>array(0=>1,1=>0,2=>1,3=>18,),3=>array(0=>1,1=>0,2=>1,3=>18,),4=>array(0=>1,1=>0,2=>1,3=>18,),5=>array(0=>1,1=>0,2=>1,3=>18,),),14=>array(11=>array(0=>1,1=>3,2=>3,3=>15,),1=>array(0=>1,1=>3,2=>3,3=>15,),),15=>array(11=>array(0=>1,1=>4,2=>3,3=>16,),1=>array(0=>1,1=>4,2=>3,3=>16,),),16=>array(11=>array(0=>1,1=>0,2=>1,3=>19,),1=>array(0=>1,1=>0,2=>1,3=>19,),8=>array(0=>1,1=>0,2=>1,3=>19,),),17=>array(11=>array(0=>1,1=>0,2=>1,3=>19,),1=>array(0=>1,1=>0,2=>1,3=>19,),8=>array(0=>1,1=>0,2=>1,3=>19,),),18=>array(11=>array(0=>1,1=>5,2=>1,3=>19,),1=>array(0=>1,1=>5,2=>1,3=>19,),8=>array(0=>1,1=>5,2=>1,3=>19,),),19=>array(11=>array(0=>1,1=>6,2=>1,3=>19,),1=>array(0=>1,1=>6,2=>1,3=>19,),8=>array(0=>1,1=>6,2=>1,3=>19,),),20=>array(11=>array(0=>1,1=>0,2=>1,3=>19,),1=>array(0=>1,1=>0,2=>1,3=>19,),8=>array(0=>1,1=>0,2=>1,3=>19,),),21=>array(21=>array(0=>0,1=>26,),19=>array(0=>0,1=>27,),20=>array(0=>0,1=>16,),13=>array(0=>0,1=>17,),9=>array(0=>0,1=>18,),10=>array(0=>0,1=>19,),17=>array(0=>0,1=>20,),7=>array(0=>0,1=>21,),0=>array(0=>0,1=>3,),2=>array(0=>0,1=>8,),),22=>array(6=>array(0=>1,1=>2,2=>3,3=>17,),11=>array(0=>1,1=>2,2=>3,3=>17,),1=>array(0=>1,1=>2,2=>3,3=>17,),8=>array(0=>1,1=>2,2=>3,3=>17,),),23=>array(18=>array(0=>0,1=>28,),5=>array(0=>0,1=>13,),2=>array(0=>1,1=>0,2=>0,3=>18,),3=>array(0=>1,1=>0,2=>0,3=>18,),4=>array(0=>1,1=>0,2=>0,3=>18,),),24=>array(18=>array(0=>0,1=>29,),5=>array(0=>0,1=>13,),2=>array(0=>1,1=>0,2=>0,3=>18,),3=>array(0=>1,1=>0,2=>0,3=>18,),4=>array(0=>1,1=>0,2=>0,3=>18,),),25=>array(2=>array(0=>1,1=>7,2=>2,3=>18,),3=>array(0=>1,1=>7,2=>2,3=>18,),4=>array(0=>1,1=>7,2=>2,3=>18,),5=>array(0=>1,1=>7,2=>2,3=>18,),),26=>array(8=>array(0=>0,1=>30,),1=>array(0=>0,1=>31,),),27=>array(8=>array(0=>1,1=>8,2=>1,3=>21,),1=>array(0=>1,1=>8,2=>1,3=>21,),),28=>array(3=>array(0=>0,1=>23,),4=>array(0=>0,1=>24,),5=>array(0=>0,1=>25,),2=>array(0=>1,1=>9,2=>3,3=>18,),),29=>array(3=>array(0=>0,1=>23,),4=>array(0=>0,1=>24,),5=>array(0=>0,1=>25,),2=>array(0=>1,1=>10,2=>3,3=>18,),),30=>array(11=>array(0=>1,1=>2,2=>3,3=>20,),1=>array(0=>1,1=>2,2=>3,3=>20,),8=>array(0=>1,1=>2,2=>3,3=>20,),),31=>array(19=>array(0=>0,1=>32,),20=>array(0=>0,1=>16,),13=>array(0=>0,1=>17,),9=>array(0=>0,1=>18,),10=>array(0=>0,1=>19,),17=>array(0=>0,1=>20,),7=>array(0=>0,1=>21,),0=>array(0=>0,1=>3,),2=>array(0=>0,1=>8,),),32=>array(8=>array(0=>1,1=>11,2=>3,3=>21,),1=>array(0=>1,1=>11,2=>3,3=>21,),),);

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
        $tokens[] = array(14, '');
        return $tokens;
    }

    public function getNextToken($data)
    {
        if ('[' === substr($data, 0, 1)) {
            return [7, '['];
        }

        if (']' === substr($data, 0, 1)) {
            return [8, ']'];
        }

        if (preg_match('/^(true|false)/i', $data, $match)) {
            return [9, $match[0]];
        }

        if (preg_match('/^[0-9]+(\\.\\d+|e\\d+)?/', $data, $match)) {
            return [10, $match[0]];
        }

        if (':' === substr($data, 0, 1)) {
            return [6, ':'];
        }

        if ('{' === substr($data, 0, 1)) {
            return [0, '{'];
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

        if ('\\\\' === substr($data, 0, 2)) {
            return [4, '\\\\'];
        }

        if ('}' === substr($data, 0, 1)) {
            return [11, '}'];
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
        $returnValue = strtolower($a) == 'true';
        return $returnValue;
    }

    protected function reduce6($a = null)
    {
        $returnValue = (float)$a;
        return $returnValue;
    }

    protected function reduce7($a = null, $b = null)
    {
        $returnValue = $a . $b;
        return $returnValue;
    }

    protected function reduce8($a = null)
    {
        $returnValue = array($a);
        return $returnValue;
    }

    protected function reduce9($a = null, $b = null, $c = null)
    {
        $returnValue = $a . '"' . $c;
        return $returnValue;
    }

    protected function reduce10($a = null, $b = null, $c = null)
    {
        $returnValue = $a . '\\' . $c;
        return $returnValue;
    }

    protected function reduce11($a = null, $b = null, $c = null)
    {
        $a[] = $c; $returnValue = $a;
        return $returnValue;
    }


}
