<?php

namespace B3none\SteamGroupChecker\Factories;

use B3none\Cache\CacheClient;
use B3none\SteamGroupChecker\Models\Group;

class GroupFactory
{
    const GROUP_XML = "/memberslistxml/?xml=1";

    /**
     * @var Group
     */
    protected $group;

    /**
     * @var \SimpleXMLElement
     */
    protected $xpath;

    /**
     * @var CacheClient
     */
    protected $cache;

    /**
     * GroupFactory constructor.
     * @param CacheClient $cache
     */
    public function __construct(CacheClient $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $groupUrl
     * @return Group
     */
    public function processGroup(string $groupUrl) : Group
    {
        $cacheId = preg_replace("/[^A-Za-z0-9 ]/", '', $groupUrl);
        if ($this->cache->hasCache($cacheId) && $this->cache->isFreshEnough($cacheId)) {
            return $this->cache->getCache($cacheId)['group'];
        } else {
            $this->group = new Group();

            $this->group->setUrl($groupUrl);
            $this->getXPath($this->group->getUrl());
            $this->detectName();
            $this->detectGroupID();
            $this->detectMembers();

            $this->cache->setCache($cacheId, [
                'group' => $this->group
            ]);

            return $this->group;
        }
    }

    /**
     * @param string $groupUrl
     * @param int $page
     */
    protected function getXPath(string $groupUrl, int $page = 1) : void
    {
        $bodyContents = file_get_contents($groupUrl . self::GROUP_XML . "&p=" . $page);
        $this->xpath = simplexml_load_string($bodyContents);
    }

    protected function detectMembers() : void
    {
        $totalMembers = $this->getTotalMembers();
        $pages = ($totalMembers / 1000) + 1;
        $pages = (int)$pages;

        for ($pageCount = 1; $pageCount <= $pages; $pageCount++) {

            $this->getXPath($this->group->getUrl(), $pageCount);
            $members = $this->xpath->xpath("/*/members/steamID64");

            for ($memberCount = 0; $memberCount < count($members); $memberCount++) {
                if (!is_null($members[$memberCount])) {
                    $memberSteamId = $members[$memberCount]->__toString();
                    $this->group->addMember($memberSteamId);
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

    protected function detectGroupID() : void
    {
        $groupId = $this->xpath->xpath("/*/groupID64")[0];

        $this->group->setGroupId($groupId->__toString());
    }

    protected function detectName() : void
    {
        $name = $this->xpath->xpath("/*/groupDetails/groupName")[0];

        $this->group->setName($name->__toString());
    }
}
