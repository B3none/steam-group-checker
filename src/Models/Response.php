<?php

namespace B3none\SteamGroupChecker\Models;

class Response
{
    /**
     * @var bool
     */
    protected $grantAccess = false;

    /**
     * @var string
     */
    protected $rejectReason = "None";

    /**
     * @return bool
     */
    public function shouldGrantAccess() : bool
    {
        return $this->grantAccess;
    }

    /**
     * @param bool $grantAccess
     */
    public function setGrantAccess(bool $grantAccess) : void
    {
        $this->grantAccess = $grantAccess;
    }

    /**
     * @return string
     */
    public function getRejectReason() : string
    {
        return $this->rejectReason;
    }

    /**
     * @param string $rejectReason
     */
    public function setRejectReason(string $rejectReason) : void
    {
        $this->rejectReason = $rejectReason;
    }
}