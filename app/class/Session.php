<?php
namespace ContactForm;

class Session
{
    public function start()
    {
        session_start();
    }

    public function exists($name)
    {
        return isset($_SESSION[$name]) ? true : false;
    }

    public function get($name)
    {
        return $this->exists($name) ? $_SESSION[$name] : false;
    }

    public function put($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function delete($name)
    {
        if($this->exists($name)){
            unset($_SESSION[$name]);
        }
    }

    public function flashMessage($message = null)
    {
        if(isset($message)){
            $this->put('message', $message);
        }else{
            if($this->exists('message')){
                $message = $this->get('message');
                $this->delete('message');
            }else{
                $message = null;
            }
            return $message;
        }
    }

    public function destroy()
    {
        session_destroy();
    }
}