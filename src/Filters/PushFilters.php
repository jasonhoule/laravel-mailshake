<?php

namespace Jhoule\Mailshake\Filters;

class PushFilters
{
    /*
     * To only get events for a specific campaign.
     */
    public const CAMPAIGN_ID = 'campaignID';

    /*
     * For events based on message, only get events for a specific message.
     */
    public const CAMPAIGN_MESSAGE_ID = 'campaignMessageID';

    /*
     * true if you don’t want to get pushes for duplicate opens or clicks.
     */
    public const EXCLUDE_DUPLICATES = 'excludeDuplicates';

    /*
     * For clicks you can only be notified when this exact url is clicked.
     */
    public const MATCH_URL = 'matchUrl';

    /*
     * For sent messages you can be notified only when certain types of messages are sent.
     */
    public const MESSAGE_TYPE = 'messageType';
}
