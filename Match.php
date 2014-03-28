<?php
/**
 * Created by PhpStorm.
 * User: maxbrokman
 * Date: 28/03/2014
 * Time: 14:37
 */

class Match {
    private $_games = array();

    /**
     * @param array $games
     */
    public function setGames( $games )
    {
        $this->_games = $games;
    }

    /**
     * @return array
     */
    public function getGames()
    {
        return $this->_games;
    }


    /**
     * @param Game $game
     * @return Match $this
     */
    public function addGame( $game )
    {
        $this->_games[] = $game;
        return $this;
    }
} 