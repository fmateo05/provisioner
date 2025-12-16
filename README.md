### Kazoo Provisioner with FusionPBX Backend.

With this script you connect a kazoo webhook to it and then will get connected to couchdb and parse variables with postgresql queries to be executed on fusionpbx's environment.

Note that you should configure fusionpbx with provisioner settings enabled and  visualize the phones JSON on SmartPBX

### Steps:

1. Install a fusionpbx  normally on different instance or VPS <br>
2. Setup a Webserver with NGINX with SSL Certificates, PHP and Postgresql; then, import the provisioner-db.sql with proper user credentials (ie. provisioner), the schema is called 'provisioner', also install python3, postgresql client and curl and some of the php libraries. <br>
3. Move or rename the api-phones-alternate.php file to index.php, edit and  the DB connection parameters with also the CORS headers at the top of the file (to your Monster-UI URL)  <br>
4. Add a location block to the nginx server section like the following: 
````

    location  /api/phones {
      add_header "Access-Control-Allow-Origin" "https://portal.example.com";
      rewrite ^(.*)$  /index.php ;
     }
````

5. Restart the nginx service <br>
6. Edit the Monster-UI js/config.js and add the provisioner link as following: <br>
````

  api: {
       'default': 'https://api.example.net:8443/v2/',
       'provisioner': 'https://phoneprov.example.net/api/'
       }
````

7. Copy Brands and Models Image files to the Monster-UI Webroot CSS path.
```
cd provisioner
\cp -rp brands/* /var/www/monster-ui/css/assets/brands/
\cp -rp models/* /var/www/monster-ui/css/assets/models/

```
8.   Inside the ***/var/www/env.php*** file; configure the CouchdB and postgresql connection parameters and ensure they are correct. For reaching fusionpbx's postgresql, you can use a SSH Forwarding. Also, you should also change fusionpbx's postgres listen address to other than 127.0.0.1 and allow queries from nginx webserver's IP by editing pg_hba.conf <br>
9. Configure sudo (visudo) to allow access from www-data (or apache) user without password
```
apache  ALL=(ALL)       NOPASSWD: ALL
```
10. Test The SmartPBX device additions (SmartPBX >> Devices >>  Add Devices) and ensure the phone brands/models are showing up correctly.
11. Copy prov-webhook.php to /var/www/html and env.php to /var/www Folders
12. Go to Master Account and configure webhooks (about 6 of them) to point to prov-webhook.php.<br>

   webhook A:<br>
   -Trigger Event = Object <br>
   -Request Type = POST <br>
   -URL: The prov-webhook php URL <br>
   -Body Format: JSON <br>
   -Custom Data >> Type: account >> Action: doc_created <br>
   <br>
   
   webhook B: <br>
   -Trigger Event = Object <br>
   -Request Type = POST  <br>
   -URL: The prov-webhook php URL <br>
   -Body Format: JSON  <br>
   -Custom Data >> Type: account >> Action: doc_edited  <br>
   <br>
   
   webhook C: <br>
   -Trigger Event = Object <br>
   -Request Type = POST  <br>
   -URL: The prov-webhook php URL <br>
   -Body Format: JSON  <br>
   -Custom Data >> Type: device >> Action: doc_created <br>
   <br>
   
   webhook D: <br>
   -Trigger Event = Object <br>
   -Request Type = POST <br>
   -URL: The prov-webhook php URL <br>
   -Body Format: JSON <br>
   -Custom Data >> Type: device >> Action: doc_edited <br>
   <br>

   webhook E: <br>
   -Trigger Event = Object <br>
   -Request Type = POST <br>
   -URL: The prov-webhook php URL <br>
   -Body Format: JSON <br>
   -Custom Data >> Type: device >> Action: doc_deleted <br>
   <br>

   webhook F: <br>
   -Trigger Event = Object <br>
   -Request Type = POST <br>
   -URL: The prov-webhook php URL <br>
   -Body Format: JSON <br>
   -Custom Data >> Type: account >> Action: doc_deleted <br>
   <br>

11. Enable the checkbox named 'Include Sub Accounts' to all of the webhooks. <br>
12. Now check everything by adding or editing account and phones on each of the tenants; if they are ok; head to fusionbpx webpanel and you will see the kazoo accounts and devices added with them. <br>
13. Combo/Feature Keys are able  to configure from kazoo to be replicated onto fusionpbx.  <br>
14. Kazoo SmartPBX includes combo_keys and feature_keys and they have about 4 key types: <br>
<br>
<p> - speed dial <br>
    - parking <br>
    - personal parking <br>
    - presence (BLF) <br>
    - line <br>
</p>
<br>     
    Go to FusionPBX's devices >> vendors >> Yealink (example) and put the values like the following: <br>
    'monitored call park' -> 10 <br>
    'none' -> 0 (with a space)
    Repeat same addition for each brand for this entry. The idea is create a kind of duplicate but with the key type changed as above <br>
15. Copy The 'creds' folder to the nginx server's webroot and add a nginx location block like the following: <br>

```
location /creds {
        rewrite $(.*)$ /creds/index.php ;
        }
```

16. Dont forget to edit the CORS headers at the beginning of the index files to your monster-ui base URL
17. Import the ***'https://github.com/fmateo05/monster-ui-fusionpbx-provisioner'*** and change folder as fusionpbx-provisioner
18. Edit the app.js and set up too look like the following: <br>

```
  requests: {
                'provisioner.devices.list': {
                apiRoot: 'https://prov.example.net/creds/',
                url: '{accountId}',
                verb: 'GET'
                    }
                },

```

19. Load the app page and you will see the provisioner URL; but first you should add a device inside the created account and after that the URL will be populated.
20. #### Configure DNS A records like the following <br>

```
*.prov.your-domain.tld IN A <IP of your fusionpbx instance>
*.sip.your-domain.tld IN A <IP of your kamailio instance(s)>

```

21. Then you can use the populated url to set it up on your DHCP-Option-66 capable router!! (Mine is some of ***Ubiquiti Edge Router X***)

