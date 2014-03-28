<?php
/**
 * Created by PhpStorm.
 * User: maxbrokman
 * Date: 28/03/2014
 * Time: 14:38
 */

/**
 * Class Game
 * Game model.
 */
class Game {
    /**
     * @var int target number for game
     */
    private $_target;

    /**
     * @var array
     */
    private $_guesses = array();

    /**
     * @var bool was game completed or skipped
     */
    private $_complete = false;

    /**
     * sets the games target to a random number between 1 and 100
     */
    public function __construct()
    {
        $this->setTarget( rand( 1, 100 ) );
    }

    /**
     * @param boolean $complete
     */
    public function setComplete( $complete )
    {
        $this->_complete = $complete;
    }

    /**
     * @return boolean
     */
    public function getComplete()
    {
        return $this->_complete;
    }

    /**
     * @param array $guesses
     */
    public function setGuesses( $guesses )
    {
        $this->_guesses = $guesses;
    }

    /**
     * @return array
     */
    public function getGuesses()
    {
        return $this->_guesses;
    }

    /**
     * @param int $guess
     * @return Game $this
     */
    public function addGuess( $guess )
    {
        $this->_guesses[] = $guess;
        return $this;
    }

    /**
     * @param int $target
     */
    public function setTarget( $target )
    {
        $this->_target = $target;
    }

    /**
     * @return int
     */
    public function getTarget()
    {
        return $this->_target;
    }


} 