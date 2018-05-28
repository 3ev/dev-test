<?php
/**
 * Module to sort episodes by season and episode
 */
class Sorter
{
    private $m_episodes = null;
    private $m_has_run  = false;
    /**
     * Instantiates a new Sorter
     * @return \static
     */
    public static function create()
    {
        return new static;
    }
    /**
     * @return mixed[] the sorted episodes
     */
    public function getSortedEpisodes()
    {
        if(false === $this->m_has_run)
        {
            $this->run();
        }
        
        return $this->m_episodes;
    }
    /**
     * Sorts the set episode array
     * @return $this
     */
    public function run()
    {
        $this->m_has_run = true;
        
        if (null === $this->m_episodes)
        {
            return $this;
        }
        
        $seasons  = [];
        $episodes = [];
        
        foreach ($this->m_episodes as $key => $row)
        {
           $seasons[$key]  = $row['season'];
           $episodes[$key] = $row['episode'];
        }

        array_multisort($seasons, SORT_ASC, $episodes, SORT_ASC, $this->m_episodes);

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
