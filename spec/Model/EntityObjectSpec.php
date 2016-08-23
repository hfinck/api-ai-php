<?php

namespace spec\ApiAi\Model;

use ApiAi\Exception\EntityObjectException;
use ApiAi\Model\EntityObject;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EntityObjectSpec extends ObjectBehavior
{
    private $entityName = 'test_entity';

    function let()
    {
        $this->beConstructedWith($this->entityName);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EntityObject::class);
    }

    function it_should_throw_an_error_if_constructed_without_name()
    {
        $this->beConstructedWith(null);
        $this->shouldThrow(EntityObjectException::class)->duringInstantiation();
    }

    function it_should_return_its_name()
    {
        $this->getName()->shouldReturn($this->entityName);
    }

    function it_should_be_constructed_with_a_name()
    {
        $name = 'test_entity';
        $this->beConstructedWith($name);
        $this->getName()->shouldReturn($name);
    }

    function it_can_check_for_entries()
    {
        $this->hasEntry('LA')->shouldReturn(false);
    }

    function it_can_have_entries()
    {
        $this->setEntry('New York City', ['New York City', 'New York', 'NYC', 'NY']);
        $this->hasEntry('New York City')->shouldReturn(true);
    }

    function it_should_return_entries()
    {
        $value = 'Hamburg';
        $synonyms = ['Hamburg', 'HH'];

        $this->setEntry($value, $synonyms);

        $this->getEntry($value)->shouldBeLike([
            'value' => $value,
            'synonyms' => $synonyms
        ]);

        $this->getEntry(null)->shouldThrow(EntityObjectException::class);
    }

    function it_should_be_json_serializable()
    {
        $this->setEntry('Hamburg', ['Hamburg', 'HH']);

        $this->shouldImplement(\JsonSerializable::class);

        $arrayData = $this->getWrappedObject()->jsonSerialize();
        $json = json_encode($arrayData);

        $this->jsonSerialize()->shouldBeLike(json_decode($json, true));
    }
}
