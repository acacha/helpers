<?php

namespace League\Skeleton;

/**
 * Class HelpersTest.
 *
 * @package League\Skeleton
 */
class HelpersTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test git user email.
     *
     */
    public function testGitUserEmail()
    {
        exec('git config --global user.email "sergiturbadenas@gmail.com"');
        $email = git_user_email();
        $this->assertEquals('sergiturbadenas@gmail.com',$email);
    }

    /**
     * Test git user email not exists.
     *
     */
    public function testGitUserEmailNotExists()
    {
        $previous_global_email = exec('git config --global user.email');
        $previous_local_email = exec('git config user.email');
        exec('git config --global --unset user.email');
        exec('git config --unset user.email');

        $email = git_user_email();
        $this->assertNull($email);

        if ($previous_global_email != "") exec("git config --global user.email \"${previous_global_email}\"");
        if ($previous_local_email != "") exec("git config user.email \"${previous_local_email}\"");
    }

    /**
     * Test git user name.
     *
     */
    public function testGitUserName()
    {
        exec('git config --global user.name "Sergi Tur Badenas"');
        $name = git_user_name();
        $this->assertEquals('Sergi Tur Badenas',$name);
    }

    /**
     * Test git user name not exists.
     *
     */
    public function testGitUserNameNotExists()
    {
        $previous_global_name = exec('git config --global user.name');
        $previous_local_name = exec('git config user.name');
        exec('git config --global --unset user.name');
        exec('git config --unset user.name');
        $name = git_user_name();
        $this->assertNull($name);
        if ($previous_global_name != "") exec("git config --global user.name \"${previous_global_name}\"");
        if ($previous_local_name != "") exec("git config user.name \"${previous_local_name}\"");
    }
}
