<?php
namespace Aura\SqlQuery;

abstract class AbstractAssertSql extends \PHPUnit_Framework_TestCase
{
    protected function assertSameSql($expect, $actual)
    {
        // remove leading and trailing whitespace per block and line
        $expect = trim($expect);
        $expect = preg_replace('/^[ \t]*/m', '', $expect);
        $expect = preg_replace('/[ \t]*$/m', '', $expect);

        // convert "<<" and ">>" to the correct identifier quotes
        $expect = $this->requoteIdentifiers($expect);

        // remove leading and trailing whitespace per block and line
        $actual = trim($actual);
        $actual = preg_replace('/^[ \t]*/m', '', $actual);
        $actual = preg_replace('/[ \t]*$/m', '', $actual);

        // normalize line endings to be sure tests will pass on windows and mac
        $expect = preg_replace('/\r\n|\n|\r/', PHP_EOL, $expect);
        $actual = preg_replace('/\r\n|\n|\r/', PHP_EOL, $actual);

        // are they the same now?
        $this->assertSame($expect, $actual);
    }

    protected function requoteIdentifiers($string)
    {
        $string = str_replace('<<', $this->query->getQuoteNamePrefix(), $string);
        $string = str_replace('>>', $this->query->getQuoteNameSuffix(), $string);
        return $string;
    }
}
