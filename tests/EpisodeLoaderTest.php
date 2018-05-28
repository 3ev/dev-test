<?php
/**
 * Test class for the episode loader
 */
class EpisodeLoaderTest extends PHPUnit\Framework\TestCase
{
    /**
     * Given a new EpisodeLoader
     * When compared to a EpisodeLoader instantiated with the create method
     * Then they should be the same 
     */
    public function testCreateSameAsStatic()
    {
        $this->assertEquals(new EpisodeLoader(),EpisodeLoader::create());
    }
    /**
     * Given an EpisodeLoader 
     * When it hasn't been run
     * Then episodes should return null
     */
    public function testLoaderReturnsNullIfNoneLoaded()
    {
        $data = EpisodeLoader::create()->getData();
        
        $this->assertNull($data['episodes']);
    }
    /**
     * Given an EpisodeLoader
     * When getData is called
     * Then an array with error and episodes should be returned
     */
    public function testGetDataReturnsArray()
    {
        $data = EpisodeLoader::create()->run()->getData();
        
        $this->assertArrayHasKey('error',$data);
        $this->assertArrayHasKey('episodes',$data);
    }
}
