<?php
/**
 * Module to load episodes
 */
class EpisodeLoader
{
    private $m_episodes  = null;
    private $m_has_error = false;
    /**
     * Instantiates a new EpisodeLoader
     * @return \static
     */
    public static function create()
    {
        return new static;
    }
    
    public function getData()
    {
        return ["error" => $this->m_has_error,"episodes" => $this->m_episodes];
    }
    /**
     * Sorts the set episode array
     * @return $this
     */
    public function run()
    {     
        try
        {
            //Get the episodes from the API
            $client = new GuzzleHttp\Client();
            $res = $client->request('GET', 'http://3ev.org/dev-test-api/');
            $data = json_decode($res->getBody(), true);

            //Sort the episodes
            $this->m_episodes = Sorter::create()
            ->setEpisodes($data)
            ->run()
            ->getSortedEpisodes();           
        } catch (GuzzleHttp\Exception\ServerException $ex) 
        {
            $this->m_has_error = true;
        }

        return $this;
    }
    /**
     * Must have season and episode array keys
     * @param mixed[] $episodes
     * @return $this
     */
    public function setEpisodes($episodes)
    {
        $this->m_episodes = $episodes;
        
        return $this;
    }
}
