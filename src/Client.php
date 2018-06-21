<?php

namespace B3none\SteamGroupChecker;

use B3none\SteamGroupChecker\Factories\GroupFactory;
use B3none\SteamGroupChecker\Models\Response;
use B3none\SteamGroupChecker\Processors\DetectionProcessor;

class Client
{
    /**
     * @var DetectionProcessor
     */
    protected $detectionProcessor;

    static function create()
    {
        return new self(new DetectionProcessor(new GroupFactory(new \GuzzleHttp\Client())));
    }

    /**
     * Client constructor.
     * @param DetectionProcessor $detectionProcessor
     */
    public function __construct(DetectionProcessor $detectionProcessor)
    {
        $this->detectionProcessor = $detectionProcessor;
    }

    /**
     * @param string $steamId
     * @param array $whitelistedGroups
     * @param array $blacklistedGroups
     * @return Response
     */
    public function detect(string $steamId, array $whitelistedGroups = [], array $blacklistedGroups = []) : Response
    {
        foreach ($whitelistedGroups as $whitelistedGroup) {
            $this->detectionProcessor->addWhitelistedGroup($whitelistedGroup);
        }

        foreach ($blacklistedGroups as $blacklistedGroup) {
            $this->detectionProcessor->addBlacklistedGroup($blacklistedGroup);
        }

        return $this->detectionProcessor->detect($steamId);
    }
}