<?php

class TestActionCreate
    extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->config    = $this->getMockBuilder('\Noodlehaus\ConfigInterface')->getMock();
        $this->logger    = $this->getMockBuilder('\Psr\Log\LoggerInterface')->getMock();
        $this->adapter   = $this->getMockBuilder('\SlimMicroService\Adapter')->getMock();
        $this->request   = $this->getMockBuilder('\Slim\Http\Request')->disableOriginalConstructor()->getMock();
        $this->response  = $this->getMockBuilder('\Slim\Http\Response')->disableOriginalConstructor()->getMock();
        $this->validator = $this->getMockBuilder('\SlimMicroService\Validation\Validator')->disableOriginalConstructor()->getMock();
        $this->provider  = $this->getMockBuilder('\Fuel\Validation\RuleProvider\FromArray')->disableOriginalConstructor()->getMock();
        $this->result    = $this->getMockBuilder('\Fuel\Validation\Result')->disableOriginalConstructor()->getMock();

        $this->class = new \SlimMicroService\Action\Create(
            $this->config,
            $this->logger,
            $this->adapter,
            $this->validator,
            $this->provider
        );
    }

    public function testMethodDispatchNoRequestDataProvidedBehavior()
    {
        $responseData = array(
            'status'  => 'error',
            'content' => 'No data provided.'
        );

        $this->request
            ->expects($this->once())
            ->method('getParsedBody')
            ->will($this->returnValue(NULL));

        $this->response
            ->expects($this->once())
            ->method('withJson')
            ->with($responseData, 400);

        $this->class->dispatch(
            $this->request,
            $this->response,
            array('resource' => 'example')
        );
    }

    public function testMethodDispatchValdationFailedBehavior()
    {
        $responseData = array(
            'status'  => 'error',
            'content' => array('lastname' => 'Field is required.')
        );

        $this->request
            ->expects($this->once())
            ->method('getParsedBody')
            ->will($this->returnValue(array('name' => 'example')));

        $this->adapter
            ->expects($this->once())
            ->method('getValidationRules')
            ->will($this->returnValue(array(
                'name' => array('required'),
                'lastname' => array('required')
            )));

        $this->provider
            ->expects($this->once())
            ->method('setData')
            ->will($this->returnValue($this->provider));

        $this->provider
            ->expects($this->once())
            ->method('populateValidator');

        $this->validator
            ->expects($this->once())
            ->method('run')
            ->with(array('name' => 'example'))
            ->will($this->returnValue($this->result));

        $this->result
            ->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(FALSE));

        $this->result
            ->expects($this->once())
            ->method('getErrors')
            ->will($this->returnValue(array('lastname' => 'Field is required.')));

        $this->response
            ->expects($this->once())
            ->method('withJson')
            ->with($responseData, 400);

        $this->class->dispatch(
            $this->request,
            $this->response,
            array('resource' => 'example')
        );
    }

    public function testMethodDispatchToManyFieldsBehavior()
    {
        $responseData = array(
            'status'  => 'error',
            'content' => 'Unsupported fields provided. Allowed Fields are: name, lastname'
        );

        $this->request
            ->expects($this->once())
            ->method('getParsedBody')
            ->will($this->returnValue(array('name' => 'example', 'notSupported' => true)));

        $this->adapter
            ->expects($this->once())
            ->method('getValidationRules')
            ->will($this->returnValue(array(
                'name' => array('required', 'maxLength' => 255),
                'lastname' => array('maxLength' => 255)
            )));

        $this->provider
            ->expects($this->once())
            ->method('setData')
            ->will($this->returnValue($this->provider));

        $this->provider
            ->expects($this->once())
            ->method('populateValidator');

        $this->validator
            ->expects($this->once())
            ->method('run')
            ->with(array('name' => 'example', 'notSupported' => true))
            ->will($this->returnValue($this->result));

        $this->result
            ->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(TRUE));

        $this->response
            ->expects($this->once())
            ->method('withJson')
            ->with($responseData, 400);

        $this->class->dispatch(
            $this->request,
            $this->response,
            array('resource' => 'example')
        );
    }

    public function testMethodDispatchResourceCreatedBehavior()
    {
        $responseData = array(
            'status'  => 'ok',
            'content' => '/example/1'
        );

        $this->request
            ->expects($this->once())
            ->method('getParsedBody')
            ->will($this->returnValue(array('name' => 'example')));

        $this->adapter
            ->expects($this->once())
            ->method('getValidationRules')
            ->will($this->returnValue(array(
                'name' => array('required'),
            )));

        $this->provider
            ->expects($this->once())
            ->method('setData')
            ->will($this->returnValue($this->provider));

        $this->provider
            ->expects($this->once())
            ->method('populateValidator');

        $this->validator
            ->expects($this->once())
            ->method('run')
            ->with(array('name' => 'example'))
            ->will($this->returnValue($this->result));

        $this->result
            ->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(TRUE));

        $this->adapter
            ->expects($this->once())
            ->method('create')
            ->with('example', array('name' => 'example'))
            ->will($this->returnValue(array('uri' => '/example/1')));

        $this->response
            ->expects($this->once())
            ->method('withJson')
            ->with($responseData, 201);

        $this->class->dispatch(
            $this->request,
            $this->response,
            array('resource' => 'example')
        );
    }
}
