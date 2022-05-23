<?php

$gameinfos = array( 


// Game designer (or game designers, separated by commas)
'designer' => 'Paolo Mori',       

// Game artist (or game artists, separated by commas)
'artist' => 'John Howe',         

// Year of FIRST publication of this game. Can be negative.
'year' => 2017,                 

// Game publisher
'publisher' => 'CMON Global Limited',                     

// Url of game publisher website
'publisher_website' => 'https://boardgamegeek.com/boardgamepublisher/21608/cmon-global-limited',   

// Board Game Geek ID of the publisher
'publisher_bgg_id' => 21608,

// Board game geek if of the game
'bgg_id' => 206718,
    
// the description   
'presentation' => array(
    totranslate("Call upon unique fantasy tribes to gain control of the land and earn glory."),
    totranslate("In Ethnos, players call upon the support of giants, merfolk, halflings, minotaurs, and other fantasy tribes to help them gain control of the land. After three ages of play, whoever has collected the most glory wins!"),
),


// Players configuration that can be played 
'players' => array( 2,3,4,5,6 ),    

// Suggest players to play with this number of players. Must be null if there is no such advice, or if there is only one possible player configuration.
'suggest_player_number' => 4,

// Discourage players to play with this number of players. Must be null if there is no such advice.
'not_recommend_player_number' => array( 2),


// Estimated game duration, in minutes (used only for the launch, afterward the real duration is computed)
'estimated_duration' => 45,           

// Time in second add to a player when "giveExtraTime" is called (speed profile = fast)
'fast_additional_time' => 7,           

// Time in second add to a player when "giveExtraTime" is called (speed profile = medium)
'medium_additional_time' => 16,           

// Time in second add to a player when "giveExtraTime" is called (speed profile = slow)
'slow_additional_time' => 23,           


// Game is "beta". A game MUST set is_beta=1 when published on BGA for the first time, and must remains like this until all bugs are fixed.
'is_beta' => 1,                     

// Is this game cooperative (all players wins together or loose together)
'is_coop' => 0, 


// Complexity of the game, from 0 (extremely simple) to 5 (extremely complex)
'complexity' => 2,    

// Luck of the game, from 0 (absolutely no luck in this game) to 5 (totally luck driven)
'luck' => 2,    

// Strategy of the game, from 0 (no strategy can be setup) to 5 (totally based on strategy)
'strategy' => 4,    

// Diplomacy of the game, from 0 (no interaction in this game) to 5 (totally based on interaction and discussion between players)
'diplomacy' => 1,    


// Games categories
//  You can attribute any number of "tags" to your game.
//  Each tag has a specific ID (ex: 22 for the category "Prototype", 101 for the tag "Science-fiction theme game")
'tags' => array( 1 , 12 , 100 ,200 ,208 , 209 , 210, )
);
