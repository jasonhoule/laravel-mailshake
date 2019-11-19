<?php

namespace Jhoule\Mailshake\Filters;

class PushEvents
{
    /*
     * Someone clicked a link.
     */
    public const CLICKED = 'Clicked';

    /*
     * Someone opened an email.
     */
    public const OPENED = 'Opened';

    /*
     * Someone replied to one of your emails.
     */
    public const REPLIED = 'Replied';

    /*
     * Mailshake sent an email on your behalf.
     */
    public const MESSAGE_SENT = 'MessageSent';

    /*
     * A lead was created.
     */
    public const LEAD_CREATED = 'LeadCreated';

    /*
     * A lead’s status was changed.
     */
    public const LEAD_STATUS_CHANGED = 'LeadStatusChanged';
}
