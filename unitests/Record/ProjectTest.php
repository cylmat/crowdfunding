<?php

namespace Record;

class ProjectTest extends \PHPUnit\Framework\TestCase
{
    function setUp(): void 
    {
        $this->user = new User('user');
        $this->project = new Project('project');
    }

    function testCanUpdateProperty()
    {
        $project = $this->project;
        $this->assertInstanceOf(Project::class, $project);
        
        $project->title = 'alpha';
        $this->assertEquals('alpha', $project->title);

        $this->expectException('InvalidArgumentException');
        $project->notexistsproperty = 'nothing';
    }

    function testCanCreate()
    {
        $user = $this->user;
        $user->nom = 'john';
        $user->create();
        $lastUserId = $user->lastInsertId();

        $project = $this->project;
        $project->title = 'title of the project';
        $project->description = 'this is the one';
        $project->fk_id_user = $lastUserId;

        $project->create();
        $lastId = $project->lastInsertId();
        
        $this->assertTrue(is_int($lastId) && $lastId>=0);

        //delete project
        $project->delete($lastId);

        //delete user
        $user->delete($lastUserId);

        $this->assertNull($project->get($lastId));
        $this->assertNull($user->get($lastUserId));
    }
}