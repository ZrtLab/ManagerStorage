<?php

namespace ManagerStorage\Session\SaveHandler;

use Zend\Session\SaveHandler\SaveHandlerInterface;

class Redis implements SaveHandlerInterface
{

    protected $storage;
    protected $sessionName = 'session';
    protected $parser = ':';
    protected $ttl;
    protected $id;

    public function __construct()
    {
        return $this;
    }

    public function setStorage($storage)
    {
        $this->storage = $storage;
    }

    public function getStorage()
    {
        return $this->storage;
    }

    public function open($savePath, $name)
    {
        if ($name) {
            $this->sessionName .= $this->parser . $name;
        }

        $this->ttl = ini_get('session.gc_maxlifetime');

        return true;
    }

    public function close()
    {
        return true;
    }

    public function getId()
    {
        return $this->id;
    }

    public function read($id)
    {
        $this->id = $this->parser($id);
        $data = $this->storage->get($this->id);
        if (!$data) {
            return;
        }

        return $data;
    }

    public function write($id, $data)
    {
        $this->id = $this->parser($id);
        $this->storage->setex($this->id, $this->ttl, $data);

        return true;
    }

    public function destroy($id)
    {
        $this->id = $this->parser($id);
        $this->storage->del($this->id);

        return true;
    }

    public function gc($maxlifetime)
    {
        return $this->ttl;
    }

    protected function parser($id)
    {
        return sprintf("%s%s%s", $this->sessionName, $this->parser, $id);
    }
}
