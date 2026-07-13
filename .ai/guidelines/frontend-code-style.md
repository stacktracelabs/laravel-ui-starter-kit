# Frontend Code Style

- Do not disable controls merely to prevent harmless repeated actions because disabled states communicate unavailability and usually change the control's visual treatment. When repetition is safe, keep the action available; when a selected or current option should do nothing, remove its action so it behaves as a no-op without appearing disabled.
- Use Inertia prefetching intentionally rather than by default. Do not add `prefetch` unless there is a demonstrated navigation benefit that justifies caching the page response; prefetched props can become stale when session, user, workspace, or other mutable state changes. When prefetching is warranted, define an appropriate cache lifetime and invalidation strategy.
