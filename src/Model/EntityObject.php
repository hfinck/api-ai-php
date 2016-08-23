<?php
/**
 * @author Hannes Finck <finck.hannes@gmail.com>
 */

namespace ApiAi\Model;


use ApiAi\Exception\EntityObjectException;

/**
 * Class EntityObject
 * @package ApiAi\Model
 */
class EntityObject implements \JsonSerializable
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @var array $entries
     */
    private $entries = [];

    /**
     * EntityObject constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        if (!is_string($name) || empty($name)) {
            throw new EntityObjectException('Name must be a string and cannot be empty.');
        }

        $this->name = $name;
    }

    /**
     * Return the name of the EntityObject.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return synonyms of a value.
     *
     * @param string $value
     * @return mixed
     */
    public function getSynonyms($value)
    {
        return $this->hasEntry($value) ? $this->entries[$value] : [];
    }

    /**
     * Set an entry value including synonyms.
     *
     * @param string $value
     * @param string[] $synonyms
     *
     * @return $this
     */
    public function setEntry($value, $synonyms = [])
    {
        if (!is_string($value) || empty($value)) {
            throw new EntityObjectException('Entry value must be a string and cannot be empty.');
        }

        $this->entries[$value] = $synonyms;

        return $this;
    }

    public function getEntry($value)
    {
        $result = null;

        if ($this->hasEntry($value)) {
            $result = [
                'value' => $value,
                'synonyms' => $this->getSynonyms($value)
            ];
        }

        return $result;
    }

    /**
     * Check if a an entity entry exists. It is only checked for value, not synonyms.
     *
     * @param string $name
     * @return bool
     */
    public function hasEntry($name)
    {
        return isset($this->entries[$name]);
    }

    /**
     * {@inheritdoc}
     */
    function jsonSerialize()
    {
        $entries = array_map(function ($value, $synonyms) {
            return [
                'value' => $value,
                'synonyms' => $synonyms
            ];
        }, array_keys($this->entries), $this->entries);

        return [
            'name' => $this->name,
            'entries' => $entries
        ];
    }
}