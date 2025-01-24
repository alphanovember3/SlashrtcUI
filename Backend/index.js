const express = require('express');
const { join } = require('node:path');
const  http  = require('http');
const { Server } = require('socket.io');
const cors = require('cors');
const { MongoClient } = require("mongodb");
const connection = require('./connection');
const myFirstQueue = require('./bullReceiver')

const app = express();
app.use(cors());
const server = http.createServer(app)
const io = new Server(server , {
  cors: {
    origin: "http://localhost:8080",
    methods: ["GET", "POST"],
  }
});

let db; 

connection().then(database => { 
  db = database; 
  // Ensure that the server starts only after the database connection is established 
  server.listen(3000, () => console.log(`Server started`));
});




io.on('connection',(socket)=>{

  socket.on('logged',(username)=>{
    console.log(username+" user connectied");
  })


  socket.on('joinRoom',async ({sender , receiver})=>{
    const room = [sender , receiver].sort().join('-');
    socket.join(room);
    console.log(`User ${sender} joined room: ${room}`);
    try{
      const messages = await db.collection('messages').find({
        $or: [
          { sender, receiver },
          { sender: receiver, receiver: sender }
        ],
      }).sort({ timestamp: 1 }).toArray();
      // console.log(messages);
      socket.emit("previousMessages", messages);
    }catch(err){
      console.log(err);
    }
  })

  socket.on('sendMsg', ({sender , receiver , message})=>{
    try{
      const room = [sender , receiver].sort().join('-');
      console.log(room)
      const msg = {
        sender , 
        receiver ,
        message ,
        timestamp: new Date().getTime(),
      }
      //sending message in bullQ
      myFirstQueue.add(msg);
      // db.collection('messages').insertOne(msg);
      io.to(room).emit('chat_msg',msg);
      }catch(err){
        console.log(err);
      }
    });
    socket.on('disconnect', () => {
      console.log('user disconnected');
    });
})
