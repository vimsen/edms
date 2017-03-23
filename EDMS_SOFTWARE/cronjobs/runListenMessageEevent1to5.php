<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'biswv_threshold_cron/agent.php';

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
    private $compare = 0;
    private $holdTopic = [];

    public function __construct(Client $mqtt, PDO $db) {
        $this->mqtt = $mqtt;
        $this->db = $db;

        /* Subscribe the Client to the topics when we connect */
        $this->mqtt->onConnect([$this, 'subscribeToTopics']);
        
        $this->mqtt->onMessage([$this, 'handleMessage']);
        
      
        
    }

    /**
     * @param array $topics
     *
     * An associative array of topics and their QoS values
     */
    public function setTopics(array $topics) {
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
    public function handleMessage($message) {

        $pieces = explode("/", $message->topic);


        $pieces_topic = explode("/", $message->topic);



        if (sizeof($pieces_topic) == 5 or sizeof($pieces_topic) == 6) {
            //is number timestamp
            if (ctype_digit($pieces_topic[1])) {



                $messageIsThere = $this->messageIFexists($pieces_topic[4]);


                if ($messageIsThere) {

                       //email
                    if ($this->messageIFexistIndb($message->topic)) {

                        $email = $this->messageIFsend(strip_tags(trim($pieces_topic[1])), strip_tags(trim($message->payload)));


                        if (filter_var(strip_tags(trim($email)), FILTER_VALIDATE_EMAIL) and $email) {


                               if (sizeof($pieces_topic) == 6 and strip_tags(trim($pieces_topic[5]))) {

                                if (strip_tags(trim($pieces_topic[5])) == "event1" || strip_tags(trim($pieces_topic[5])) == "event2" || strip_tags(trim($pieces_topic[5])) == "event3" || strip_tags(trim($pieces_topic[5])) == "event4"
                                ) {
                                    new Agent(true, $email, strip_tags(trim($message->payload)), date('Y-m-d H-i-s'));
                                } elseif (strip_tags(trim($pieces_topic[5])) == "event5") {

                                    new Agent(true, $email, $messageIsThere, date('Y-m-d H-i-s'));
                                }
                            } else {

                                new Agent(true, $email, $messageIsThere, date('Y-m-d H-i-s'));
                            }
                            $this->mqtt->publish("messageM/$pieces_topic[1]/$email/on/$pieces_topic[4]/send", "yes", 1, true);
                            $this->updateMessage(strip_tags(trim($pieces_topic[1])), date('Y-m-d H-i-s'), strip_tags(trim($message->payload))); //($timestamp,$currentTime,$payload)
                        }
                    } else {
                        $this->saveRecord(strip_tags(trim($message->payload)), strip_tags(trim($pieces_topic[2])), strip_tags(trim($pieces_topic[1])), strip_tags(trim($message->topic)), date('Y-m-d H-i-s'), "off");

                        if (filter_var(strip_tags(trim($pieces_topic[2])), FILTER_VALIDATE_EMAIL)) {



                            if (sizeof($pieces_topic) == 6 and strip_tags(trim($pieces_topic[5]))) {

                                if (strip_tags(trim($pieces_topic[5])) == "event1" || strip_tags(trim($pieces_topic[5])) == "event2" || strip_tags(trim($pieces_topic[5])) == "event3" || strip_tags(trim($pieces_topic[5])) == "event4"
                                ) {
                                    new Agent(true, $pieces_topic[2], strip_tags(trim($message->payload)), date('Y-m-d H-i-s'));
                                } elseif (strip_tags(trim($pieces_topic[5])) == "event5") {

                                    new Agent(true, $pieces_topic[2], $messageIsThere, date('Y-m-d H-i-s'));
                                }
                            } else {
                                new Agent(true, $pieces_topic[2], $messageIsThere, date('Y-m-d H-i-s'));
                            }

                            $this->mqtt->publish("messageM/$pieces_topic[1]/$pieces_topic[2]/on/$pieces_topic[4]/send", "yes", 1, true);

                            $this->updateMessage(strip_tags(trim($pieces_topic[1])), date('Y-m-d H-i-s'), strip_tags(trim($message->payload))); //($timestamp,$currentTime,$payload)
                        }
                    }
                }
            }

            unset($pieces_topic);
        }
    }

    public function getInbetweenStrings($start, $end, $str) {
        $matches = array();
        $regex = "/$start([a-zA-Z0-9_]*)$end/";
        preg_match_all($regex, $str, $matches);
        return $matches[1];
    }

    public function saveRecord($payload, $topic, $timestamp, $fullPath, $dateInsert, $mailStatus) {
        $db = $this->db;
        $stm = $db->prepare("INSERT INTO VimsentPlatform.topicMessageRealTime(payload, topicName, timestampTopic,fullPath,dateInsert,status)
    VALUES(?, ?, ?, ?, ?, ?)");
        $stm->execute(array($payload, $topic, $timestamp, $fullPath, $dateInsert, $mailStatus));
    }

    public function updateMessage($timestamp, $currentTime, $payload) {
        $db = $this->db;
        $stm = $db->prepare("update VimsentPlatform.topicMessageRealTime set status='on',changeUPdate=:UPdate where status='off' and payload=:payload and timestampTopic=:timestamp");

        $stm->execute(array(':timestamp' => $timestamp, ':UPdate' => $currentTime, ':payload' => $payload)); //payload
    }

    public function messageIFsend($timestamp, $id) {


        $db = $this->db;

        $stm = $db->prepare("SELECT topicName FROM VimsentPlatform.topicMessageRealTime where status='off' and payload=:payload and timestampTopic=:timestamp");
        $stm->execute(array(':timestamp' => $timestamp, ':payload' => $id));
        $data = $stm->fetchAll();
        $cnt = count($data);

        $email = "";

        foreach ($data as $i => $row) {

            if ($row['topicName']) {

                $email = $row['topicName'];
            }
        }
        return $email;
    }

    public function messageIFexistIndb($topicName) {


        $db = $this->db;

        $stm = $db->prepare("SELECT payload FROM VimsentPlatform.topicMessageRealTime where fullPath=:topicname");
        $stm->execute(array(':topicname' => $topicName));
        $data = $stm->fetchAll();
        $cnt = count($data);

        $payload = "";

        foreach ($data as $i => $row) {

            if ($row['payload']) {

                $payload = $row['payload'];
            }
        }
        return $payload;
    }

    public function messageIFexists($id = null) {


        $db = $this->db;

        $stm = $db->prepare("SELECT id_message,main_Message FROM vgwMessages where id_message=:id_message");
        $stm->execute(array(':id_message' => $id));
        $data = $stm->fetchAll();
        $cnt = count($data);

        $flag = 0;

        foreach ($data as $i => $row) {

            if ($row['id_message'] == $id) {

                $flag = $row['main_Message'];
            }
        }
        return $flag;
    }

    /**
     * Start recording messages
     */
    public function start() {
        $this->mqtt->loopForever();
    }

}

/* Create a new DB connection */
//$db = new PDO('mysql:host=localhost;dbname=VimsentPlatform;charset=utf8', 'root', 'qazqaz');

$db = new PDO('mysql:host=localhost;dbname=VimsentPlatform;charset=utf8', '', '');

$stm = $db->prepare("SELECT macNames,DeviceName,mac FROM ImeterMac inner join MacDevices on macId=m_id");
$stm->execute();
$data = $stm->fetchAll();
$cnt = count($data);

$mac = array();
$topic = array();
$content = array();


$content["messageM/#"] = 0;


/* Configure our Client */
$mqtt = new Client();

$mqtt->connect('94.70.239.217');

$logger = new MqttToDb($mqtt, $db);
$logger->setTopics($content);

$logger->start();
