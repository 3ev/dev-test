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
    /**
     * gets the data required to display the page
     * @return mixed[]
     */
    public function getData()
    {
        return ["error" => $this->m_has_error,"episodes" => $this->m_episodes];
    }
    /**
     * gets the episodes as a json string from the api
     * @return string
     */
    private function getFromApi()
    {
        //Get the episodes from the API
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', 'http://3ev.org/dev-test-api/');

        return json_encode((array)json_decode($res->getBody()));       
    }
    /**
     * attempts to load the episode data from a file
     * will also return null if the file is more than 5 minutes old
     * @param bool $check_time Whether to check the file modified time or not
     * @return []|null the episode data or null if there isn't any
     */
    private function loadFromFile($check_time = false)
    {
        $file_path = "../public/resources/episode-data.json";
        
        if(false === file_exists($file_path))
        {
            return null;
        }
        else
        { 
            $last_modified = filemtime("../public/resources/episode-data.json");
            
            $now = time();
            
            if($check_time && 300 < ($now - $last_modified))
            {
                return null;
            }
            
            return json_decode(file_get_contents($file_path),true);
        }
    }
    
    /**
     * Loads the data for the episode list page
     * @return $this
     */
    public function run()
    {   
        try
        {
            $json = $this->loadFromFile(true);

            if (null === $json)
            {
                $data = $this->getFromApi();
                
                file_put_contents("../public/resources/episode-data.json",$data);
                
                $json = json_decode($data, true);
           }
           
           $this->setEpisodes($json);
            
        } catch (Exception $ex) 
        {
            $this->setEpisodes($this->loadFromFile());

            $this->m_has_error = null === $this->m_episodes;
        }

        return $this;
    }
    /**
     * sets the sorted episode data
     * @param [] $episodes
     */
    public function setEpisodes($episodes)
    {
        $this->m_episodes = Sorter::create()
        ->setEpisodes($episodes)
        ->run()
        ->getSortedEpisodes();
    }
}
