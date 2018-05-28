<?php
/**
 * Test class for the episode sorter
 */
class SorterTest extends PHPUnit\Framework\TestCase
{   
    private $m_episodes = null;
    
    public function setUp()
    {
        $this->m_episodes = [
          ["season" => 8, "episode"  => 2],
          ["season" => 6, "episode"  => 4],
          ["season" => 11, "episode"  => 22],
          ["season" => 8, "episode"  => 22],
          ["season" => 4, "episode"  => 12],
          ["season" => 6, "episode"  => 12],
          ["season" => 4, "episode"  => 3],
          ["season" => 4, "episode"  => 5],
          ["season" => 5, "episode"  => 2],
          ["season" => 5, "episode"  => 13]
        ];
    }
    /**
     * Given a new Sorter
     * When compared to a Sorter instantiated with the create method
     * Then they should be the same 
     */
    public function testCreateSameAsStatic()
    {
        $this->assertEquals(new Sorter(),Sorter::create());
    }
    /**
     * Given an array with season and episode keys
     * When the sorter is run
     * Then the array is returned sorted by season asc, episode asc
     */
    public function testSorterCorrectlySortsEpisodes()
    {
        $episodes = Sorter::create()
        ->setEpisodes($this->m_episodes)
        ->run()
        ->getSortedEpisodes();

        $this->assertEquals(count($this->m_episodes),count($episodes));

        // correct order should be:6,7,4,8,9,1,5,3,2
        $this->assertEquals($this->m_episodes[6],$episodes[0]);
        $this->assertEquals($this->m_episodes[7],$episodes[1]);
        $this->assertEquals($this->m_episodes[4],$episodes[2]);
        $this->assertEquals($this->m_episodes[8],$episodes[3]);
        $this->assertEquals($this->m_episodes[9],$episodes[4]);
        $this->assertEquals($this->m_episodes[1],$episodes[5]);
        $this->assertEquals($this->m_episodes[5],$episodes[6]);
        $this->assertEquals($this->m_episodes[0],$episodes[7]);
        $this->assertEquals($this->m_episodes[3],$episodes[8]);
        $this->assertEquals($this->m_episodes[2],$episodes[9]);
    }
}
