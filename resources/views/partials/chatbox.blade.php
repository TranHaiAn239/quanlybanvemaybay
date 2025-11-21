<!-- Chatbox Widget HTML -->
<div id="ai-chat-widget" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; font-family: sans-serif;">

    <!-- Nút mở chat -->
    <button id="ai-chat-toggle" onclick="toggleChat()" style="width: 60px; height: 60px; border-radius: 50%; background: #007bff; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.2); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: transform 0.2s;">
        <!-- Icon Chat -->
        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
    </button>

    <!-- Khung chat -->
    <div id="ai-chat-box" style="display: none; width: 350px; height: 450px; background: white; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.2); flex-direction: column; overflow: hidden; position: absolute; bottom: 80px; right: 0;">

        <!-- Header -->
        <div style="background: #007bff; padding: 15px; color: white; font-weight: bold; display: flex; justify-content: space-between; align-items: center;">
            <span>Trợ lý ảo Vé Máy Bay</span>
            <span onclick="toggleChat()" style="cursor: pointer; font-size: 20px;">&times;</span>
        </div>

        <!-- Nội dung chat -->
        <div id="ai-chat-messages" style="flex: 1; padding: 15px; overflow-y: auto; background: #f8f9fa; display: flex; flex-direction: column; gap: 10px;">
            <!-- Tin nhắn chào mừng -->
            <div style="align-self: flex-start; background: #e9ecef; padding: 8px 12px; border-radius: 15px 15px 15px 0; max-width: 80%; color: #333;">
                Xin chào! Tôi là AI hỗ trợ đặt vé. Bạn cần tìm vé đi đâu?
            </div>
        </div>

        <!-- Input Area -->
        <div style="padding: 10px; border-top: 1px solid #eee; display: flex; gap: 5px; background: white;">
            <input type="text" id="ai-chat-input" placeholder="Nhập tin nhắn..." onkeypress="handleEnter(event)" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 20px; outline: none;">
            <button onclick="sendMessage()" style="background: #007bff; color: white; border: none; padding: 0 15px; border-radius: 20px; cursor: pointer;">Gửi</button>
        </div>
    </div>
</div>

<script>
    // Hàm bật/tắt khung chat
    function toggleChat() {
        const chatBox = document.getElementById('ai-chat-box');
        if (chatBox.style.display === 'none' || chatBox.style.display === '') {
            chatBox.style.display = 'flex';
        } else {
            chatBox.style.display = 'none';
        }
    }

    // Xử lý phím Enter
    function handleEnter(e) {
        if (e.key === 'Enter') sendMessage();
    }

    // Hàm gửi tin nhắn
    async function sendMessage() {
        const input = document.getElementById('ai-chat-input');
        const messages = document.getElementById('ai-chat-messages');
        const text = input.value.trim();

        if (!text) return;

        // 1. Hiển thị tin nhắn người dùng
        messages.innerHTML += `
            <div style="align-self: flex-end; background: #007bff; color: white; padding: 8px 12px; border-radius: 15px 15px 0 15px; max-width: 80%; margin-bottom: 5px; word-wrap: break-word;">
                ${text}
            </div>
        `;
        input.value = '';
        messages.scrollTop = messages.scrollHeight;

        // 2. Hiển thị "Đang gõ..."
        const loadingId = 'loading-' + Date.now();
        messages.innerHTML += `
            <div id="${loadingId}" style="align-self: flex-start; background: #e9ecef; padding: 8px 12px; border-radius: 15px 15px 15px 0; color: #666; font-style: italic; font-size: 12px;">
                Đang trả lời...
            </div>
        `;

        try {
            // 3. Gọi file PHP trong thư mục public (đã tạo ở Bước 1)
            const response = await fetch('/chatbot_gemini.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: text })
            });

            const data = await response.json();

            // Xóa "Đang gõ..."
            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) loadingEl.remove();

            // 4. Hiển thị câu trả lời của AI
            // Chuyển đổi xuống dòng thành thẻ <br> và in đậm **text** thành <b>text</b>
            let replyText = data.reply || "Xin lỗi, tôi không nhận được phản hồi.";
            replyText = replyText.replace(/\n/g, '<br>');
            replyText = replyText.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>'); // Format in đậm markdown

            messages.innerHTML += `
                <div style="align-self: flex-start; background: #e9ecef; padding: 8px 12px; border-radius: 15px 15px 15px 0; max-width: 80%; color: #333; line-height: 1.4; word-wrap: break-word;">
                    ${replyText}
                </div>
            `;

        } catch (error) {
            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) loadingEl.remove();

            messages.innerHTML += `
                <div style="align-self: flex-start; background: #ffebee; color: #c62828; padding: 8px 12px; border-radius: 15px;">
                    Lỗi kết nối: ${error.message}
                </div>
            `;
        }

        messages.scrollTop = messages.scrollHeight;
    }
</script>
