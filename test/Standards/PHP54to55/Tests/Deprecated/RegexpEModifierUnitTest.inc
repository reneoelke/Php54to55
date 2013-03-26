<?php

// example call
preg_replace("/(</?)(w+)([^>]*>)/e", "'\1'.strtolower('\2').'\3'", $html_body);

// different regexp delimeter
preg_replace("@(</?)(w+)([^>]*>)@e", "'\1'.strtolower('\2').'\3'", $html_body);