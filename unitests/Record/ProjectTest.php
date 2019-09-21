<?php

namespace Record;

class ProjectTgest extends \PHPUnit\Framework\TestCase
{
    function testCanUpdateProperty()
    {
        $project = new Project('project');
        $this->assertInstanceOf(Project::class, $project);
        
        $project->title = 'alpha';
        $this->assertEquals('alpha', $project->title);

        $this->expectException('InvalidArgumentException');
        $project->notexistsproperty = 'nothing';
    }

    function testCanCreate()
    {
        $user = new User('user');
        $user->nom = 'john';
        $user->create();
        $lastUserId = $user->lastInsertId();

        $project = new Project('project');
        $project->title = 'title of the project';
        $project->description = 'this is the one';
        $project->fk_id_user = $lastUserId;

        $project->create();
        $lastId = $project->lastInsertId();
        
        $this->assertGreaterThan(1, $lastId);

        //delete project
        $project->delete($lastId);

        //delete user
        $user->delete($lastUserId);

        $this->assertNull($project->get($lastId));
        $this->assertNull($user->get($lastUserId));
    }
}