<?php
/**
 *------
 * BGA framework: © Gregory Isabelli <gisabelli@boardgamearena.com> & Emmanuel Colin <ecolin@boardgamearena.com>
 * EthnosTest implementation : © <Your name here> <Your email address here>
 * 
 * This code has been produced on the BGA studio platform for use on http://boardgamearena.com.
 * See http://en.boardgamearena.com/#!doc/Studio for more information.
 * -----
 * 
 * ethnostest.game.php
 *
 * This is the main file for your game logic.
 *
 * In this PHP file, you are going to defines the rules of the game.
 *
 */
require_once (APP_GAMEMODULE_PATH . 'module/table/table.game.php');

class EthnosTest extends Table
{

    function __construct()
    {
        // Your global variables labels:
        // Here, you can assign labels to global variables you are using for this game.
        // You can use any number of global variables with IDs between 10 and 99.
        // If your game has options (variants), you also have to associate here a label to
        // the corresponding ID in gameoptions.inc.php.
        // Note: afterwards, you can get/set the global variables with getGameStateValue/setGameStateInitialValue/setGameStateValue
        parent::__construct();

        self::initGameStateLabels(array(
            // "my_first_global_variable" => 10,
            // "my_second_global_variable" => 11,
            // ...
            // "my_first_game_variant" => 100,
            // "my_second_game_variant" => 101,
            // ...
        ));

        $this->cards = self::getNew("module.common.deck");
        $this->cards->init("card");
        $this->cards->autoreshuffle = false;
    }

    protected function getGameName()
    {
        // Used for translations and stuff. Please do not modify.
        return "ethnostest";
    }

    /*
     * setupNewGame:
     *
     * This method is called only once, when a new game is launched.
     * In this method, you must setup the game according to the game rules, so that
     * the game is ready to be played.
     */
    protected function setupNewGame($players, $options = array())
    {
        // Set the colors of the players with HTML color code
        // The default below is red/green/blue/orange/brown
        // The number of colors defined here must correspond to the maximum number of players allowed for the gams
        $gameinfos = self::getGameinfos();
        $default_colors = $gameinfos['player_colors'];

        // Create players
        // Note: if you added some extra field on "player" table in the database (dbmodel.sql), you can initialize it there.
        $sql = "INSERT INTO player (player_id, player_color, player_canal, player_name, player_avatar) VALUES ";
        $values = array();
        foreach ($players as $player_id => $player) {
            $color = array_shift($default_colors);
            $values[] = "('" . $player_id . "','$color','" . $player['player_canal'] . "','" . addslashes($player['player_name']) . "','" . addslashes($player['player_avatar']) . "')";
        }
        $sql .= implode($values, ',');
        self::DbQuery($sql);
        self::reattributeColorsBasedOnPreferences($players, $gameinfos['player_colors']);
        self::reloadPlayersBasicInfos();

        /**
         * ********** Start the game initialization ****
         */

        // Init global values with their initial values
        // self::setGameStateInitialValue( 'my_first_global_variable', 0 );

        // Init game statistics
        // (note: statistics used in this file must be defined in your stats.inc.php file)
        // self::initStat( 'table', 'table_teststat1', 0 ); // Init a table statistics
        // self::initStat( 'player', 'player_teststat1', 0 ); // Init a player statistics (for all players)

        // TODO: setup the initial game situation here

        $selected_races = array();
        $max_race = 6;

        if ($random_race) {

            $all_races = array();
            foreach ($this->races as $race_id => $race) {

                if ($this->races[$race_id]['name'] != 'Dragon') {
                    array_push($all_races, $race_id);
                }
            }

            shuffle($all_races);

            for ($loop = 0; $loop < $max_race; $loop ++) {
                $selected = array_pop($all_races);

                array_push($selected_races, $this->races[$selected]);
            }
        } else {}

        // Create cards
        $cards = array();
        // TODO add the all the races into the cards array
        foreach ($selected_races as $race_id) {

            $race_count = $this->races[$race_id]['count'];

            foreach ($this->kingdoms as $kingdom_id) {
                $card_per_race = ($race_count / count($this->kingdom));
                $cards[] = array(
                    'type' => $race_id,
                    'type_arg' => $kingdom_id,
                    'nbr' => $card_per_race
                );
            }
        }

        // add the 3 dragons
        $cards[] = array(
            'type' => $this->dragon_id,
            'type_arg' => 0,
            'nbr' => 3
        );

        count($cards);

        // create the deck
        $this->cards->createCards($cards, 'deck');

        // move the dragons out
        $dragon_cards_ids = $this->cards->getCardsOfType($this->dragon_id);

        foreach ($dragon_cards_ids as $dragon_cards_id) {
            $this->cards->moveCard($dragon_cards_id, 'discard');
        }

        // move the dragons out
        // self::DbQuery("UPDATE cards set card_location = 'removed' WHERE card_type in ( " . $this->dragon_id . " )");

        // shuffle the deck
        $this->cards->shuffle('deck');

        // give each player a card
        foreach ($players as $player_id => $player) {
            $this->cards->pickCard('deck', $player);
        }

        // split the deck into 2 , put the either half into the discards with the dragons

        self::DbQuery("UPDATE cards set card_location = 'removed' WHERE card_type in ( " . $this->dragon_id . " )");

        foreach ($dragon_cards_ids as $dragon_cards_id) {
            $this->cards->moveCard($dragon_cards_id, 'deck');
        }

        // combine the two deck back

        // Activate first player (which is in general a good idea :) )
        $this->activeNextPlayer();

    /**
     * ********** End of the game initialization ****
     */
    }

    /*
     * getAllDatas:
     *
     * Gather all informations about current game situation (visible by the current player).
     *
     * The method is called each time the game interface is displayed to a player, ie:
     * _ when the game starts
     * _ when a player refreshes the game page (F5)
     */
    protected function getAllDatas()
    {
        $result = array();

        $current_player_id = self::getCurrentPlayerId(); // !! We must only return informations visible by this player !!

        // Get information about players
        // Note: you can retrieve some extra field you added for "player" table in "dbmodel.sql" if you need it.
        $sql = "SELECT player_id id, player_score score FROM player ";
        $result['players'] = self::getCollectionFromDb($sql);

        // TODO: Gather all information about current game situation (visible by player $current_player_id).

        return $result;
    }

    /*
     * getGameProgression:
     *
     * Compute and return the current game progression.
     * The number returned must be an integer beween 0 (=the game just started) and
     * 100 (= the game is finished or almost finished).
     *
     * This method is called each time we are in a game state with the "updateGameProgression" property set to true
     * (see states.inc.php)
     */
    function getGameProgression()
    {
        // TODO: compute and return the game progression
        return 0;
    }

    // ////////////////////////////////////////////////////////////////////////////
    // ////////// Utility functions
    // //////////

    /*
     * In this space, you can put any utility methods useful for your game logic
     */

    // ////////////////////////////////////////////////////////////////////////////
    // ////////// Player actions
    // //////////

    /*
     * Each time a player is doing some game action, one of the methods below is called.
     * (note: each method below must match an input method in ethnostest.action.php)
     */

    /*
     *
     * Example:
     *
     * function playCard( $card_id )
     * {
     * // Check that this is the player's turn and that it is a "possible action" at this game state (see states.inc.php)
     * self::checkAction( 'playCard' );
     *
     * $player_id = self::getActivePlayerId();
     *
     * // Add your game logic to play a card there
     * ...
     *
     * // Notify all players about the card played
     * self::notifyAllPlayers( "cardPlayed", clienttranslate( '${player_name} plays ${card_name}' ), array(
     * 'player_id' => $player_id,
     * 'player_name' => self::getActivePlayerName(),
     * 'card_name' => $card_name,
     * 'card_id' => $card_id
     * ) );
     *
     * }
     *
     */
    function recruit($card_id)
    {
        //
        self::checkAction('recruit');

        $player_id = self::getActivePlayerId();

        if ($card == $dragon) {

            if ($dragon_count >= 3) {
                $this->gamestate->nextState('gameEnd');
            } else {}
        } else {

            // Notify all players about the card played
            self::notifyAllPlayers("cardPlayed", clienttranslate('${player_name} recruit a ${card_name}'), array(
                'player_id' => $player_id,
                'player_name' => self::getActivePlayerName(),
                'card_name' => $card_name,
                'card_id' => $card_id
            ));

            $this->gamestate->nextState('nextPlayer');
        }
    }

    function playband($card_id)
    {
        //
        self::checkAction('playband');

        $player_id = self::getActivePlayerId();

        // Add your game logic to play a card there

        // Notify all players about the card played
        self::notifyAllPlayers("cardPlayed", clienttranslate('${player_name} plays a band ${card_name}'), array(
            'player_id' => $player_id,
            'player_name' => self::getActivePlayerName(),
            'card_name' => $card_name,
            'card_id' => $card_id
        ));

        $this->gamestate->nextState('nextPlayer');
    }

    // ////////////////////////////////////////////////////////////////////////////
    // ////////// Game state arguments
    // //////////

    /*
     * Here, you can create methods defined as "game state arguments" (see "args" property in states.inc.php).
     * These methods function is to return some additional information that is specific to the current
     * game state.
     */

    /*
     *
     * Example for game state "MyGameState":
     *
     * function argMyGameState()
     * {
     * // Get some values from the current game situation in database...
     *
     * // return values:
     * return array(
     * 'variable1' => $value1,
     * 'variable2' => $value2,
     * ...
     * );
     * }
     */

    // ////////////////////////////////////////////////////////////////////////////
    // ////////// Game state actions
    // //////////
    function stGameSetup()
    {
        $this->gamestate->nextState();
    }

    function stNextPlayer()
    {
        // Active next player
        $player_id = self::activeNextPlayer();

        $this->gamestate->nextState();
    }

    // ////////////////////////////////////////////////////////////////////////////
    // ////////// Zombie
    // //////////

    /*
     * zombieTurn:
     *
     * This method is called each time it is the turn of a player who has quit the game (= "zombie" player).
     * You can do whatever you want in order to make sure the turn of this player ends appropriately
     * (ex: pass).
     *
     * Important: your zombie code will be called when the player leaves the game. This action is triggered
     * from the main site and propagated to the gameserver from a server, not from a browser.
     * As a consequence, there is no current player associated to this action. In your zombieTurn function,
     * you must _never_ use getCurrentPlayerId() or getCurrentPlayerName(), otherwise it will fail with a "Not logged" error message.
     */
    function zombieTurn($state, $active_player)
    {
        $statename = $state['name'];

        if ($state['type'] === "activeplayer") {
            switch ($statename) {
                default:
                    $this->gamestate->nextState("zombiePass");
                    break;
            }

            return;
        }

        if ($state['type'] === "multipleactiveplayer") {
            // Make sure player is in a non blocking status for role turn
            $this->gamestate->setPlayerNonMultiactive($active_player, '');

            return;
        }

        throw new feException("Zombie mode not supported at this game state: " . $statename);
    }

    // /////////////////////////////////////////////////////////////////////////////////:
    // //////// DB upgrade
    // ////////

    /*
     * upgradeTableDb:
     *
     * You don't have to care about this until your game has been published on BGA.
     * Once your game is on BGA, this method is called everytime the system detects a game running with your old
     * Database scheme.
     * In this case, if you change your Database scheme, you just have to apply the needed changes in order to
     * update the game database and allow the game to continue to run with your new version.
     *
     */
    function upgradeTableDb($from_version)
    {
        // $from_version is the current version of this game database, in numerical form.
        // For example, if the game was running with a release of your game named "140430-1345",
        // $from_version is equal to 1404301345

        // Example:
        // if( $from_version <= 1404301345 )
        // {
        // // ! important ! Use DBPREFIX_<table_name> for all tables
        //
        // $sql = "ALTER TABLE DBPREFIX_xxxxxxx ....";
        // self::applyDbUpgradeToAllDB( $sql );
        // }
        // if( $from_version <= 1405061421 )
        // {
        // // ! important ! Use DBPREFIX_<table_name> for all tables
        //
        // $sql = "CREATE TABLE DBPREFIX_xxxxxxx ....";
        // self::applyDbUpgradeToAllDB( $sql );
        // }
        // // Please add your future database scheme changes here
        //
        //
    }
}
