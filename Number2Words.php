<?php

# sudo pear install channel://pear.php.net/Numbers_Words-0.16.2
# http://pear.php.net/package-info.php?package=Numbers_Words 

include("Numbers/Words.php");

$wgExtensionCredits['parserhook'][] = array(
        'path' => __FILE__,     // Magic so that svn revision number can be shown
        'name' => "Numbers2Words",
        'description' => "Parser function that takes a number and returns the spelled out version.",    // Should be using descriptionmsg instead so that i18n is supported (but this is a simple example).
        'version' => "0.0.1", 
        'author' => "Jamie Thingelstad",
        'url' => "https://github.com/thingles/Number2Words",
);
 
# Define a setup function
$wgHooks['ParserFirstCallInit'][] = 'efNumber2Words_Setup';
# Add a hook to initialise the magic word
$wgHooks['LanguageGetMagic'][] = 'efNumber2Words_Magic';
 
function efNumber2Words_Setup( &$parser ) {
	# Set a function hook associating "n2w" magic word with our function
	$parser->setFunctionHook( 'n2w', 'efNumber2Words_Render' );
	return true;
}
 
function efNumber2Words_Magic( &$magicWords, $langCode ) {
	# Add the magic word
	# The first array element is whether to be case sensitive, in this case (0) it is not case sensitive, 1 would be sensitive
	# All remaining elements are synonyms for our parser function
	$magicWords['n2w'] = array( 0, 'n2w' );
	# unless we return true, other parser functions extensions won't get loaded.
	return true;
}
 
function efNumber2Words_Render( $parser, $num = '' ) {
	# The parser function itself
	# The input parameters are wikitext with templates expanded
	# The output should be wikitext too
	$nw = new Numbers_Words();
	$output = $nw->toWords($num);
	return $output;
}
