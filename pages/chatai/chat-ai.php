<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
   <head>
      <title>Trang Chủ | APIIT</title>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/header.php';?>
   </head>
   <body>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/nav.php';?>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/sidebar.php';?>
      <div class="startbar-overlay d-print-none"></div>
      <div class="page-wrapper">
         <div class="page-content">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Chat</h4>
                        <div class="">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="#">
                                    <i class="fa-solid fa-house me-1"></i> Trang chủ
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fa-solid fa-robot me-1"></i> Chat AI
                            </li>
                        </ol>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-12">
                     <div class="chat-box-left">
                        <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                           <li class="nav-item" role="presentation">
                              <a class="nav-link py-2 active"id="messages_chat_tab" data-bs-toggle="tab" href="#messages_chat" role="tab">AI Tư Vấn </a>
                           </li>
                        </ul>
                        <div class="chat-search p-3">
                           <div class="bg-light rounded">
                              <div class="input-group">
                                 <div class="input-group-prepend">
                                    <button id="button-addon2" type="submit" class="btn btn-link text-secondary"><i class="fa fa-search"></i></button>
                                 </div>
                                 <input type="search" placeholder="Searching.." aria-describedby="button-addon2" class="form-control border-0 bg-light ps-0">
                              </div>
                           </div>
                        </div>
                        <!--end chat-search-->
                        <div class="chat-body-left px-3" >
                           <div class="tab-content" id="pills-tabContent" >
                              <div class="tab-pane fade show active" id="messages_chat">
                                 <div class="row">
                                    <div class="col">
                                       <div class="p-2 border-dashed border-theme-color rounded mb-2">
                                          <a href="" class="">
                                             <div class="d-flex align-items-start">
                                                <div class="position-relative">
                                                   <img src="/core/upload/images/avata_ai.gif" alt="" class="thumb-lg rounded-circle">
                                                   <span class="position-absolute bottom-0 end-0"><i class="fa-solid fa-circle text-success fs-10 border-2 border-theme-color"></i></span>
                                                </div>
                                                <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                                   <h6 class="my-0 fw-medium text-dark fs-14">AI APIIT <img src="https://dichvuright.net/assets/images/tick-sp.png" height="20px" alt="">
                                                      <small class="float-end text-muted fs-11">Đang Hoạt Động</small>
                                                   </h6>
                                                </div>
                                             </div>
                                          </a>                                                    
                                       </div>
                                       <div class="alert alert-info py-2 px-2 mb-2" style="font-size: 13px;">
                                          <p class="mb-1">
                                             <i class="fa-solid fa-circle-info me-1"></i>
                                             <b>Lưu ý:</b> AI APIIT chỉ hỗ trợ tư vấn dịch vụ Cloud/VPS và Hosting/Cpanel.
                                             Vui lòng mô tả rõ nhu cầu để được đề xuất chuẩn nhất.
                                          </p>
                                          <p class="mb-0">
                                             <i class="fa-solid fa-triangle-exclamation me-1"></i>
                                             <b>Thông báo:</b> Đoạn chat sẽ <u>không được lưu lại</u> sau khi rời trang.
                                          </p>
                                       </div>
                                    </div>
                                 </div>          
                              </div>
                           </div>
                           <!--end tab-content-->
                        </div>
                     </div>
                     <div class="chat-box-right">
                        <div class="p-3 d-flex justify-content-between border-bottom">
                           <a href="" class="d-flex align-self-center">
                              <div class="flex-shrink-0">
                                 <img src="/core/upload/images/avata_ai.gif" alt="user" class="rounded-circle thumb-lg">
                              </div>
                              <div class="flex-grow-1 ms-2 align-self-center">
                                 <div>
                                    <h6 class="my-0 fw-medium text-dark fs-14">AI APIIT <img src="https://dichvuright.net/assets/images/tick-sp.png" height="20px" alt=""></h6>
                                    <p class="text-muted mb-0">Đang hoạt động</p>
                                 </div>
                              </div>
                           </a> 
                        </div>
                        <div class="chat-body" data-simplebar>
                           <div class="chat-detail" id="chatDetail">
                           </div>
                        </div>
                        
                        <div class="chat-footer border-top">
                        <div class="row">
                           <div class="col-9">
                              <input id="chatInput" type="text" class="form-control" placeholder="Nhập câu hỏi...">
                           </div>
                           <div class="col-3 text-end">
                              <div id="chatSend" class="chat-features" style="cursor:pointer;">
                                    <i class="iconoir-send-solid"></i>
                              </div>
                           </div>
                        </div>
                        </div>
                     </div>
                  </div>
                  <!-- end col -->                           
               </div>
               <!-- end row -->                                        
            </div>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/app/footer.php';?>
         </div>
      </div>
      <?php require $_SERVER['DOCUMENT_ROOT'].'/app/script.php';?>
      <script>
         function scrollToBottom() {
            const chat = document.getElementById("chatDetail");
            setTimeout(() => {
                chat.scrollTop = chat.scrollHeight;
            }, 50); 
        }
        let conversationId = null;
         async function askAI(question) {
            try {
                const res = await fetch("/ai.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ msg: question , conversation_id: conversationId })
                });
                const text = await res.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    return "Có lỗi xảy ra. Vui lòng F5 lại trang!";
                }
                if (data.error || data.response === undefined) {
                    return "Hệ thống đang quá tải. Vui lòng F5 lại trang!";
                }
                if (data.conversation_id) {
                     conversationId = data.conversation_id;
                  }
                return data.response;
            } catch (e) {
                return "Mất kết nối API. Vui lòng F5 lại trang!";
            }
        }
         function appendMessage(text, type = "user") {
             const chat = document.getElementById("chatDetail");
             let html = "";
             if (type === "user") {
                 html = `
                 <div class="d-flex flex-row-reverse">
                     <img src="/core/upload/images/avata_user.jpg" class="rounded-circle thumb-md">
                     <div class="me-1 chat-box w-100 reverse">
                         <div class="user-chat"><p>${text}</p></div>
                     </div>
                 </div>`;
             } else {
                 html = `
                 <div class="d-flex">
                     <img src="/core/upload/images/avata_ai.gif"
                     class="rounded-circle thumb-md">
                     <div class="ms-1 chat-box w-100">
                         <div class="user-chat"><p>${text}</p></div>
                     </div>
                 </div>`;
             }
             chat.insertAdjacentHTML("beforeend", html);
             scrollToBottom();
         }
         function appendTyping() {
             const chat = document.getElementById("chatDetail");
             const html = `
             <div class="d-flex typing-bubble" id="typingBubble">
                 <img src="/core/upload/images/avata_ai.gif"
                     class="rounded-circle thumb-md">
                 <div class="ms-1 chat-box w-100">
                     <div class="user-chat">
                         <div class="typing-indicator">
                             <div class="typing-dot"></div>
                             <div class="typing-dot"></div>
                             <div class="typing-dot"></div>
                         </div>
                     </div>
                 </div>
             </div>
             `;
             chat.insertAdjacentHTML("beforeend", html);
             scrollToBottom();
         }
         async function sendMessage() {
             const input = document.getElementById("chatInput");
             const msg = input.value.trim();
             if (!msg) return;
             appendMessage(msg, "user");
             input.value = "";
             appendTyping(); 
             const reply = await askAI(msg);
             const chat = document.getElementById("chatDetail");
             const typing = document.getElementById("typingBubble");
             if (typing) typing.remove();
         
             appendMessage(reply.replace(/\n/g, "<br>"), "bot");
         }
        
         window.addEventListener("load", async function () {
            setTimeout(async () => {
                appendTyping();
                const reply = await askAI("Hãy gửi lời chào khách hàng");
                const typing = document.getElementById("typingBubble");
                if (typing) typing.remove();
                appendMessage(reply.replace(/\n/g, "<br>"), "bot");
            }, 300);
        });
         document.getElementById("chatInput").addEventListener("keypress", function(e) {
             if (e.key === "Enter") sendMessage();
         });
         document.getElementById("chatSend").addEventListener("click", sendMessage);
      </script>
      <style>
         .typing-indicator {
         display: inline-flex;
         align-items: center;
         gap: 3px;
         }
         .typing-dot {
         width: 6px;
         height: 6px;
         border-radius: 50%;
         background: #999;
         animation: blink 1.4s infinite both;
         }
         .typing-dot:nth-child(2) { animation-delay: 0.2s; }
         .typing-dot:nth-child(3) { animation-delay: 0.4s; }
         @keyframes blink {
         0% { opacity: .2; }
         20% { opacity: 1; }
         100% { opacity: .2; }
         }

      </style>
   </body>
</html>