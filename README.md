# PHP SOAP

Soap API in php

## Installation and running the script

Clone the repo, navigate to the folder and open terminal there.


### Check soap extension

Use this terminal to start a server

NB: Server and client must run in diferent server port or address for this to work

```
php -S 127.0.0.1:8080
```

Then navigate to __127.0.0.1:8080/check_soap.php__ to check for SOAP extension config if its set up properly.

Search(CTRL+F) for 'SOAP' settings to display server configuration is they are enabled.


### Create server, client and run the script

Then create a server instance for the script, in this case im using port 81 for server and 80 for client.

```
php -S 127.0.0.1:8081
```

Once the server is up, run client script __127.0.0.1:8080/client.php__


## Next up - integrating WSDL