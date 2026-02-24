const mysql     = require('mysql2');
let server      = require('ws').Server;
let websocket   = new server({ port : 10000 });

const con       = mysql.createConnection({
  host: "localhost",
  user: "root",
  password : "Mysql@123",
  database:"projectapp"
});

con.connect(function(err) {
    if (err) throw err;
    console.log("connected to database!");
  });
  

  let CLIENTS       = [];
  let CLIENTS_req   = [];

