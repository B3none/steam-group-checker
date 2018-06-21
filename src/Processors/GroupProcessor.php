<?php

namespace B3none\SteamGroupChecker\Processors;

use B3none\SteamGroupChecker\Models\Group;
use GuzzleHttp\Client;

class GroupProcessor
{
    const GROUP_XML = "/memberslistxml/?xml=1";

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Group[]
     */
    protected $whitelistedGroups = [];

    /**
     * @var Group[]
     */
    protected $blacklistedGroups = [];

    /**
     * DetectionProcessor constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(string $steamId)
    {
        $this->client->get()
    }
}