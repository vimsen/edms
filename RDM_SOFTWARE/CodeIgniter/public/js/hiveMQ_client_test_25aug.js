 var client = new Messaging.Client("94.70.239.217", 8000, "myclientid_" + parseInt(Math.random() * 100, 10));

 //Gets  called if the websocket/mqtt connection gets disconnected for any reason
 client.onConnectionLost = function (responseObject) {
     //Depending on your scenario you could implement a reconnect logic here
     alert("connection lost: " + responseObject.errorMessage);
 };

 //Gets called whenever you receive a message for your subscriptions
 client.onMessageArrived = function (message) {
    
     $('#messages').append('<span>Topic: ' + message.destinationName + '  |- ' + message.payloadString + ' - </span><br/>');
     
     
     
 };

 //Connect Options
 var options = {
     timeout: 3,
     //Gets Called if the connection has sucessfully been established
     onSuccess: function () {
      //  alert("Connected");
     },
     //Gets Called if the connection could not be established
     onFailure: function (message) {
         alert("Connection failed: " + message.errorMessage);
     }
 };
 
 


 
 
