<?php

namespace B3none\SteamGroupChecker\Processors;

use B3none\SteamGroupChecker\Models\Group;
use B3none\SteamGroupChecker\Models\Response;

class DetectionProcessor
{
    /**
     * @var GroupProcessor
     */
    protected $groupProcessor;

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
     * @param GroupProcessor $groupProcessor
     */
    public function __construct(GroupProcessor $groupProcessor)
    {
        $this->groupProcessor = $groupProcessor;
    }

    public function addWhitelistedGroup(string $groupUrl)
    {
        $group =
        $this->groupProcessor->process()
    }

    public function addBlacklistedGroup(string $groupUrl)
    {

    }
}