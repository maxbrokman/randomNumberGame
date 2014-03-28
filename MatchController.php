<?php
/**
 * Created by PhpStorm.
 * User: maxbrokman
 * Date: 28/03/2014
 * Time: 14:38
 */

class MatchController {

    /**
     * @var Match
     */
    private $_match;

    public function __construct( &$match )
    {
        $this->setMatch( $match );
    }

    public function runNewGame()
    {
        $game = new Game();
        $gameController = new GameController( $game );

        $gameController->runGame();

        $this->getMatch()->addGame( $game );

    }

    /**
     * @param \Match $match
     */
    public function setMatch( $match )
    {
        $this->_match = $match;
    }

    /**
     * @return \Match
     */
    public function getMatch()
    {
        return $this->_match;
    }


} 