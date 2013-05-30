<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/27/13 17:20
 */

namespace Jungle\Lexer;


class LexerFactory
{

    /**
     * @param string $name
     * @param string $value
     *
     * @return LexerInterface
     */
    public function getLexer($name, $value)
    {
        if (is_array($value)) {
            $lexer = $this->getLexer($name, $value['value']);
            $lexer->setWeight($value['weight']);

            return $lexer;
        }

        if ($value[0] == '/' && strlen($value) > 2) {
            return new Regexp($value, $name);
        }

        return new String($value, $name);
    }

}