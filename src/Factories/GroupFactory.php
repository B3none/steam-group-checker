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
     * @var \SimpleXMLElement
     */
    protected $xpath;

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
        $bodyContents = file_get_contents($groupUrl . self::GROUP_XML . "&p=" . $page);
        $this->xpath = simplexml_load_string($bodyContents);
    }

    protected function detectMembers()
    {
        $pages = 2;
        for ($pageCount = 1; $pageCount <= $pages; $pageCount++) {
            $this->getXPath($this->group->getUrl(), $pageCount);

            if ($pageCount === 1) {
                $totalMembers = $this->getTotalMembers();
                $pages = ($totalMembers / 1000) + 1;
                $pages = (int)$pages;
            }


            $members = $this->xpath->xpath("/*/members/steamID64");
            for ($memberCount = 0; $memberCount < 1000; $memberCount++) {
                if (is_string($members[$memberCount])) {
                    $this->group->addMember($members[$memberCount]);
                }
            }
        }
    }

    /**
     * @return int
     */
    protected function getTotalMembers() : int
    {
        $totalMembers = ($this->xpath->xpath("/*/memberCount"))[0]->__toString();
        return (int)$totalMembers;
    }

    protected function detectGroupID()
    {
        $groupId = $this->xpath->xpath("/*/memberList/groupID64");

        $this->group->setGroupId($groupId[0]->__toString());
    }

    protected function detectName()
    {
        $name = $this->xpath->xpath("/*/memberList/groupDetails/groupName");

        $this->group->setName($name[0]->__toString());
    }
}