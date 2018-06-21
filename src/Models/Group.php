<?php

namespace B3none\SteamGroupChecker\Models;

class Group
{
    /**
     * @var bool
     */
    protected $whitelisted = true;

    /**
     * @var bool
     */
    protected $blacklisted = false;

    /**
     * @var string
     */
    protected $url;

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
        if (!empty($groupParams['whitelisted'])) {
            $this->setWhitelisted($groupParams['whitelisted']);
        }

        if (!empty($groupParams['blacklisted'])) {
            $this->setBlacklisted($groupParams['blacklisted']);
        }

        if (!empty($groupParams['url'])) {
            $this->setUrl($groupParams['url']);
        }

        if (!empty($groupParams['groupId'])) {
            $this->setGroupId($groupParams['groupId']);
        }

        if (!empty($groupParams['members'])) {
            $this->setMembers($groupParams['members']);
        }

        if (!empty($groupParams['members'])) {
            $this->setMembers($groupParams['members']);
        }
    }

    /**
     * @return bool
     */
    public function isWhitelisted() : bool
    {
        return $this->whitelisted;
    }

    /**
     * @param bool $whitelisted
     */
    public function setWhitelisted(bool $whitelisted) : void
    {
        $this->whitelisted = $whitelisted;
    }

    /**
     * @return bool
     */
    public function isBlacklisted() : bool
    {
        return $this->blacklisted;
    }

    /**
     * @param bool $blacklisted
     */
    public function setBlacklisted(bool $blacklisted) : void
    {
        $this->blacklisted = $blacklisted;
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
}