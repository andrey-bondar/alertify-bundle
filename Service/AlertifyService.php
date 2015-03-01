<?php

namespace AppVentus\AlertifyBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @author Andrey Bondar
 */
class AlertifyService
{
    const SUCCESS = 'success';
    const INFO = 'info';
    const WARNING = 'warning';
    const DANGER = 'danger';
    
    /**
     * @var Session
     */
    protected $session;
    
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param array $options
     */
    public function success(array $options)
    {
        $this->publish(static::SUCCESS, $options);
    }

    /**
     * @param array $options
     */
    public function info(array $options)
    {
        $this->publish(static::INFO, $options);
    }

    /**
     * @param array $options
     */
    public function warning(array $options)
    {
        $this->publish(static::WARNING, $options);
    }

    /**
     * @param array $options
     */
    public function danger(array $options)
    {
        $this->publish(static::DANGER, $options);
    }
    
    /**
     * @todo add OptionResolver for specific Engine
     * 
     * @param string $type
     * @param array $options
     */
    protected function publish($type, array $options)
    {
        $this->session->getFlashBag()->add($type, $options);
    }
}
