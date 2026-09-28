{{--
    Chatbot floating widget.
    - session_id generated once in localStorage, reused across tabs/reloads
    - History loaded lazily on first open (not on every page load)
    - User messages rendered with x-text (XSS-safe)
    - Bot messages rendered with x-text (XSS-safe)
    - Reuses <x-spinner> component for the send-button loading state
    - Responsive: full-width bottom-sheet on mobile, floating card on sm+
--}}
<div id="chatbot"
     x-data="chatbot()"
     class="fixed bottom-5 right-5 z-50 flex flex-col items-end gap-3
            max-sm:bottom-0 max-sm:right-0 max-sm:left-0 max-sm:items-stretch">

    {{-- ── Chat window ──────────────────────────────────────────────────── --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="chatbot-window w-80 sm:w-96 bg-gray-900 border border-gray-700 rounded-2xl shadow-2xl flex flex-col overflow-hidden
                max-sm:w-full max-sm:rounded-b-none max-sm:rounded-t-2xl max-sm:border-x-0 max-sm:border-b-0
                max-h-[520px] max-sm:max-h-[70vh]"
         x-cloak>

        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 bg-indigo-700 shrink-0">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                <span class="text-white text-sm font-semibold">FanHub Assistant</span>
            </div>
            <div class="flex items-center gap-3">
                <button @click="clearChat()" title="Clear chat"
                        class="text-indigo-200 hover:text-white transition text-xs">Clear</button>
                <button @click="open = false"
                        class="text-indigo-200 hover:text-white transition"
                        aria-label="Close chat">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Messages --}}
        <div id="chatMessages" class="flex-1 overflow-y-auto px-4 py-3 space-y-3 text-sm">

            {{-- Empty state --}}
            <div x-show="messages.length === 0 && !typing && !loading"
                 class="chatbot-empty-state text-center text-gray-500 text-xs py-6">
                👋 Hi! Ask me anything about FanHub+.
                <div class="mt-3 flex flex-wrap justify-center gap-2">
                    <button type="button" @click="input = 'Recommend anime for me'" class="fh-chat-prompt">Recommend anime</button>
                    <button type="button" @click="input = 'What is trending?'" class="fh-chat-prompt">What’s trending?</button>
                    <button type="button" @click="input = 'Events near me this weekend'" class="fh-chat-prompt">Events this weekend</button>
                </div>
            </div>

            {{-- Loading history spinner --}}
            <div x-show="loading" class="flex justify-center py-4">
                <x-spinner size="md" class="border-gray-600 border-t-indigo-400" />
            </div>

            <template x-for="(msg, i) in messages" :key="i">
                <div :class="msg.sender === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    {{-- User messages: x-text (XSS-safe, no HTML rendered) --}}
                    <div x-show="msg.sender === 'user'"
                         x-text="msg.message"
                         class="chatbot-user-message bg-indigo-600 text-white rounded-2xl rounded-tr-sm px-3 py-2 max-w-[80%] break-words whitespace-pre-wrap">
                    </div>
                    <div x-show="msg.sender === 'bot'"
                         x-html="renderChatMarkdown(msg.message)"
                         class="chatbot-bot-message bg-gray-800 text-gray-200 rounded-2xl rounded-tl-sm px-3 py-2 max-w-[85%] break-words whitespace-pre-wrap">
                    </div>
                    <div x-show="msg.sender === 'bot' && msg.id" class="fh-chat-feedback">
                        <button type="button" @click="rateMessage(msg, 1)" aria-label="Helpful response">👍</button>
                        <button type="button" @click="rateMessage(msg, -1)" aria-label="Unhelpful response">👎</button>
                        <span x-show="msg.feedback" role="status">Thanks for your feedback</span>
                    </div>
                </div>
            </template>

            {{-- Typing indicator --}}
            <div x-show="typing" class="flex justify-start">
                <div class="chatbot-typing bg-gray-800 rounded-2xl rounded-tl-sm px-4 py-3 flex gap-1">
                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay:300ms"></span>
                </div>
            </div>
        </div>

        {{-- Input --}}
        <div class="px-3 py-3 border-t border-gray-800 shrink-0">
            <form @submit.prevent="sendMessage()" class="flex gap-2">
                <input x-model="input"
                       type="text"
                       placeholder="Type a message…"
                       maxlength="1000"
                       aria-label="Chat message input"
                       class="flex-1 bg-gray-800 border border-gray-700 text-white text-sm rounded-xl px-3 py-2
                              focus:outline-none focus:border-indigo-500"
                       :disabled="typing" />
                <button type="submit"
                        :disabled="!input.trim() || typing"
                        class="px-3 py-2 bg-indigo-600 hover:bg-indigo-500 disabled:opacity-40 text-white rounded-xl transition flex items-center justify-center w-10"
                        aria-label="Send message">
                    {{-- Spinner shown while waiting for reply --}}
                    <span x-show="typing">
                        <x-spinner size="sm" />
                    </span>
                    {{-- Send icon when idle --}}
                    <span x-show="!typing">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    </div>

    {{-- ── Toggle button ────────────────────────────────────────────────── --}}
    <button @click="toggle()"
            data-chatbot-toggle
            aria-label="Toggle chat assistant"
            class="w-14 h-14 bg-indigo-600 hover:bg-indigo-500 text-white rounded-full shadow-lg
                   flex items-center justify-center transition-all duration-200 hover:scale-110 relative
                   max-sm:self-end max-sm:mr-5 max-sm:mb-5">
        <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z"/>
        </svg>
        <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        {{-- Unread badge --}}
        <span x-show="unread > 0 && !open"
              class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center"
              x-text="unread" x-cloak></span>
    </button>
</div>

@push('scripts')
<script>
function chatbot() {
    return {
        open:      false,
        input:     '',
        messages:  [],
        typing:    false,
        loading:   false,
        unread:    0,
        historyLoaded: false,
        sessionId: null,

        init() {
            // Retrieve or generate an anonymous session ID (stable across tabs)
            this.sessionId = localStorage.getItem('chat_session_id');
            if (!this.sessionId) {
                this.sessionId = (window.crypto?.randomUUID
                    ? window.crypto.randomUUID()
                    : Math.random().toString(36).slice(2) + Date.now().toString(36));
                localStorage.setItem('chat_session_id', this.sessionId);
            }
        },

        // Lazy: load history only on first open
        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.unread = 0;
                if (!this.historyLoaded) {
                    this.loadHistory();
                } else {
                    this.$nextTick(() => this.scrollToBottom());
                }
            }
        },

        async loadHistory() {
            this.loading = true;
            try {
                const res  = await fetch(`/chat/history?session_id=${encodeURIComponent(this.sessionId)}`);
                if (!res.ok) throw new Error(`HTTP ${res.status}`);

                const data = await res.json();
                if (!Array.isArray(data)) throw new Error('Invalid history response');
                this.messages = data;
                this.historyLoaded = true;
            } catch {
                // History load failure is non-fatal — widget still works
            } finally {
                this.loading = false;
                this.$nextTick(() => this.scrollToBottom());
            }
        },

        async sendMessage() {
            const text = this.input.trim();
            if (!text) return;

            // Push user message immediately (optimistic)
            this.messages.push({ sender: 'user', message: text });
            this.input   = '';
            this.typing  = true;
            this.$nextTick(() => this.scrollToBottom());

            try {
                const res = await fetch('/chat/message', {
                    method:  'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'text/event-stream',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ session_id: this.sessionId, message: text }),
                });

                if (!res.ok) throw new Error(`HTTP ${res.status}`);

                const botMessage = { sender: 'bot', message: '', id: null, feedback: null };
                this.messages.push(botMessage);
                const reader = res.body.getReader();
                const decoder = new TextDecoder();
                let buffer = '';
                while (true) {
                    const { value, done } = await reader.read();
                    if (done) break;
                    buffer += decoder.decode(value, { stream: true });
                    const frames = buffer.split('\n\n');
                    buffer = frames.pop() || '';
                    for (const frame of frames) {
                        const line = frame.split('\n').find((part) => part.startsWith('data: '));
                        if (!line) continue;
                        const event = JSON.parse(line.slice(6));
                        if (event.delta) botMessage.message += event.delta;
                        if (event.message_id) botMessage.id = event.message_id;
                        this.$nextTick(() => this.scrollToBottom());
                    }
                }
                if (!botMessage.message) {
                    botMessage.message = 'I could not get a reply right now. Please try again shortly.';
                }
                if (!this.open) this.unread++;
            } catch {
                this.messages.push({
                    sender:  'bot',
                    message: 'Something went wrong. Please try again.',
                });
            } finally {
                this.typing = false;
                this.$nextTick(() => this.scrollToBottom());
            }
        },

        async clearChat() {
            if (!confirm('Clear chat history?')) return;
            try {
                const res = await fetch('/chat/clear', {
                    method:  'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ session_id: this.sessionId }),
                });
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                this.messages = [];
                this.historyLoaded = true;
            } catch {
                // Keep the local history when the server could not clear it.
            }
        },

        async rateMessage(message, score) {
            const response = await fetch(`/chat/messages/${message.id}/feedback`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ session_id: this.sessionId, score }),
            });
            if (response.ok) message.feedback = score;
        },

        scrollToBottom() {
            const el = document.getElementById('chatMessages');
            if (el) el.scrollTop = el.scrollHeight;
        },
    };
}

function renderChatMarkdown(value) {
    return String(value || '')
        .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;').replace(/'/g, '&#039;')
        .replace(/\[([^\]]+)\]\((https:\/\/[^)\s]+)\)/g, '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>')
        .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
        .replace(/`([^`]+)`/g, '<code>$1</code>')
        .replace(/\n/g, '<br>');
}
</script>
@endpush
