<?php

/**
 * PHP Version 5.3
 *
 * @copyright (c) 2014-2015 brian ridley
 * @author brian ridley <ptlis@ptlis.net>
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace ptlis\DiffParser\Test\Parse\Git;

use ptlis\DiffParser\File;
use ptlis\DiffParser\Hunk;
use ptlis\DiffParser\Line;
use ptlis\DiffParser\Parse\UnifiedDiffParser;
use ptlis\DiffParser\Parse\UnifiedDiffTokenizer;
use ptlis\DiffParser\Parse\GitDiffNormalizer;

class DiffParserAddTest extends \PHPUnit_Framework_TestCase
{
    public function testParseCount()
    {
        $parser = new UnifiedDiffParser(
            new UnifiedDiffTokenizer(
                new GitDiffNormalizer()
            )
        );

        $data = file(__DIR__ . '/data/diff_add', FILE_IGNORE_NEW_LINES);

        $diff = $parser->parse($data);

        $this->assertInstanceOf('ptlis\DiffParser\Changeset', $diff);
        $this->assertEquals(1, count($diff->getFiles()));
    }

    public function testFileAdd()
    {
        $parser = new UnifiedDiffParser(
            new UnifiedDiffTokenizer(
                new GitDiffNormalizer()
            )
        );

        $data = file(__DIR__ . '/data/diff_add', FILE_IGNORE_NEW_LINES);

        $diff = $parser->parse($data);
        $fileList = $diff->getFiles();

        $this->assertEquals(1, count($fileList[0]->getHunks()));

        $file = new File(
            '',
            'README.md',
            File::CREATED,
            array(
                new Hunk(
                    0,
                    0,
                    0,
                    1,
                    array(
                        new Line(-1, 0, Line::ADDED, '## Test')
                    )
                )
            )
        );

        $this->assertEquals($file, $fileList[0]);
    }
}
