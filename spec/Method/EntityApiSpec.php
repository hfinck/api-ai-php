<?php

namespace spec\ApiAi\Method;

use ApiAi\Client;
use ApiAi\Method\EntityApi;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EntityApiSpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EntityApi::class);
    }
}
