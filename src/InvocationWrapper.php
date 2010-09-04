<?php
/**
 * InvocationWrapper.php
 *
 * Holds the InvocationWrapper class
 *
 * PHP Version: PHP 5
 *
 * @category File
 * @package  PHPUnitHelper
 * @author   meza <meza@meza.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 * @link     http://www.meza.hu
 */

/**
 * Wraps an instance of PHPUnit_Framework_MockObject_Invocation to provide a way
 * to intercept calls to its toString() method which would indirectly cause
 * out of memory errors when any of the actual parameters of the invocation
 * represented
 * by the wrapped object is too complex to simply print_r() them.
 *
 * @category Class
 * @package  Testhelper
 *
 * @author   fqqdk <fqqdk@clusterone.hu>
 * @license  GPL3.0
 *                    GNU GENERAL PUBLIC LICENSE
 *                       Version 3, 29 June 2007
 *
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * Everyone is permitted to copy and distribute verbatim copies
 * of this license document, but changing it is not allowed.
 * @link     http://www.assembla.com/spaces/p-pex
 */
class InvocationWrapper extends PHPUnit_Framework_MockObject_Invocation
{

    /**
     * @var mixed the object
     */
    public $object;

    /**
     * @var string the class name
     */
    public $className;

    /**
     * @var string the name of the method
     */
    public $methodName;

    /**
     * @var array the actual parameters of the invocation
     */
    public $parameters;


    /**
     * Constructor
     *
     * @param PHPUnit_Framework_MockObject_Invocation $delegate the object to wrap
     *
     * @return InvocationWrapper
     */
    public function __construct(PHPUnit_Framework_MockObject_Invocation $delegate)
    {
        $this->object     = $delegate->object;
        $this->className  = $delegate->className;
        $this->methodName = $delegate->methodName;
        $this->parameters = $delegate->parameters;

    }//end __construct()


    /**
     * Prints a SHORT, human readable summary of the invocation.
     *
     * @return string
     */
    public function toString()
    {
        return sprintf(
            '%s::%s(%s)',
            $this->className,
            $this->methodName,
            join(
                ', ',
                array_map(
                    array(
                     $this,
                     'shortenedExport',
                    ),
                    $this->parameters
                )
            )
        );

    }//end toString()


    /**
     * Copypasted and amended version of PHPUnit_Util_Type::shortenedExport()
     * In this version, every call to PHPUnit_Util_Type::toString() is called
     * with true passed to second parameter ($short) which PHPUnit's version of this
     * method does not do.
     *
     * @param mixed $variable the variable to output
     *
     * @return string
     */
    public function shortenedExport($variable)
    {
        if (true === is_string($variable)) {
            return PHPUnit_Util_Type::shortenedString($variable);
        } else if (true === is_array($variable)) {
            return $this->_shortenedExportArray($variable);
        } else if (true === is_object($variable)) {
            return get_class($variable).'(...)';
        }

        return PHPUnit_Util_Type::toString($variable, true);

    }//end shortenedExport()


    /**
     * Exports an array variable
     *
     * @param array $variable the variable to export
     *
     * @return string
     */
    private function _shortenedExportArray(array $variable)
    {
        if (count($variable) === 0) {
            return 'array()';
        }

        $a1 = array_slice($variable, 0, 1, true);
        $k1 = key($a1);
        $v1 = $a1[$k1];

        if (true === is_string($v1)) {
            $v1 = PHPUnit_Util_Type::shortenedString($v1);
        } else if (true === is_array($v1)) {
            $v1 = 'array(...)';
        } else {
            $v1 = PHPUnit_Util_Type::toString($v1, true);
        }

        $a2 = false;

        if (count($variable) > 1) {
            $a2 = array_slice($variable, -1, 1, true);
            $k2 = key($a2);
            $v2 = $a2[$k2];

            if (true === is_string($v2)) {
                $v2 = PHPUnit_Util_Type::shortenedString($v2);
            } else if (true === is_array($v2)) {
                $v2 = 'array(...)';
            } else {
                $v2 = PHPUnit_Util_Type::toString($v2, true);
            }
        }

        $text = 'array( '.PHPUnit_Util_Type::toString($k1, true).' => '.$v1;

        if ($a2 !== false) {
            $text .= ', ..., '.PHPUnit_Util_Type::toString(
                $k2,
                true
            ).' => '.$v2.' )';
        } else {
            $text .= ' )';
        }

        return $text;

    }//end _shortenedExportArray()


}//end class

?>