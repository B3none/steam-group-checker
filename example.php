<?php

include("vendor/autoload.php");

$client = \B3none\SteamGroupChecker\Client::create();

$response = $client->detect("76561198028510846", [
    "https://steamcommunity.com/groups/voidrealitygaming"
]);

print_r([
    'grantAccess' => $response->shouldGrantAccess(),
    'rejectReason' => $response->getRejectReason()
]);