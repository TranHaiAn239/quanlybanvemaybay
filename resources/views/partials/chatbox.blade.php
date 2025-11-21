<div x-data="chatBot()" x-init="initChat()" class="fixed bottom-5 right-5 z-50 flex flex-col items-end font-sans">

    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="bg-white w-full sm:w-96 h-[500px] rounded-2xl shadow-2xl border border-gray-200 flex flex-col overflow-hidden mb-4">

        <div class="bg-blue-600 p-4 flex justify-between items-center text-white shadow-md">
            <div class="flex items-center space-x-2">
                <div class="relative">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-600 font-bold border-2 border-blue-200">
                        AI
                    </div>
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <h3 class="font-bold text-lg">Trợ lý Vé Máy Bay</h3>
                    <p class="text-xs text-blue-100 flex items-center">
                        <span class="mr-1">●</span> Đang hoạt động
                    </p>
                </div>
            </div>

            <button @click="isOpen = false" class="text-white hover:bg-blue-700 rounded-full p-1 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto bg-gray-50 space-y-4 scroll-smooth">

            <div class="flex justify-start">
                <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-gray-100 text-sm text-gray-800 max-w-[85%]">
                    Xin chào! Em là trợ lý ảo AI. Anh/chị cần tìm vé đi đâu, ngày nào, hay cần hỗ trợ gì cứ nhắn em nhé! 😊
                </div>
            </div>

            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.isUser ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.isUser
                        ? 'bg-blue-600 text-white rounded-tr-none'
                        : 'bg-white text-gray-800 border border-gray-100 rounded-tl-none'"
                         class="p-3 rounded-2xl shadow-sm text-sm max-w-[85%] whitespace-pre-wrap"
                         x-html="msg.text">
                    </div>
                </div>
            </template>

            <div x-show="isLoading" class="flex justify-start">
                <div class="bg-gray-200 p-3 rounded-2xl rounded-tl-none space-x-1 flex items-center h-10">
                    <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                </div>
            </div>
        </div>

        <div class="p-3 bg-white border-t border-gray-100">
            <form @submit.prevent="sendMessage" class="flex items-center space-x-2">
                <input type="text" x-model="userInput"
                       placeholder="Nhập câu hỏi..."
                       class="flex-1 border-gray-200 rounded-full focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-2 px-4 text-sm bg-gray-50"
                       :disabled="isLoading">

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full shadow-md transition transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="isLoading || !userInput.trim()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <button @click="isOpen = !isOpen"
            class="group flex items-center justify-center w-14 h-14 bg-blue-600 text-white rounded-full shadow-2xl hover:bg-blue-700 transition-all transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-blue-300">

        <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>

        <svg x-show="isOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>

        <span class="absolute right-full mr-3 bg-gray-900 text-white text-xs font-medium px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
            Chat hỗ trợ
        </span>
    </button>

</div>

<script>
    function chatBot() {
        return {
            isOpen: false,
            isLoading: false,
            userInput: '',
            messages: [],

            initChat() {
                // Tự động cuộn xuống khi mở
                this.$watch('isOpen', value => {
                    if (value) this.scrollToBottom();
                });
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    const container = document.getElementById('chat-messages');
                    if(container) container.scrollTop = container.scrollHeight;
                });
            },

            sendMessage() {
                const text = this.userInput.trim();
                if (!text) return;

                // 1. Hiển thị tin nhắn người dùng
                this.messages.push({ text: text, isUser: true });
                this.userInput = '';
                this.isLoading = true;
                this.scrollToBottom();

                // 2. Gửi API đến Laravel (DÙNG ROUTE MỚI)
                fetch('{{ route("chatbot.handle") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        // CSRF Token bắt buộc của Laravel
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message: text })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Lỗi kết nối');
                    return response.json();
                })
                .then(data => {
                    // 3. Hiển thị phản hồi từ AI
                    this.messages.push({ text: data.reply, isUser: false });
                })
                .catch(error => {
                    console.error('Chatbot Error:', error);
                    this.messages.push({ text: "Xin lỗi, hệ thống đang bận. Vui lòng thử lại sau.", isUser: false });
                })
                .finally(() => {
                    this.isLoading = false;
                    this.scrollToBottom();
                });
            }
        }
    }
</script>
