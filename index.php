<?php
    function helloWorld($tag = "h2") {
        echo "<".$tag.">HelloWorld!</".$tag.">";
    }

    helloWorld("p");
?>