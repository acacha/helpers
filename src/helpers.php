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

if (!function_exists('scape_single_quotes')) {
    /**
     * Scape single quotes for sed using \x27.
     *
     * @param string $str
     *
     * @return string
     */
    function scape_single_quotes($str)
    {
        return str_replace("'", '\\x27', $str);
    }
}


if (!function_exists('add_text_into_file')) {
    /**
     * Insert text into file using mountpoint and sed command. Mountpoint is maintained at file for future uses.
     *
     * @param $mountpoint
     * @param $textToAdd
     * @param $file
     * @return mixed
     */
    function add_text_into_file($mountpoint, $textToAdd, $file)
    {
        passthru(
            'sed -i \'s/.*'.$mountpoint.'.*/ \ \ \ \ \ \ \ '. scape_single_quotes(preg_quote($textToAdd)).',\n \ \ \ \ \ \ \ '.$mountpoint.'/\' '. $file, $error);

        return $error;
    }
}

if (!function_exists('add_file_into_file')) {
    /**
     * Insert file into file using mountpoint.
     *
     * @param $mountpoint
     * @param $fileToInsert
     * @param $file
     * @param null $outputFile
     * @return mixed
     */
    function add_file_into_file($mountpoint, $fileToInsert,$file, $outputFile = null)
    {
        if ($outputFile != null) {
            passthru(
                'sed -e \'/'.$mountpoint.'/r'.$fileToInsert.'\' '.
                $file.' > '.$outputFile, $error);
        } else {
            passthru(
                'sed -i \'/'.$mountpoint.'/r'.$fileToInsert.'\' '.$file, $error);
        }

        return $error;
    }
}

if (!function_exists('dot_path')) {
    /**
     * Converts regular path to dotted path.
     *
     * @param $path
     * @return mixed
     */
    function dot_path($path)
    {
        return str_replace("/", ".", $path);
    }
}

if (!function_exists('undot_path')) {
    /**
     * Converts dotted path to regular path.
     *
     * @param $path
     * @return mixed
     */
    function undot_path($path)
    {
        return str_replace(".", "/", $path);
    }
}

if (!function_exists('check_connection')) {
    /**
     * Check database connection.
     *
     * @param $connection
     * @return bool
     */
    function check_connection($connection)
    {
        try {
            app()->make('db')->connection($connection)->getPdo();
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
