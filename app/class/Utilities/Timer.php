<?php
namespace ContactForm\Utilities;

use ContactForm\Session;

class Timer
{
    const TIME_TO_NEXT_SEND = 60;
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function isRequiredTimePassed()
    {
        $this->setTimer();
        $time_pre  = $this->session->get('sentTime');
        $time_post = microtime(true);
        $time      = $time_post - $time_pre;
        return $time > self::TIME_TO_NEXT_SEND ? true : false;
    }

    public function setTimer()
    {
        if(!$this->session->exists('sentTime')){
            $this->updateStartTime();
        }
    }

    public function updateStartTime()
    {
        $this->session->put('sentTime', microtime(true));
    }
}