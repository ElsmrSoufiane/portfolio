<x-filament-panels::page>
  <div id="chat_root_739184" style="height: 100%; width: 100%; font-family: Inter, system-ui, sans-serif; color: #183247; background: linear-gradient(145deg, #eaf8ff 0%, #d7f0ff 100%);">
  <main id="chat_shell_482761" class="flex h-full min-h-screen w-full flex-col">
    <header id="chat_header_618305" class="flex items-center justify-between border-b border-sky-200 bg-sky-500 px-5 py-4 shadow-[0_4px_6px_rgba(14,116,144,0.18)] sm:px-8">
      <div id="person_info_274930" class="flex items-center gap-3">
        <div id="avatar_wrap_905172" class="relative">
          <div id="avatar_318647" class="flex h-11 w-11 items-center justify-center rounded-full bg-white text-sm font-semibold text-sky-600 shadow-sm">
            MC
          </div>
          <span id="online_dot_761204" class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-sky-500 bg-emerald-400">
          </span>
        </div>
        <div id="person_text_543812">
          <h1 id="person_name_684209" class="text-base font-semibold tracking-tight text-white">
            Maya Chen
          </h1>
          <p id="person_status_172638" class="mt-0.5 text-xs text-sky-50">
            Online now
          </p>
        </div>
      </div>
      <button id="more_button_836451" aria-label="Conversation options" class="rounded-lg p-2 text-sky-50 transition hover:bg-sky-600 hover:text-white">
        <i data-lucide="menu" class="h-5 w-5">
        </i>
      </button>
    </header>
    <section id="messages_area_290517" aria-label="Messages" class="flex-1 overflow-y-auto px-4 py-7 sm:px-8">
      <div id="date_divider_451820" class="mb-7 flex items-center justify-center gap-3">
        <span id="divider_line_left_582931" class="h-px flex-1 bg-sky-200">
        </span>
        <span id="date_label_647203" class="text-[11px] font-medium uppercase tracking-widest text-sky-600">
          Today
        </span>
        <span id="divider_line_right_718564" class="h-px flex-1 bg-sky-200">
        </span>
      </div>
      <div id="message_list_809263" class="mx-auto flex w-full max-w-3xl flex-col gap-5">
        <article id="incoming_message_194826" class="flex items-end gap-2">
          <div id="incoming_avatar_263715" class="mb-5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-sky-200 text-[10px] font-semibold text-sky-800">
            MC
          </div>
          <div id="incoming_group_375902" class="flex max-w-[82%] flex-col items-start sm:max-w-[65%]">
            <div id="incoming_bubble_486137" class="rounded-2xl rounded-bl-md bg-white px-4 py-3 text-sm leading-6 text-slate-700 shadow-[0_4px_6px_rgba(14,116,144,0.1)]">
              Hey! Are we still on for the design review today?
            </div>
            <time id="incoming_time_597248" class="mt-1.5 px-1 text-[11px] text-sky-600">
              10:24 AM
            </time>
          </div>
        </article>
        <article id="outgoing_message_one_620359" class="flex items-end justify-end gap-2">
          <div id="outgoing_group_one_731480" class="flex max-w-[82%] flex-col items-end sm:max-w-[65%]">
            <div id="outgoing_bubble_one_842591" class="rounded-2xl rounded-br-md bg-sky-500 px-4 py-3 text-sm leading-6 text-white shadow-[0_4px_6px_rgba(14,116,144,0.2)]">
              Absolutely — I’ve pulled together the latest screens. I’ll send them over now.
            </div>
            <time id="outgoing_time_one_953602" class="mt-1.5 px-1 text-[11px] text-sky-600">
              10:26 AM
            </time>
          </div>
        </article>
        <article id="incoming_message_two_164793" class="flex items-end gap-2">
          <div id="incoming_avatar_two_275804" class="mb-5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-sky-200 text-[10px] font-semibold text-sky-800">
            MC
          </div>
          <div id="incoming_group_two_386915" class="flex max-w-[82%] flex-col items-start sm:max-w-[65%]">
            <div id="incoming_bubble_two_497026" class="rounded-2xl rounded-bl-md bg-white px-4 py-3 text-sm leading-6 text-slate-700 shadow-[0_4px_6px_rgba(14,116,144,0.1)]">
              Perfect. I’ll review them before our call.
            </div>
            <time id="incoming_time_two_508137" class="mt-1.5 px-1 text-[11px] text-sky-600">
              10:28 AM
            </time>
          </div>
        </article>
        <article id="outgoing_message_two_619248" class="flex items-end justify-end gap-2">
          <div id="outgoing_group_two_720359" class="flex max-w-[82%] flex-col items-end sm:max-w-[65%]">
            <div id="outgoing_bubble_two_831470" class="rounded-2xl rounded-br-md bg-sky-500 px-4 py-3 text-sm leading-6 text-white shadow-[0_4px_6px_rgba(14,116,144,0.2)]">
              Sounds good. Talk soon!
            </div>
            <time id="outgoing_time_two_942581" class="mt-1.5 px-1 text-[11px] text-sky-600">
              10:29 AM
            </time>
          </div>
        </article>
      </div>
    </section>
    <form id="message_composer_305716" class="border-t border-sky-200 bg-white/90 px-4 py-4 shadow-[0_-4px_6px_rgba(14,116,144,0.08)] backdrop-blur sm:px-8">
      <div id="composer_inner_416827" class="mx-auto flex w-[90%] items-end gap-2 rounded-2xl bg-sky-50 p-3 ring-2 ring-sky-200 transition focus-within:ring-sky-500">
        <button id="attach_button_527938" type="button" aria-label="Attach file" class="mb-1 rounded-lg p-2 text-sky-600 transition hover:bg-white hover:text-sky-700">
          <i data-lucide="paperclip" class="h-5 w-5">
          </i>
        </button>
        <textarea id="message_input_638049" rows="6" placeholder="Write a message..." class="min-h-[150px] flex-1 resize-none bg-white px-3 py-3 text-sm leading-6 text-slate-800 outline-none placeholder:text-sky-400">
        </textarea>
        <div id="composer_actions_582716" class="flex flex-col gap-1">
          <button id="emoji_button_749150" type="button" aria-label="Add emoji" class="rounded-lg p-2 text-sky-600 transition hover:bg-white hover:text-sky-700">
            <i data-lucide="smile" class="h-5 w-5">
            </i>
          </button>
          <button id="send_button_693405" type="submit" aria-label="Send message" class="rounded-lg bg-sky-500 p-2 text-white shadow-sm transition hover:bg-sky-600">
            <i data-lucide="send" class="h-5 w-5">
            </i>
          </button>
        </div>
      </div>
    </form>
  </main>
</div>
</x-filament-panels::page>
