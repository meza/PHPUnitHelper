<?php
/**
 * Holds the classes needed to amend PHPUnit's awkward memory-hogging behaviour,
 * namely that it tries to dump all the actual parameters of a mocked method
 * using print_r() when an expectation for said method has not been met.
 * This behaviour causes OutOfMemory errors when an object with a large recursive
 * structure is among said actual parameters, like e.g. an Exception with a huge
 * stack trace. Who would have thought, that Exceptions, like any other objects
 * could be passed around? And that stack traces of these Exceptions could become
 * HUGE because they are usually invoked from a test, with HUGE,
 * HEAVILY RECURSIVE objects like other mock objects are all around?
 *
 * PHP version: 5.2
 *
 * @category File
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

/**
 * This class is used to wrap a PHPUnit_Framework_MockObject_InvocationMocker
 * instance to provide a way to inject wrapped instances of
 * PHPUnit_Framework_MockObject_Matcher_Invocation to it.
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
class InvocationMockerWrapper
implements PHPUnit_Framework_MockObject_Stub_MatcherCollection
{

    /**
     * @var PHPUnit_Framework_MockObject_InvocationMocker the wrapped object
     */
    private $_delegate;


    /**
     * Constructor
     *
     * @param PHPUnit_Framework_MockObject_InvocationMocker $delegate the object
     *                                                                to wrap
     *
     * @return InvocationMockerWrapper
     */
    public function __construct(
        PHPUnit_Framework_MockObject_InvocationMocker $delegate
    ) {
        $this->_delegate = $delegate;

    }//end __construct()


    /**
     * Wraps the passed matcher instance in a MatcherWrapper and passes it to
     * the delegate
     *
     * @param PHPUnit_Framework_MockObject_Matcher_Invocation $matcher the
     * matcher to wrap
     *
     * @return void
     */
    public function addMatcher(
        PHPUnit_Framework_MockObject_Matcher_Invocation $matcher
    ) {
        $newMatcher = new MatcherWrapper($matcher);
        $this->_delegate->addMatcher($newMatcher);

    }//end addMatcher()


}//end class

?>