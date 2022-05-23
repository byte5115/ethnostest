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
 * material.inc.php
 *
 * EthnosTest game material description
 *
 * Here, you can describe the material of your game with PHP variables.
 *   
 * This file is loaded in your game logic class constructor, ie these variables
 * are available everywhere in your game logic code.
 *
 */
$this->races = array(
    1 => array(
        'name' => clienttranslate('Centaurs'),
        'nametr' => self::_('Centaurs'),
        'count' => 12,
        'ability' => clienttranslate('If you place a marker on the board, you may play another band of allies immediately.')        
    ),
    2 => array(
        'name' => clienttranslate('Elves'),
        'nametr' => self::_('Elves'),
        'count' => 12,
        'ability' => clienttranslate('You may keep up to X cards in your hand.')
    ),    
    3 => array(
        'name' => clienttranslate('Dwarves'),
        'nametr' => self::_('Dwarves'),
        'count' => 12,
        'ability' => clienttranslate('This band counts as X+1 for end of the age scoring.')
    ),    
    4 => array(
        'name' => clienttranslate('Giants'),
        'nametr' => self::_('Giants'),
        'count' => 12,
        'ability' => clienttranslate('If you play the biggest band with a Giant leader, take control of the Giant Token and score 2 glory.')
    ),
    5 => array(
        'name' => clienttranslate('Merfolk'),
        'nametr' => self::_('Merfolk'),
        'count' => 12,
        'ability' => clienttranslate('Advance X spaces on the Merfolk track.')
    ),    
    6 => array(
        'name' => clienttranslate('Halfings'),
        'nametr' => self::_('Halfings'),
        'count' => 24,
        'ability' => clienttranslate('Don\'t place a marker on the board.')
    ),    
    7 => array(
        'name' => clienttranslate('Minotaurs'),
        'nametr' => self::_('Minotaurs'),
        'count' => 12,
        'ability' => clienttranslate('This band counts as X+1 for placing a marker on the board.')
    ),
    8 => array(
        'name' => clienttranslate('Orcs'),
        'nametr' => self::_('Orcs'),
        'count' => 12,
        'ability' => clienttranslate('Place a marker on the matching space of the Orc Board.')
    ),    
    9 => array(
        'name' => clienttranslate('Skeletons'),
        'nametr' => self::_('Skeletons'),
        'count' => 12,
        'ability' => clienttranslate('Can\'t be a leader. Can be used with any band of allies. Must be discarded before end of age scorings.')
    ),    
    10 => array(
        'name' => clienttranslate('Trolls'),
        'nametr' => self::_('Trolls'),
        'count' => 12,
        'ability' => clienttranslate('Take an unclaimed Troll token with a value up to X.')
    ),    
    11 => array(
        'name' => clienttranslate('Wizards'),
        'nametr' => self::_('Wizards'),
        'count' => 12,
        'ability' => clienttranslate('Draw X cards from the deck.')
    ),    
    12 => array(
        'name' => clienttranslate('Wingfolk'),
        'nametr' => self::_('Wingfolk'),
        'count' => 12,
        'ability' => clienttranslate('You can place your marker on any kingdom of the board.')
    ),
    13 => array(
        'name' => clienttranslate('Dragon'),
        'nametr' => self::_('Dragon'),
        'count' => 3,
        'ability' => clienttranslate('You can place your marker on any kingdom of the board.')
    )
);


$this->dragon_id = 13 ;

$this->kingdoms = array(
    1 => array(
        'name' => clienttranslate('Pelagon'),
        'color' => 'gray'        
    ),
    2 => array(
        'name' => clienttranslate('Ithys'),
        'color' => 'orange'
    ),
    3 => array(
        'name' => clienttranslate('Straton'),
        'color' => 'blue'
    ),
    4 => array(
        'name' => clienttranslate('Althea'),
        'color' => 'green'
    ),    
    5 => array(
        'name' => clienttranslate('Rhea'),
        'color' => 'red'
    ),
    6 => array(
        'name' => clienttranslate('Duris'),
        'color' => 'purple'
    )
);



$this->scoring = array(
    1 => array(
        'bandCount' => 1,
        'VP' => 0
    ),
    2 => array(
        'bandCount' => 2,
        'VP' => 1
    ),
    3 => array(
        'bandCount' => 3,
        'VP' => 3
    ),
    4 => array(
        'bandCount' => 4,
        'VP' => 6
    ),    
    5 => array(
        'bandCount' => 5,
        'VP' => 10
    ),    
    6 => array(
        'bandCount' => 6,
        'VP' => 15
    )
);

