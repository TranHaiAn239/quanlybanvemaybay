<x-filament::page>
    <div class="bg-white shadow-lg rounded-lg border border-gray-200">

        <div x-data="adminChat()" class="flex flex-col" style="height: 600px;">

            <div class="bg-red-600 p-4 flex justify-between items-center text-white shadow-md flex-shrink-0" style="height: 60px;">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-red-600 font-bold text-sm">
                        AI
                    </div>
                    <span class="font-bold text-lg uppercase tracking-wide">Trợ lý Admin</span>
                </div>
            </div>

            <div id="admin-chat-messages"
                 style="flex-grow: 1; padding: 16px; overflow-y: auto; background-color: #f9fafb; display: flex; flex-direction: column; gap: 12px; min-height: 0;">

                <div style="align-self: flex-start; background-color: white; border: 1px solid #e5e7eb; padding: 12px; border-radius: 18px 18px 18px 2px; max-width: 85%; font-size: 14px; color: #374151; word-wrap: break-word;">
                    Chào sếp! Hệ thống giám sát gian lận và phân tích doanh thu đã sẵn sàng.
                </div>

                <template x-for="msg in messages">
                    <div :style="{
                            alignSelf: msg.isUser ? 'flex-end' : 'flex-start',
                            maxWidth: '85%',
                            minWidth: '0'
                         }">
                        <div :style="{
                                backgroundColor: msg.isUser ? '#dc2626' : 'white',
                                color: msg.isUser ? 'white' : '#374151',
                                border: msg.isUser ? 'none' : '1px solid #e5e7eb',
                                borderRadius: msg.isUser ? '18px 2px 18px 18px' : '18px 18px 18px 2px',
                                padding: '12px',
                                fontSize: '14px',
                                lineHeight: '1.5',
                                wordBreak: 'break-word',
                                overflowWrap: 'anywhere',
                                whiteSpace: 'pre-wrap'
                            }"
                            x-html="msg.text">
                        </div>
                    </div>
                </template>

                <div x-show="isLoading" style="font-size: 12px; color: #9ca3af; font-style: italic; margin-left: 10px;">
                    Đang phân tích dữ liệu...
                </div>
            </div>

            <div style="padding: 12px; background-color: white; border-top: 1px solid #e5e7eb; display: flex; gap: 8px; flex-shrink: 0; box-sizing: border-box;">
                <input type="text" x-model="userInput" @keydown.enter.prevent="sendMessage" placeholder="Nhập lệnh (vd: check gian lận)..."
                       style="flex: 1; background-color: #f3f4f6; border: 1px solid #d1d5db; border-radius: 9999px; padding: 10px 16px; font-size: 14px; outline: none; color: #1f2937; min-width: 0;">
                <button @click="sendMessage" style="background-color: #dc2626; color: white; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    ➤
                </button>
            </div>

        </div>
    </div>

    {{-- Script Alpine.js --}}
    <script>
        function adminChat() {
            return {
                isOpen: true, // Luôn mở vì đây là trang riêng
                isLoading: false,
                userInput: '',
                messages: [],

                // Hàm cuộn xuống đáy
                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = document.getElementById('admin-chat-messages');
                        if (container) {
                            container.scrollTop = container.scrollHeight;
                        }
                    });
                },

                // Khởi tạo và cuộn xuống
                init() {
                    this.scrollToBottom();
                },

                sendMessage() {
                    const text = this.userInput.trim();
                    if (!text) return;

                    this.messages.push({ text: text, isUser: true });
                    this.userInput = '';
                    this.isLoading = true;
                    this.scrollToBottom();

                    fetch('{{ route("admin.chatbot") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ message: text })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.messages.push({ text: data.reply, isUser: false });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.messages.push({ text: "Lỗi kết nối hệ thống.", isUser: false });
                    })
                    .finally(() => {
                        this.isLoading = false;
                        this.scrollToBottom();
                    });
                }
            }
        }
    </script>
</x-filament::page>
