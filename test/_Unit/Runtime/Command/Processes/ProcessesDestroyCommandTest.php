<?php

namespace Kraken\_Unit\Runtime\Command\Processes;

use Kraken\_Unit\Runtime\Command\_T\TCommand;
use Kraken\Runtime\Command\Processes\ProcessesDestroyCommand;
use Dazzle\Throwable\Exception\Runtime\RejectionException;
use StdClass;

class ProcessesDestroyCommandTest extends TCommand
{
    /**
     * @var string
     */
    protected $class = ProcessesDestroyCommand::class;

    /**
     *
     */
    public function testApiCommand_InvokesProperAction()
    {
        $aliases = [ 'alias1', 'alias2' ];
        $flags   = 0;
        $result  = new StdClass;

        $command = $this->createCommand();
        $manager = $this->createManager();
        $manager
            ->expects($this->once())
            ->method('destroyProcesses')
            ->with($aliases, $flags)
            ->will($this->returnValue($result));

        $this->assertSame(
            $result,
            $this->callProtectedMethod(
                $command, 'command', [[ 'aliases' => $aliases, 'flags' => $flags ]]
            )
        );
    }

    /**
     *
     */
    public function testApiCommand_ThrowsException_WhenContextParamAliasesDoesNotExist()
    {
        $this->setExpectedException(RejectionException::class);
        $command = $this->createCommand();

        $this->callProtectedMethod($command, 'command', [[ 'flags' => 0 ]]);
    }

    /**
     *
     */
    public function testApiCommand_ThrowsException_WhenContextParamFlagsDoesNotExist()
    {
        $this->setExpectedException(RejectionException::class);
        $command = $this->createCommand();

        $this->callProtectedMethod($command, 'command', [[ 'aliases' => [] ]]);
    }
}
