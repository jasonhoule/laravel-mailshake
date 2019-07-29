<?php

namespace Jhoule\Mailshake\Filters;

class RecipientFilterActions
{

    /*
     * Recipients who have opened a message.
     */
    public const OPENED = 'opened';

    /*
     * Recipients who have clicked a link.
     */
    public const CLICKED = 'clicked';

    /*
     * Recipients who have replied.
     */
    public const REPLIED = 'replied';

    /*
     * Recipients who were sent a message.
     */
    public const WAS_SENT = 'wasSent';

    /*
     * Recipients who bounced.
     */
    public const BOUNCED = 'bounced';

    /*
     * Recipients who are paused.
     */
    public const PAUSED = 'paused';

    /*
     * Recipients who have a missing text replacement or a failed sent email.
     */
    public const HAS_PROBLEMS = 'hasProblems';
}
