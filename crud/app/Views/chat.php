<html>
  
<head>

  <link rel="stylesheet" href="assets/css/chat.css">
  <style>
 
 body {
    height: 100vh;
    background-image: url('https://codetheweb.blog/assets/img/posts/css-advanced-background-images/mountains.jpg');
    background-size: 2000px;
    background-position-x: center; 
    background-position-y: center; 
}

  </style>

</head>

<body>



  <div class="container">
    <!-- Main Chat Screen -->
    <div id="chat-screen" style="width: 1000px; height:660px">
      <!-- Sidebar -->
      <div class="sidebar">
        <div class="user-profile">
          <div>
            <img class="small-profile" src="assets/user2.png" alt="User Avatar">
            <span style="font-size: 20px; font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif"><?= $loginDetails['firstname'] ?></span>
          </div>
          <span id="chat-mode"></span>

        </div>
        <ul id="users-list">
          <?php foreach ($userData as $user) {
            if ($user['firstname'] === $loginDetails['firstname']) {
              continue;
            }
          ?>
            <li id="agent-list" class="user" data-username="<?= $user['firstname'] ?>">
              <img class="small-profile" src="assets/user3.jpg" alt="User Avatar">
              <div class="user-info ">
                <span id="userheader" style="font-size: 20px;"><?= $user['firstname'] ?></span>
                <small></small>
              </div>
            </li>
          <?php } ?>
        </ul>
      </div>
      <!-- Chat Area -->
      <div class="chat-area">
        <div class="chat-header">
          <div>
            <img class="small-profile" src="assets/user3.jpg" alt="User Avatar">
            <span id="receiverUser" style="font-size: 20px;"><?= $loginDetails['firstname'] ?> </span>
          </div>
          <span id="chat-mode">Ch@tgr@m</span>
        </div>
        <div id="messages" class="messages-container"></div>
        <div class="message-input">
          <input type="text" id="message-input" placeholder="Type a message...">
          <button id="send-btn">Send</button>
        </div>
      </div>
    </div>
  </div>




  <script src="https://cdn.socket.io/4.8.1/socket.io.min.js" integrity="sha384-mkQ3/7FUtcGyoppY6bz/PORYoGqOl7/aSUMn2ymDOJcapfS6PHqxhRTMh1RR0Q6+" crossorigin="anonymous"></script>
  

  <script>
    var socket = io.connect('http://localhost:3000');
    var chatScreen = document.getElementById('chat-screen');
    var chatMode = document.getElementById('chat-mode');
    var messageInput = document.getElementById('message-input');
    var sendBtn = document.getElementById('send-btn');
    var messagesContainer = document.getElementById('messages');
    var usersList = document.getElementById('users-list');
    var currentUser = document.getElementById('current-user');
    var chatHeader = document.getElementById('chat-header');
    var chatArea = document.getElementById('chat-area');
    var agentList = document.querySelectorAll('agent-list');

    const sender = "<?= $loginDetails['firstname'] ?>";
    let receiver = null;

    socket.emit('logged', sender)

    document.querySelectorAll('#agent-list').forEach(user => {
      user.addEventListener('click', () => {
        receiver = user.getAttribute("data-username");
        console.log(sender);
        document.getElementById('receiverUser').innerHTML = receiver
        // document.querySelector('.receiver').textContent = currentReceiver;
        messagesContainer.innerHTML = '';
        socket.emit('joinRoom', {
          sender,
          receiver
        });
      });
    });

    function sendMsg() {
      const message = messageInput.value.trim();
      if (message && receiver) {
        socket.emit('sendMsg', {
          sender: sender,
          receiver: receiver,
          message: message
        });
        messageInput.value = '';
      }
    }

    socket.on('previousMessages', (messages) => {

      const chatHistory = document.getElementById('messages');
      chatHistory.innerHTML = '';
      console.log(messages);
      messages.forEach(msg => {
        console.log(msg.sender)
        const messageElement = document.createElement('div');
        messageElement.className = `message ${msg.sender === sender ? 'sent' : 'received'}`;
        messageElement.innerHTML = `${msg.message}<span class="time_date"> 11:01 AM    |    June 9</span></div>`;
        chatHistory.appendChild(messageElement);
      });
      chatHistory.scrollTop = chatHistory.scrollHeight;
    });

    sendBtn.addEventListener('click', sendMsg);
    messageInput.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') {
        sendMsg();
      }
    });


    socket.on("chat_msg", (data) => {
      const messages = document.getElementById("messages");
      const msgElement = document.createElement("div");
      msgElement.className = `message ${data.sender === sender ? 'sent' : 'received'}`;
      msgElement.textContent = `${data.message}`;
      messages.appendChild(msgElement);
      messages.scrollTop = messages.scrollHeight;
    });
  </script>

</body>

</html>
