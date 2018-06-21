<?php

namespace B3none\SteamGroupChecker\Processors;

use B3none\SteamGroupChecker\Factories\GroupFactory;
use B3none\SteamGroupChecker\Models\Group;
use B3none\SteamGroupChecker\Models\Response;

class DetectionProcessor
{
    /**
     * @var GroupFactory
     */
    protected $groupFactory;

    /**
     * @var string
     */
    protected $steamId;

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
     * @param GroupFactory $groupFactory
     */
    public function __construct(GroupFactory $groupFactory)
    {
        $this->groupFactory = $groupFactory;
    }

    public function addWhitelistedGroup(string $groupUrl)
    {
        $this->whitelistedGroups[] = $this->groupFactory->processGroup($groupUrl);
    }

    public function addBlacklistedGroup(string $groupUrl)
    {
        $this->blacklistedGroups[] = $this->groupFactory->processGroup($groupUrl);
    }

    /**
     * @param string $steamId
     * @return Response
     */
    public function detect(string $steamId) : Response
    {
        $response = new Response();

        foreach ($this->blacklistedGroups as $blacklistedGroup) {
            if (in_array($steamId, $blacklistedGroup->getMembers())) {
                $response->setGrantAccess(false);
                $response->setRejectReason("You're in a blacklisted group: " . $blacklistedGroup->getName());
                return $response;
            };
        }

        foreach ($this->whitelistedGroups as $whitelistedGroup) {
            if (in_array($steamId, $whitelistedGroup->getMembers())) {
                $response->setGrantAccess(true);
            }
        }

        return $response;
    }
}