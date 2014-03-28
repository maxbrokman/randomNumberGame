<?php

/**
 * Created by PhpStorm.
 * User: maxbrokman
 * Date: 28/03/2014
 * Time: 14:38
 */

/**
 * Class GameController
 * Controller / Repository for Game class
 */
class GameController
{

    /**
     * @var Game
     */
    private $_game;

    /**
     * Sets the Game model for the control
     *
     * @param Game $game
     */
    public function __construct( $game )
    {
        $this->setGame( $game );
    }

    /**
     * Runs a game
     *
     * Prints target number so we can cheat. Until the game is complete asks for guesses, adds guesses to the game
     * and checks if the guess wins (matches game's target number). If the guess wins the game is set to complete and
     * the function returns the game. Every 5 guesses the user is given the oppurtunity to skip the game, and the function
     * returns the (unsolved) game.
     *
     * @return Game
     */
    public function runGame()
    {
        $game = $this->getGame();

        RandomNumberGame::writeStdout( 'Psst, the number we\'re looking for is ' . $game->getTarget() );

        while ( !$game->getComplete() ) {

            $guess = (int) $this->askForGuess();

            $game->addGuess( $guess );

            if ( $guess === $game->getTarget() ) {
                $game->setComplete( true );
                RandomNumberGame::writeStdout('Damn straight! And it only took ' . count( $game->getGuesses() ) . ' guesses!' );
                break;
            }

            RandomNumberGame::writeStdout( 'Nope, that\'s not it!' );

            $this->highLowHint( $game, $guess );

            //if this isn't the first guess give a warmer colder hint
            if ( count( $game->getGuesses() ) > 1 ) {
                $this->warmerColderHint( $game, $guess);
            }

            //ask to skip every 5 goes
            if ( count( $game->getGuesses() ) % 5 === 0 ) {
                $skip = $this->askToSkip();

                if ( $skip === true ) {
                    break;
                }
            }


        }

        return $game;
    }

    /**
     * Asks the user to provide a game and checks the provided value is a number in the rang 1-100
     *
     * @return string
     */
    private function askForGuess()
    {
        RandomNumberGame::writeStdout( 'Please enter a number between 1 and 100' );
        $guess = RandomNumberGame::readStdin();

        if ( !is_numeric( $guess ) ) {
            RandomNumberGame::writeStdout( 'That\'s not a number! ');
            return $this->askForGuess();
        }

        if ( $guess > 100 || $guess < 1 ) {
            RandomNumberGame::writeStdout( 'Between 1 and 100 silly!' );
            return $this->askForGuess();
        }

        return $guess;
    }

    /**
     * Asks the user if they want to skip this game. Returns true for 'y' and false otherwise.
     *
     * @return bool
     */
    private function askToSkip()
    {
        RandomNumberGame::writeStdout( 'Do you want to skip this game? [y/n]' );
        $response = RandomNumberGame::readStdin();

        if ( $response === 'y' ) {
            return true;
        }

        return false;
    }


    /**
     * Tells the user if their guess was too high or too low
     *
     * @param Game $game
     * @param int $guess
     */
    private function highLowHint( $game, $guess )
    {
        if ( $guess > $game->getTarget() ) {
            RandomNumberGame::writeStdout( 'That guess was too high.' );
        } elseif ( $guess < $game->getTarget() ) {
            RandomNumberGame::writeStdout( 'That guess was too low.' );
        }
    }

    /**
     * Provides warmer / colder hinting based on the last guess of the game and this guess
     *
     * @param Game $game
     * @param int $guess
     */
    private function warmerColderHint( $game, $guess )
    {
        $guesses = $game->getGuesses();
        $lastGuess = $guesses[ count( $guesses ) - 2 ];
        $target = $game->getTarget();

        if ( abs( $target - $lastGuess ) > abs( $target - $guess ) ) {
            //warmer
            RandomNumberGame::writeStdout( 'Getting warmer :)' );
            return;
        }

        if ( abs( $target - $lastGuess ) < abs( $target - $guess ) ) {
            //colder
            RandomNumberGame::writeStdout( 'Getting colder :(' );
        }
    }

    /**
     * @param \Game $game
     */
    public function setGame( $game )
    {
        $this->_game = $game;
    }

    /**
     * @return \Game
     */
    public function getGame()
    {
        return $this->_game;
    }


} 