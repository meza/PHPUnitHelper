<?php
/**
 * MatchWrapper.php
 *
 * Holds the MatchWrapper class
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
 * This class is used to wrap a
 * PHPUnit_Framework_MockObject_Matcher_Invocation instance
 * to provide a way to inject wrapped instances of
 * PHPUnit_Framework_MockObject_Invocation
 * to the wrapped object.
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
class MatcherWrapper implements PHPUnit_Framework_MockObject_Matcher_Invocation
{

    /**
     * @var PHPUnit_Framework_MockObject_Matcher_Invocation the wrapped matcher
     */
    private $_delegate;


    /**
     * Constructor
     *
     * @param PHPUnit_Framework_MockObject_Matcher_Invocation $delegate the
     * matcher to wrap
     *
     * @return MatcherWrapper
     */
    public function __construct(
        PHPUnit_Framework_MockObject_Matcher_Invocation $delegate
    ) {
        $this->_delegate = $delegate;

    }//end __construct()


    /**
     * This method is used to inject wrapped invocations (instances of
     * PHPUnit_Framework_MockObject_Invocation wrapped with InvocationWrapper)
     * to the delegate
     *
     * @param PHPUnit_Framework_MockObject_Invocation $invocation the invocation
     *
     * @override
     *
     * @return mixed
     */
    public function invoked(PHPUnit_Framework_MockObject_Invocation $invocation)
    {
        $wrapper = new InvocationWrapper($invocation);
        return $this->_delegate->invoked($wrapper);

    }//end invoked()


    /**
     * This method is used to inject wrapped invocations (instances of
     * PHPUnit_Framework_MockObject_Invocation wrapped with InvocationWrapper)
     * to the delegate
     *
     * @param PHPUnit_Framework_MockObject_Invocation $invocation the invocation
     *
     * @override
     *
     * @return bool
     */
    public function matches(PHPUnit_Framework_MockObject_Invocation $invocation)
    {
        $wrapper = new InvocationWrapper($invocation);
        return $this->_delegate->matches($wrapper);

    }//end matches()


    /**
     * Just a simple delegating method
     *
     * @return string
     */
    public function toString()
    {
        return $this->_delegate->toString();

    }//end toString()


    /**
     * Just a simple delegating method
     *
     * @return void
     */
    public function verify()
    {
        return $this->_delegate->verify();

    }//end verify()


}//end class

?>