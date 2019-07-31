<?php
    if (method_exists($this->_account, $name) || preg_match('/^find/', $name)) {
        return call_user_func_array(array($this->_account, $name), $args);
    }

