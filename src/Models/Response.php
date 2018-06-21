<?php

namespace B3none\SteamGroupChecker\Models;

class Response
{
    /**
     * @var bool
     */
    protected $success = true;

    /**
     * @var bool
     */
    protected $grantAccess = false;

    /**
     * @var string
     */
    protected $rejectReason;

    /**
     * @return bool
     */
    public function isSuccess() : bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     */
    public function setSuccess(bool $success) : void
    {
        $this->success = $success;
    }

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