<?php

/**
 * Created by PhpStorm.
 * User: maxbrokman
 * Date: 28/03/2014
 * Time: 14:36
 */

/**
 * Class RandomNumberGame
 *
 * Runs a match and handles CLI out/in
 */
class RandomNumberGame
{

    /**
     * Registers Autoloader and starts the match
     */
    public function __construct()
    {
        spl_autoload_register(
            function( $class )
            {
                include( $class . '.php' );
            }
        );

        $this->startMatch();
    }

    /**
     * Starts the match, runs games under the match, terminating on user input
     *
     */
    private function startMatch()
    {
        $match = new Match();
        $matchController = new MatchController( $match );

        while ( true ) {
            $matchController->runNewGame();
            $this->askIfRunAgain( $match );
        }
    }

    /**
     * Asks if the user wants to run another game under $match.
     * If they do not calls the exit function for $match
     *
     * @param Match $match
     */
    public function askIfRunAgain( $match )
    {
        self::writeStdout( 'Do you want to play again? [y/n]' );
        $response = self::readStdin();

        if ( $response === 'y' ) {
            return;
        }

        $this->exitWithResults( $match );
    }

    /**
     * Exits with information about $match
     *
     * @param Match $match
     */
    public function exitWithResults( $match )
    {
        $gamesCount = count( $match->getGames() );
        $completeGames = array();

        foreach ( $match->getGames() as $game ) {
            /** @var Game $game */

            if ( $game->getComplete() === true ) {
                $completeGames[] = $game;
            }
        }

        $completeCount = count( $completeGames );

        $totalGuesses = 0;
        foreach ( $match->getGames() as $game ) {
            /** @var Game $game */

            $totalGuesses = $totalGuesses + count( $game->getGuesses() );
        }

        $averageGuesses = $totalGuesses / $gamesCount;

        self::writeStdout( 'Thanks for playing!' );
        self::writeStdout( 'You played ' . $gamesCount . ' games, and won ' . $completeCount . ' of them, with an average ' . $averageGuesses . ' guesses per game.' );
        exit( 0 );
    }

    /**
     * Writes $string to command line with EOL character
     *
     * @param string $string
     */
    public static function writeStdout( $string )
    {
        fwrite( STDOUT, $string . PHP_EOL );
    }

    /**
     * Reads from STDIN, returns trimmed value
     *
     * @return string
     */
    public static function readStdin()
    {
        return trim( fgets( STDIN ) );
    }
}

//check for cli
if ( php_sapi_name() != 'cli' ) {
    exit();
}

new RandomNumberGame();