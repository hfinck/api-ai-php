<?php
/**
 * @author Hannes Finck <finck.hannes@gmail.com>
 */

namespace ApiAi\Method;


use ApiAi\Client;
use ApiAi\Model\EntityObject;
use ApiAi\ResponseHandler;

class EntityApi
{
    use ResponseHandler;

    /**
     * @var Client
     */
    private $client;

    /**
     * EntityApi constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieves a list of all entities for the agent.
     *
     * @return mixed
     */
    public function getEntities()
    {
        $response = $this->client->get('entities');

        return $this->decodeResponse($response);
    }

    /**
     * Retrieves the specified entity.
     *
     * $entityId is the ID of the entity to retrieve. You can specify the entity by its name instead of its ID.
     *
     * @param string $entityId
     * @return mixed
     */
    public function getEntity($entityId = null)
    {
        $entityPath = $this->getEntityPath($entityId);

        $response = $this->client->get('entities' . $entityPath);

        return $this->decodeResponse($response);
    }

    /**
     * Create a new entity.
     *
     * @param EntityObject $entity
     * @return mixed
     */
    public function createEntity(EntityObject $entity)
    {
        $response = $this->client->post('entities', $entity);

        return $this->decodeResponse($response);
    }

    /**
     * Return a path for a given entity id.
     *
     * @param string $entityId
     * @return null|string
     */
    private function getEntityPath($entityId = null)
    {
        $result = $entityId;

        if (null !== $entityId) {
            $result = '/' . $entityId;
        }

        return $result;
    }
}