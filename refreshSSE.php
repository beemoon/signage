<?php
// http://www.developerdrive.com/2012/03/pushing-updates-to-the-web-page-with-html5-server-sent-events/
// https://developer.mozilla.org/fr/docs/Server-sent_events/Using_server-sent_events

header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");

/**
 * Constructs the SSE data format and flushes that data to the client.
 *
 * @param string $id Timestamp/id of this connection.
 * @param string $msg Line of text that should be transmitted.
 * 
 */
 
// Informations pour le event stream SSE
function sendMsg($id, $event,$retry,$msg) {
  echo "id: $id" . PHP_EOL;
  echo "event: $event" . PHP_EOL;
  echo "retry: $retry" .PHP_EOL;
  echo "data: $msg\n\n" . PHP_EOL;
  echo PHP_EOL;
  ob_flush();
  flush();
}

// On force le reload
if (is_file('forceRefresh.txt')){
	sendMsg(time(),'refreshMe','1000','1');
	sleep(5);
	unlink('forceRefresh.txt');
}

// On controle les slides à afficher/supprimer et force le reload
include('nextTime.inc');
if (time() >= $_next){
	require('admin/manage.php');
	touch('forceRefresh.txt');
}

?>
