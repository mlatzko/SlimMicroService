<?php

class TestActionRead
    extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->config  = $this->getMockBuilder('\Noodlehaus\ConfigInterface')->getMock();
        $this->logger  = $this->getMockBuilder('\Psr\Log\LoggerInterface')->getMock();
        $this->adapter = $this->getMockBuilder('\SlimMicroService\Adapter\AdapterInterface')->getMock();

        $this->request  = $this->getMockBuilder('\Slim\Http\Request')->disableOriginalConstructor()->getMock();
        $this->response = $this->getMockBuilder('\Slim\Http\Response')->disableOriginalConstructor()->getMock();

        $this->class = new \SlimMicroService\Action\ActionRead($this->config, $this->logger, $this->adapter);
    }

    public function testMethodDispatchNotFoundBehavior()
    {
        $responseData = array(
            'status'  => 'error',
            'content' => 'Resource not found.'
        );

        $this->adapter
            ->expects($this->once())
            ->method('read')
            ->with('example', '0')
            ->will($this->returnValue(NULL));

        $this->response
            ->expects($this->once())
            ->method('withJson')
            ->with($responseData, 404);

        $this->class->dispatch(
            $this->request,
            $this->response,
            array('resource' => 'example', 'id' => '0')
        );
    }

    public function testMethodDispatchFoundBehavior()
    {
        $enityData = array('id' => '0', 'name' => 'example');

        $responseData = array(
            'status'  => 'ok',
            'content' => $enityData
        );

        $this->adapter
            ->expects($this->once())
            ->method('read')
            ->with('example', '0')
            ->will($this->returnValue($enityData));

        $this->response
            ->expects($this->once())
            ->method('withJson')
            ->with($responseData, 200);

        $this->class->dispatch(
            $this->request,
            $this->response,
            array('resource' => 'example', 'id' => '0')
        );
    }
}
