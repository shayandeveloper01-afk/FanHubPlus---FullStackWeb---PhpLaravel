<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-white">Settings</h1>
    </x-slot>

    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf @method('PUT')

            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-5">
                <h2 class="text-sm font-semibold text-white border-b border-gray-800 pb-3">General</h2>

                <div>
                    <label class="block text-xs text-gray-400 mb-1">Site Name</label>
                    <input type="text" name="site_name"
                           value="{{ $settings['site_name'] ?? config('app.name') }}"
                           class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs text-gray-400 mb-1">Contact Email</label>
                    <input type="email" name="contact_email"
                           value="{{ $settings['contact_email'] ?? '' }}"
                           class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-indigo-500">
                </div>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-5">
                <h2 class="text-sm font-semibold text-white border-b border-gray-800 pb-3">Chatbot</h2>

                <div>
                    <label class="block text-xs text-gray-400 mb-1">Fallback Message</label>
                    <textarea name="chatbot_fallback_message" rows="3"
                              class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-indigo-500">{{ $settings['chatbot_fallback_message'] ?? '' }}</textarea>
                    <p class="text-xs text-gray-600 mt-1">Shown when no FAQ matches. Leave blank to use the default.</p>
                </div>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-5">
                <h2 class="text-sm font-semibold text-white border-b border-gray-800 pb-3">Feedback</h2>

                <div>
                    <label class="block text-xs text-gray-400 mb-1">Feedback Categories (comma-separated)</label>
                    <input type="text" name="feedback_categories"
                           value="{{ $settings['feedback_categories'] ?? 'bug,suggestion,general,report' }}"
                           class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-indigo-500">
                    <p class="text-xs text-gray-600 mt-1">Changing this only affects display labels — existing DB values are unchanged.</p>
                </div>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
                <h2 class="text-sm font-semibold text-white border-b border-gray-800 pb-3 mb-4">Maintenance</h2>

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="maintenance_mode" value="0">
                    <input type="checkbox" name="maintenance_mode" value="1"
                           {{ ($settings['maintenance_mode'] ?? '0') === '1' ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-600 bg-gray-800 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm text-white">Enable Maintenance Mode</span>
                </label>
                <p class="text-xs text-gray-600 mt-2 ml-7">
                    When on, non-admin visitors see a maintenance page. Admins are unaffected.
                </p>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
