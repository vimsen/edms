<?php
 error_reporting(E_ALL);
ini_set('display_errors', 1);

use Mosquitto\Client;
use Mosquitto\Message;
 
class MqttToDb {
 
    /* Our Mosquitto\Client instance */
    /**
     * @var Client The MQTT client
     */
    private $mqtt;
 
    /**
     * @var PDO A PDO database connection
     */
    private $db;
 
    /**
     * @var array The list of topics to subscribe to
     */
    private $topics = [];
 
    /**
     * @var PDOStatement A prepared statement used when we record a message
     */
    private $insertMessage;
 
    /**
     * @param Client $mqtt The Mosquitto\Client instance
     * @param PDO $db a PDO database connection
     */
    public function __construct(Client $mqtt, PDO $db)
    {
        $this->mqtt = $mqtt;
        $this->db = $db;
 
        $this->insertMessage = $this->db->prepare(
            'INSERT INTO mqtt_logs (id, topic, payload, received,mac,topic_c) VALUES (?, ?, ?, NOW(),?,?);'
        );
 
        /* Subscribe the Client to the topics when we connect */
        $this->mqtt->onConnect([$this, 'subscribeToTopics']);
        $this->mqtt->onMessage([$this, 'handleMessage']);
    }
 
    /**
     * @param array $topics
     *
     * An associative array of topics and their QoS values
     */
    public function setTopics(array $topics)
    {
        $this->topics = $topics;
    }
 
    /**
     * The internal callback used when the Client instance connects
     */
    public function subscribeToTopics() {
        foreach ($this->topics as $topic => $qos) {
            $this->mqtt->subscribe($topic, $qos);
        }
    }
 
    /**
     * @param Message $message
     * The internal callback used when a new message is received
     */
    public function handleMessage($message)
    {
        
        $pieces = explode("/", $message->topic);
        $this->insertMessage->execute([$message->mid, $message->topic, $message->payload,$pieces[1],$pieces[3]]);
    }
 
    /**
     * Start recording messages
     */
    public function start()
    {
        $this->mqtt->loopForever();
    }
}
 
/* Create a new DB connection */
//$db = new PDO('mysql:host=localhost;dbname=VimsentPlatform;charset=utf8', 'root', 'qazqaz');
 
$db = new PDO('mysql:host=localhost;dbname=VimsentPlatform;charset=utf8', 'active', 'd1@st1m0pl010ntE');

$stm = $db->prepare("SELECT macNames,DeviceName FROM ImeterMac inner join MacDevices on macId=m_id");
$stm->execute();
$data = $stm->fetchAll();
$cnt  = count($data); 

$mac = array();
$topic = array();
$content = array();

foreach ($data as $i => $row){
   
 //$mac[] = $row['macNames'];
 
 //$topic[] = $row['DeviceName'];  
    
 $content["+/".$row["macNames"]."/state/".$row["DeviceName"]."/state"] = 0;
 
}


$sizeofMac  = sizeof($mac);

/* Configure our Client */
$mqtt = new Client();
//94.70.239.217
//$mqtt->connect('broker.mqtt-dashboard.com');
 
$mqtt->connect('94.70.239.217');

$logger = new MqttToDb($mqtt, $db);
$logger->setTopics($content);

/*
[
   // 'sensors/room1/temperature' => 0,
   // 'sensors/room2/temperature' => 0,
 //b827eb4c14af/state/meter2_power/state
   //for($i=0;$i<$sizeofMac;$i++){
    
    
 'b827eb4c14af/state/meter2_power/state' => 0,   
    
         
   //}   
]

*/

$logger->start();
