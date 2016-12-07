<?php

if (!function_exists('command_exists')) {
    /**
     * Check if command exists.
     *
     * @param $command
     * @return boolean
     */
    function command_exists($command)
    {
        exec('type "'. $command . '"',$result,$return);
        return !$return;
    }
}

if (!function_exists('validate_email')) {
    /**
     * Validate email
     * @param $email
     * @return null
     */
    function validate_email($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        }
        return null;
    }
}

if (!function_exists('git_user_email')) {
    /**
     * Get user email from git config.
     */
    function git_user_email()
    {
        if (!command_exists("git")) return null;
        $result = exec('git config user.email');

        $email = validate_email($result);
        if (!is_null($email)) return $email;

        $result = exec('git config --global user.email');
        return validate_email($result);
    }
}

if (!function_exists('git_user_name')) {
    /**
     * Get user email from git config.
     */
    function git_user_name()
    {
        if (!command_exists("git")) return null;
        $result = exec('git config user.name');

        if ($result != "") return $result;

        $result = exec('git config --global user.name');
        if ($result != "") return $result;
        return null;
    }
}