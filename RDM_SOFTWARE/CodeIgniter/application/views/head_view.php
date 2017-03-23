<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Simple Login with CodeIgniter - Private Area</title>

        <script src="<?= base_url() ?>public/js/jquery.js"></script>
        <script src="<?= base_url() ?>public/js/hello.js"></script>
        <script src="<?= base_url() ?>public/js/mqttws31.js"></script>
        <script src="<?= base_url() ?>public/js/hiveMQ_client_test.js"></script>

    </head>
    <body>



        <div id="target">
            connect list meters
        </div>


        <div id="target2">
            connect list meters 2222
        </div>      



        <h2>Welcome to Home!</h2>
        <a href="home">Menu</a>

        <select id = "topic">
            <option value="+/VGW/LastPing" >LastPing ####</option>
            <option value="b8:27:eb:4c:14:af/VGW/LastPing/#" selected="selected">LastPing b8:27:eb:4c:14:af</option>
            <option value="b8:27:eb:4c:14:af/VGW/#" >b8:27:eb:4c:14:af</option>
            <option value="b827eb4c14af/state/#" >b827eb4c14af#</option>
            <option value="openhab/home/state/#" >openhab/home/state/#</option>
            <option value="openhab/home/state/itm_sofa_temp_mqtt/state">Sofa Temperature</option>
            <option value="openhab/home/state/itm_sofa_hum_mqtt/state">Sofa Humidity</option>
            <option value="openhab/home/state/itm_uber1_powerSofa_mqtt/state">Sofa Power</option>
            <option value="openhab/home/state/meter1_power/state">Meter1 power</option>
            <option value="openhab/home/state/meter1_energy/state">Meter1 energy</option>
            <option value="openhab/home/state/meter2_power/state">Meter2 power</option>
            <option value="openhab/home/state/meter2_energy/state">Meter2 energy</option>
            <option value="openhab/home/state/meter3_power/state">Meter3 power</option>
            <option value="openhab/home/state/meter3_energy/state">Meter3 energy</option>
            <option value="openhab/home/state/Weather_Temperature/state">Weather temperature</option>
        </select>

        <button onclick="client.connect(options);">1. Connect</button>
        <button onclick="client.subscribe(document.getElementById('topic').value, {qos: 0});
                alert('Subscribed');">2. Subscribe</button>
        <button onclick="client.disconnect();">3. Disconnect</button>
        <div id="messages"></div>




        </script>

    </body>



</html>
<script>


 


   client.connect(options);
  
 

    $("#target").click(function () {


        client.subscribe("b8:27:eb:4c:14:af/VGW/LastPing/#", {qos: 0});
        client.subscribe("b8:27:eb:b4:7c:1b/VGW/LastPing/#", {qos: 0});
        client.subscribe("b8:27:eb:72:50:29/VGW/name/#", {qos: 0});


    });

   $(function() {

    $("#target2").click(function () {

     
        <?php
        
        $max = 0;
        
         $max = sizeof($macNames);
        
          if ($max) {
          
              for ($i = 0; $i < $max; $i++) {
                  
                  
               echo "client.subscribe('$macNames[$i]/state/$DeviceName[$i]/state', {qos: 0});";     
                  
                  
              }
              
              
              
          }
        
       
         
         
         ?>
     
   });

});

function store_data(macPath,payload){
    
     console.log('clicked '+payload + ' PATH MAC ' + macPath);
    
     $.ajax({
                type: "POST",
                url: "<? echo site_url('head/saveMacMeter');?>",
                dataType: 'json',
                cache: false,
                data: {
                    payload: $.trim(payload),
                    macPath: $.trim(macPath)

                },
              
                success: function (msg) { //probably this request will return anything, it'll be put in var "data"

        

                },
                error: function (jqXHR, textStatus, errorThrown)
                {


                }
            });
    
    
    
}



   

</script>