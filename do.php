<?php
// configure cron tu run every 10 minutes
require "src/init.php";

// actualizar base de datos con listado de frases
update_quotes_into_database(QUOTES_PATH);

// run bot
$bot = new Bot();
$bot->run();


// Marketing: 
//	- social networks: twitter, facebook, pinterest, google+
//  - blog

/*
fuentes de visitas:
	social networks: twitter, facebook, pinterest, google+, listas de correo
	sitios con alto page rank: buscar sitios con PR que acepten comentarios
		diarios: elcomercio.pe, 
*/