<?php
/**
 * 
 */
class Sorter
{
    private $m_episodes = null;
    private $m_has_run  = false;
    
    public static function create()
    {
        return new static;
    }
    
    public function getSortedEpisodes()
    {
        if(false === $this->m_has_run)
        {
            $this->run();
        }
        
        return $this->m_episodes;
    }
    
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
     * 
     * @param mixed[] $episodes
     * @return $this
     */
    public function setEpisodes($episodes)
    {
        $this->m_episodes = $episodes;
        
        return $this;
    }
}
