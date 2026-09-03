<x-filament-panels::page>

  @php($conversation = $this->getActiveConversation())

  <div id="chat_root_739184" style="height: 100%; width: 100%; font-family: Inter, system-ui, sans-serif; color: #183247;">
    <div id="chat_shell_482761" class="flex h-full min-h-screen w-full">

      <aside id="conversation_sidebar_291405" class="flex w-72 shrink-0 flex-col border-r border-sky-200">
        <div id="conversation_list_516304" class="flex-1 overflow-y-auto p-3">
          @forelse ($conversations as $conv)
            <button type="button"
                    wire:key="conv-{{ $conv['id'] }}"
                    wire:click="switchConversation({{ $conv['id'] }})"
                    class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left transition hover:bg-sky-100 @if ($conv['id'] === $activeConversationId) bg-sky-500 shadow-[0_4px_6px_rgba(14,116,144,0.18)] hover:bg-sky-600 @endif">
              <div class="relative">
                <div class="flex h-11 w-11 items-center justify-center rounded-full text-sm font-semibold shadow-sm @if ($conv['id'] === $activeConversationId) bg-white text-sky-700 @else bg-sky-100 text-sky-800 @endif">
                  {{ $conv['initials'] }}
                </div>
                <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-sky-500 @if ($conv['is_recent']) bg-emerald-400 @else bg-slate-300 @endif"></span>
              </div>
              <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold @if ($conv['id'] === $activeConversationId) text-white @else text-slate-900 @endif">
                  {{ $conv['name'] }}
                </p>
                <p class="truncate text-xs @if ($conv['id'] === $activeConversationId) text-sky-50 @else text-slate-500 @endif">
                  {{ $conv['status'] }}
                </p>
              </div>
            </button>
          @empty
            <p class="px-3 py-6 text-center text-sm text-slate-400">No conversations yet</p>
          @endforelse
        </div>
      </aside>

      @if ($conversation)
        <main id="chat_pane_510274" class="flex h-full min-h-screen w-full min-w-0 flex-1 flex-col">
          <header id="chat_header_618305" class="flex min-h-30 items-center justify-between border-b border-sky-200 bg-sky-500 px-5 shadow-[0_4px_6px_rgba(14,116,144,0.18)] sm:px-8">
            <div id="person_info_274930" class="flex items-center gap-3">
              <div id="avatar_wrap_905172" class="relative">
                <div id="avatar_318647" class="flex h-11 w-11 items-center justify-center rounded-full bg-white text-sm font-semibold text-sky-700 shadow-sm">
                  {{ $conversation['initials'] }}
                </div>
                <span id="online_dot_761204" class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-sky-500 @if ($conversation['is_recent']) bg-emerald-400 @else bg-slate-300 @endif"></span>
              </div>
              <div id="person_text_543812">
                <h1 id="person_name_684209" class="text-base font-semibold tracking-tight text-white">
                  {{ $conversation['name'] }}
                </h1>
                <p id="person_status_172638" class="mt-0.5 text-xs text-sky-50">
                  {{ $conversation['status'] }}
                </p>
              </div>
            </div>
            <button id="more_button_836451" aria-label="Conversation options" class="rounded-lg p-2 text-sky-50 transition hover:bg-sky-600 hover:text-white">
              <i data-lucide="menu" class="h-5 w-5"></i>
            </button>
          </header>
          <section id="messages_area_290517" aria-label="Messages" class="flex-1 overflow-y-auto px-4 py-7 sm:px-8">
            <div id="message_list_809263" class="mx-auto flex w-full max-w-3xl flex-col gap-5">
              @forelse ($messages as $message)
                <article class="flex items-end gap-2 @if ($message['is_own']) justify-end @endif"
                         wire:key="msg-{{ $message['id'] }}"
                         x-data="{ showActions: false }"
                         x-on:mouseenter="showActions = true"
                         x-on:mouseleave="showActions = false">
                  @unless ($message['is_own'])
                    <div class="mb-5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-sky-100 text-[10px] font-semibold text-sky-800">
                      {{ $conversation['initials'] }}
                    </div>
                  @endunless
                  <div x-show="showActions" x-cloak class="flex items-center gap-0.5 @if ($message['is_own']) self-end @else self-start @endif">
                    {{ ($this->editAction)(['id' => $message['id']]) }}
                    {{ ($this->deleteAction)(['id' => $message['id']]) }}
                  </div>
                  <div class="flex max-w-[82%] flex-col sm:max-w-[65%] @if ($message['is_own']) items-end @else items-start @endif">
                    <div class="rounded-2xl px-4 py-3 text-sm leading-6 shadow-[0_4px_6px_rgba(14,116,144,0.16)] @if ($message['is_own']) rounded-br-md bg-sky-600 text-white @else rounded-bl-md border border-sky-200 bg-sky-50 text-slate-800 shadow-[0_4px_6px_rgba(14,116,144,0.08)] @endif">
                      {{ $message['content'] }}
                    </div>
                    <time class="mt-1.5 px-1 text-[11px] text-sky-700">
                      {{ $message['time'] }}
                    </time>
                  </div>
                </article>
              @empty
                <p class="text-center text-sm text-slate-400">No messages yet. Say hello!</p>
              @endforelse
            </div>
          </section>
          <form id="message_composer_305716" class="border-t border-sky-100 px-4 py-5 sm:px-8">
            <div id="composer_inner_416827" class="mx-auto flex w-[90%] items-end gap-1 rounded-2xl border-2 border-sky-700 bg-white p-2 shadow-[0_5px_14px_rgba(3,105,161,0.14)] transition focus-within:border-sky-800">
              <button id="attach_button_527938" type="button" aria-label="Attach file" class="mb-1 shrink-0 rounded-xl p-3 text-sky-800 transition hover:bg-sky-50">
                <i data-lucide="paperclip" class="h-5 w-5"></i>
              </button>
              <textarea id="message_input_638049" rows="6" placeholder="Write a message..." maxlength="100" class="min-h-[150px] flex-1 resize-none border-0 bg-white px-3 py-3 text-base leading-7 text-slate-900 outline-none placeholder:text-sky-700 focus:ring-0"
              wire:model="message"
              >
              </textarea>
              @error('message')
              <span class="w-full text-xs text-red-600">{{ $message }}</span>
              @enderror
              <div id="composer_actions_582716" class="flex shrink-0 items-end gap-1 pb-1">
                <button id="emoji_button_749150" type="button" aria-label="Add emoji" class="rounded-xl p-3 text-sky-800 transition hover:bg-sky-50">
                  <i data-lucide="smile" class="h-5 w-5"></i>
                </button>
                <x-filament::icon-button
                  wire:click="send"
                  icon="heroicon-m-paper-airplane"
                  label="send"
                />
              </div>
            </div>
          </form>
        </main>
      @else
        <main class="flex h-full min-h-screen w-full min-w-0 flex-1 flex-col items-center justify-center gap-2 text-slate-400">
          <p class="text-sm font-medium">Select a conversation to start chatting</p>
          <p class="text-xs">Conversations from customers will appear here.</p>
        </main>
      @endif
    </div>
  </div>

  <x-filament-actions::modals />
</x-filament-panels::page>