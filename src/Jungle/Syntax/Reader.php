<?php
/**
 * @author Evgeny Shpilevsky <evgeny@shpilevsky.com>
 */

namespace Jungle\Syntax;


class Reader
{

    /**
     * @param string $path
     * @throws \RuntimeException
     *
     * @return array
     */
    public function parseFile($path)
    {
        if (!file_exists($path) || !is_readable($path)) {
            throw new \RuntimeException('Cannot read syntax file');
        }

        return $this->parse(file_get_contents($path));
    }

    /**
     * @param string $content
     *
     * @return array
     */
    public function parse($content)
    {
        $lines = explode(PHP_EOL, $content);
        return $this->parseLines($lines, 0);
    }

    /**
     * @param array $lines
     * @param int $indent
     *
     * @throws \RuntimeException
     * @return array
     */
    protected function parseLines(array &$lines, $indent)
    {
        $result = array();
        $name = null;

        while (count($lines)) {
            $line = $lines[0];
            if (trim($line) === '') {
                array_shift($lines);
                continue;
            }

            $lineIndent = $this->getIndent($line);

            if ($lineIndent == $indent) {
                $line = ltrim($line);
                if (preg_match("#^(?<name>[a-z0-9_-]+):$#i", trim($line), $match)) {
                    $name = $match['name'];
                }

                if (preg_match("#^(?<name>[a-z0-9_-]+):\\s*(?<value>.+)$#i", $line, $match)) {
                    $result[$match['name']] = $match['value'];
                }

                if ($line[0] == '-') {
                    $result[] = ltrim(substr($line, 1));
                }

                array_shift($lines);
                continue;
            }

            if ($lineIndent > $indent) {
                if ($name === null) {
                    throw new \RuntimeException('Parse error');
                }

                $result[$name] = $this->parseLines($lines, $lineIndent);
                $name = null;

                continue;
            }

            break;
        }

        return $result;
    }

    /**
     * @param string $line
     * @return int
     */
    protected function getIndent($line)
    {
        return strlen($line) - strlen(ltrim($line));
    }

}