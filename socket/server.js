const mysql     = require('mysql2');
let server      = require('ws').Server;
let sockServer   = new server({ port : 10000 });

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
function kirimKeSemua(msg) {
    for(let i = 0; i < CLIENTS.length; i++){
        if(CLIENTS[i]?.readyState === 1) {
            CLIENTS[i].send(msg);
        }
    }
}

function validasiToken(token, callback){
    con.query("SELECT * FROM tbl_users WHERE token = ? ", [token], (err, result) => {
      callback(result.length > 0);
  })
}
  sockServer.on('connection', function(ws,req){
    const url       = new URL(req.url, `http://${req.headers.host}`);
    const token     = url.searchParams.get('token');
    const path      = url.pathname;
    const kodeTemp  = url.searchParams.get('kodeTemp');
    const userId    = url.searchParams.get('userId');
  
      ws.path     = path;
      ws.kodeTemp = kodeTemp;
      ws.userId   = userId;

      validasiToken(token, (valid) => {
        if(!valid){
                ws.send("User tidak valid");
                ws.close();
                return;
        }
      });
    
      CLIENTS.push(ws);
      console.log("Client masuk:", userId);
      console.log("Total client:", CLIENTS.length);
    
      ws.on('message', function incoming_data(data){
          let msg   = JSON.parse(data);
          const act = msg.action;
          switch(act){
            case 'savePesanan':
              simpanPesanan(msg,ws,req);
            break;
            case 'updatePesanan' :
              updatePesanan(msg,ws,req);
            break;
          }
      });

      ws.on('close', function() {
        const index = CLIENTS.indexOf(ws);
        if(index > -1){
          CLIENTS.splice(index, 1);
          console.log("Client keluar:", userId, "| Total:", CLIENTS.length);
        }
      });

      
  })

 function queryPromise(sql, params = []){
  return new Promise((resolve,reject) => {
    con.query(sql, params, (err,result) => {
      if(err) reject(err);
      else resolve(result);
    })
  })
 }

 const simpanPesanan = async(msg,ws,req) => {
  try{
    const kodeTempat = msg.kodeTemp;
    const pelanggan  = msg.namaPelanggan;
    let date    = new Date();
    const alldate = date.toLocaleDateString('id-ID',{
      day: '2-digit',
      month: '2-digit',
      year: 'numeric'
    });
    const date2 = alldate.split('/').join(''); 
    const newInisial = date2+kodeTempat+'J';
    const code = await autocode('tblPenjualan',newInisial,18,1,'kode_temp','tglTrans',kodeTempat);
    const multipleInput             = `INSERT INTO tmp_penjualan(kode_temp,no_penjualan,user,kode_meja,kode_item,nama_item,harga_jual,diskon,qty,total) VALUES ?`;
    const queryTmpPesanan           = `SELECT * FROM tmp_pesanan WHERE kode_temp=? AND user=? AND kode_meja=?`;
    
    const sumSubtotal             = [];
    const valuesTmp_penjualan     = [];
    
    const resultPesanan  = await queryPromise(queryTmpPesanan,[kodeTempat,msg.user,msg.meja]);
    resultPesanan.forEach((item) => {
        const kodeTemp = item.kode_temp;
        const user     = item.user;
        const kodeMeja = item.kode_meja;
        const kodeItem = item.kode_item;
        const namaItem = item.nama_item;
        const harga    = item.harga_jual;
        const diskon   = item.diskon;
        const qty      = item.qty;
        const tot      = item.total;
        const objectInput = [kodeTemp,code,user,kodeMeja,kodeItem,namaItem,harga,diskon,qty,tot];
        valuesTmp_penjualan.push(objectInput);
        sumSubtotal.push(tot);
        con.query(`UPDATE tabel_item SET stok = stok - '${qty}' WHERE kode_temp = '${kodeTemp}' AND kode_item = '${kodeItem}'`);
      
      })
        
         let insertSubtotal = sumSubtotal.reduce((a,b) => a + b,0);
         const dateTime      = mysqlDateTime();
         const query_single_input = `INSERT INTO tblPenjualan(kode_temp,no_penjualan,namaPelanggan,user_id,subtotal,keterangan,status,statPesanan,tglTrans) VALUES (?,?,?,?,?,?,?,?,?)`;
         const inserTblPejualan = await queryPromise(query_single_input,[kodeTempat,code,pelanggan,msg.user,insertSubtotal,msg.catatan,"belum bayar","belum dimasak",dateTime]);                           
         const multiInsert      = await queryPromise(multipleInput,[valuesTmp_penjualan]);
         const deleteTmpPesanan = await queryPromise("DELETE FROM tmp_pesanan WHERE kode_temp = ? AND user = ? AND kode_meja = ?",[kodeTempat,msg.user,msg.meja]);
         
        CLIENTS.forEach((item,index) => {
            if(item.kodeTemp == kodeTempat && item.userId == msg.user && item.path == ws.path){
                item.send('berhasil');
            }else if(item.kodeTemp == kodeTempat && item.path == "/dapur"){
                item.send('order baru masuk');
            }
        })
        
   
  }catch(e){
    console.error(e);
  }    
 }

 const updatePesanan =async(msg,ws,req) => {
   const kodeTempat   = msg.kodeTemp;
   const user         = msg.user;
   const noPenjualan  = msg.noPenjualan;
   const query        = `UPDATE tblPenjualan set statPesanan='sudah dimasak' WHERE kode_temp=? AND no_penjualan=? `;
   const update       = await queryPromise(query, [kodeTempat, noPenjualan]);
   console.log('update');
   CLIENTS.forEach((item,index) => {
    if(item.kodeTemp == kodeTempat && item.userId == user && item.path == ws.path){
      item.send('update sukses');
    }
   })
 }
 const mysqlDateTime = () => {
   const now = new Date();
   const year = now.getFullYear();
   const month = String(now.getMonth() + 1).padStart(2, '0');
   const day = String(now.getDate()).padStart(2, '0');
   const hours = String(now.getHours()).padStart(2, '0');
   const minutes = String(now.getMinutes()).padStart(2, '0');
   const seconds = String(now.getSeconds()).padStart(2, '0');
  return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
 }

  async function autocode(table,inisial,jml_str,urutan,firstfield,secondfield,value1){
  //MEMBUAT PROMISE AGAR NILAI DAPAT DI RETURN
  return new Promise((resolve,reject) => {
    setTimeout(() => {
      let date    = new Date();
      const alldate = date.toLocaleDateString('fr-CA');
      const whr     = `${firstfield}='${value1}' AND DATE(${secondfield}) = DATE('${alldate}')`;
      const sql_query = "SELECT * FROM "+table+" WHERE "+ whr;
      con.query(sql_query ,function(err,result,fields) {
        if (err){
          reject(err);
        } 
         const fil                   = fields[urutan].name;
         const sql_query_max_field   = "SELECT MAX("+fil+") AS max_value FROM "+table+" WHERE "+ whr;
         con.query(sql_query_max_field, function(err,result,fields){
          if (err){
                reject(err);
             } 
           
              let angka                   = "";
              let jumlah_string           = "";
              const jumlah_inisial        = inisial.length;
              let kode                    = result[0].max_value;
              if(kode == null){
                     jumlah_string              = jml_str;
                     angka                      = 0;
              }else{
                  
                  jumlah_string              = kode.length;
                  angka                      = kode.substr(jumlah_inisial,jumlah_string);
              }
           let tmp                     = "";
           angka++;

           for(let i = 0; i < (jumlah_string - jumlah_inisial -angka.toString().length); i++){
            tmp = tmp+"0";
          }

          resolve(inisial+tmp+angka);
         });
         
      })
        },100);

  })

}