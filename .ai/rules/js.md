---
paths:
  - 'resources/js/**'
---

# Js

## Echo presence: read ids from here/joining/leaving, not .members
Laravel Echo's pusher/reverb PresenceChannel (returned by echo.join()) does NOT expose a `.members` property. Do NOT read `presenceChannel.members.each(...)` to get online ids - it's undefined and silently returns []. Instead derive ids from the callbacks: `.here(members)` gives the full array of {id,name} objects. Maintain a Set in module scope, populate it on `.here` (clear+fill), add on `.joining`, delete on `.leaving`, and dispatch that. Note: echo.join(name) prefixes 'presence-' so the wire channel is 'presence-'.name; keep channel names consistent between chat.js and Broadcast::channel().
