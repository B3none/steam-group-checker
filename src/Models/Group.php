<?php

namespace B3none\SteamGroupChecker\Models;

class Group
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $groupId;

    /**
     * @var array
     */
    protected $members = [];

    /**
     * Group constructor.
     * @param array $groupParams
     */
    public function __construct(array $groupParams = [])
    {
        if (!empty($groupParams['url'])) {
            $this->setUrl($groupParams['url']);
        }

        if (!empty($groupParams['name'])) {
            $this->setName($groupParams['name']);
        }

        if (!empty($groupParams['groupId'])) {
            $this->setGroupId($groupParams['groupId']);
        }

        if (!empty($groupParams['members'])) {
            $this->setMembers($groupParams['members']);
        }
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url) : void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getGroupId() : string
    {
        return $this->groupId;
    }

    /**
     * @param string $groupId
     */
    public function setGroupId(string $groupId) : void
    {
        $this->groupId = $groupId;
    }

    /**
     * @return array
     */
    public function getMembers() : array
    {
        return $this->members;
    }

    /**
     * @param string $steamId
     */
    public function addMember(string $steamId) : void
    {
        $this->members[] = $steamId;
    }

    /**
     * @param array $members
     */
    public function setMembers(array $members) : void
    {
        $this->members = $members;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name) : void
    {
        $this->name = $name;
    }
}