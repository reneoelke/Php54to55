<?php

// example call
preg_replace("/(</?)(w+)([^>]*>)/e", "'\1'.strtolower('\2').'\3'", $html_body);

// different delimiter, delimiter in character class, multiple modifiers, free formating
preg_replace("@(</?)(w+)([^>]*>)@e", "'\1'.strtolower('\2').'\3'", $html_body);
preg_replace('@(</?)(w+)([^>\@]*>)@e', "'\1'.strtolower('\2').'\3'", $html_body);
preg_replace("@(</?)(w+)([^>]*>)@Susei", "'\1'.strtolower('\2').'\3'", $html_body);
preg_replace(   "`
    # some comment
    (</?)(w+)
    ([^>]*>)
`xe",
    "'\1'.strtolower('\2').'\3'", $html_body);

// heredoc
preg_replace(<<<'EOS'
@(</?)(w+)([^>]*>)@e
EOS
, "'\1'.strtolower('\2').'\3'", $html_body);
preg_replace(<<<EOD
@(</?)(w+)([^>]*>)@e
EOD
    , "'\1'.strtolower('\2').'\3'", $html_body);
