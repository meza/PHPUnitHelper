<?php
/**
 * MockObjectWrapper.php
 *
 * Holds the MockObjectWrapper class
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
 * This class is used to wrap a PHPUnit_Framework_MockObject_MockObject instance
 * to provide a way to inject wrapped instances of InvocationMockerWrapper
 * to the PHPUnit_Framework_MockObject_Builder_InvocationMocker instance so that
 * after a call to expects() an amended expectation builder can be used by test
 * method that uses the wrapped mock object.
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
class MockObjectWrapper implements PHPUnit_Framework_MockObject_MockObject
{

    /**
     * @var PHPUnit_Framework_MockObject_MockObject the wrapped mock object
     */
    public $mock;


    /**
     * Constructor
     *
     * @param PHPUnit_Framework_MockObject_MockObject $mock the mock object to wrap
     *
     * @return MockObjectWrapper
     */
    public function __construct(PHPUnit_Framework_MockObject_MockObject $mock)
    {
        $this->mock = $mock;

    }//end __construct()


    /**
     * Uses the passed matcher to create an amended expectation builder to be
     * used by the test method that is the client of the wrapped mock object
     *
     * @param PHPUnit_Framework_MockObject_Matcher_Invocation $matcher the matcher
     *
     * @see PHPUnit_Framework_MockObject_MockObject::expects()
     * @see PHPUnit_Framework_MockObject_Matcher_Invocation
     *
     * @return PHPUnit_Framework_MockObject_Builder_InvocationMocker the amended
     *                                                               expectation
     *                                                               builder
     */
    public function expects(PHPUnit_Framework_MockObject_Matcher_Invocation $matcher)
    {
        $wrapper = new InvocationMockerWrapper(
            $this->mock->__phpunit_getInvocationMocker());
        $mocker  = new PHPUnit_Framework_MockObject_Builder_InvocationMocker(
            $wrapper,
            $matcher
        );
        return $mocker;

    }//end expects()


    /**
     * Simply delegates
     *
     * @return PHPUnit_Framework_MockObject_InvocationMocker
     */
    public function __phpunit_getInvocationMocker()
    {
        return $this->mock->__phpunit_getInvocationMocker();

    }//end __phpunit_getInvocationMocker()


    /**
     * Simply delegates
     *
     * @return void
     * @throws PHPUnit_Framework_ExpectationFailedException
     */
    public function __phpunit_verify() {
        return $this->mock->__phpunit_verify();

    }//end __phpunit_verify()


}//end class

?>