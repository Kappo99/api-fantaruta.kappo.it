<?php

    define("ONLINE_CONNECTION", true);
    
    // if (!isLocalhost())
    // {
    //     define("DB_HOST", "localhost");
    //     define("DB_USERNAME", "root");
    //     define("DB_NAME", "prenota-azione");
    //     define("DB_PASSWORD", "");
    // }
    /* else */ if (ONLINE_CONNECTION)
    {
        define("DB_HOST", "localhost");
        define("DB_USERNAME", "u253831929_Ruta");
        define("DB_PASSWORD", "w$#G]YO&8");
        define("DB_NAME", "u253831929_FantaRuta");
    }
    else
    {
        define("DB_HOST", "localhost");
        define("DB_USERNAME", "root");
        define("DB_NAME", "studioscf");
        define("DB_PASSWORD", "");
    }
