<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    LICENSE.txt
 * @date       5/30/13 17:54
 */

namespace Jungle\Code;

use Zend\Code\Generator\PropertyValueGenerator as ZendValueGenerator;

class PropertyValueGenerator extends ZendValueGenerator
{
    /**
     * @return string
     */
    public function generate()
    {
        if (is_array($this->getValue())) {
            $value = var_export($this->getValue(), true) . ';';
            return preg_replace("#\\s#Sm", '', $value);
        }

        return parent::generate() . ';';
    }
}