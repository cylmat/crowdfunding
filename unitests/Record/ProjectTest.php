<?php

namespace Record;

class ProjectTest extends \PHPUnit\Framework\TestCase
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
        $project = new Project('project');
        $project->title = 'title of the project';
        $project->description = 'this is the one';
        $project->fk_id_user = 149;

        $project->create();
        $lastId = $project->lastInsertId();
        echo $project->getLastError();
        $this->assertGreaterThan(1, $lastId);
        //$project->delete($lastId);
    }
}