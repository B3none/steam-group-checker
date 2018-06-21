<?php

namespace B3none\SteamGroupChecker\Factories;

use B3none\SteamGroupChecker\Models\Group;
use GuzzleHttp\Client;

class GroupFactory
{
    const GROUP_XML = "/memberslistxml/?xml=1";

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Group
     */
    protected $group;

    /**
     * @var \DOMXPath
     */
    protected $xpath;

    /**
     * DetectionProcessor constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $groupUrl
     * @return Group
     */
    public function processGroup(string $groupUrl)
    {
        $this->group = new Group();

        $this->group->setUrl($groupUrl);
        $this->detectMembers();
        $this->detectName();
        $this->detectGroupID();

        return $this->group;
    }

    /**
     * @param string $groupUrl
     * @param int $page
     */
    protected function getXPath(string $groupUrl, int $page = 1)
    {
        $response = $this->client->get($groupUrl . self::GROUP_XML . "&p=" . $page);
        $bodyContents = $response->getBody()->getContents();
        $dom = new \DOMDocument($bodyContents);
        $this->xpath = new \DOMXPath($dom);
    }

    protected function detectMembers()
    {
        $pages = 2;
        for ($pageCount = 1; $pageCount <= $pages; $pageCount++) {
            $this->getXPath($this->group->getUrl(), $pageCount);

            if ($pageCount === 1) {
                $totalMembers = $this->xpath->query('/membersList/membersCount');
                $pages = ($totalMembers / 1000) + 1;
            }

            for ($memberCount = 0; $memberCount < 1000; $memberCount++) {
                $steamId = $this->xpath->query("/membersList/members/steamID64[{$memberCount}]");
                $steamId = $steamId->item(0)->nodeValue;

                $this->group->addMember($steamId);
            }
        }
    }

    protected function detectGroupID()
    {
        $groupId = $this->xpath->query("/membersList/groupID64");

        $this->group->setGroupId($groupId->item(0)->nodeValue);
    }

    protected function detectName()
    {
        $name = $this->xpath->query("/membersList/groupDetails/groupName");

        $this->group->setName($name->item(0)->nodeValue);
    }
}