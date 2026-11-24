// sw.js — app-shell cache for static assets only.
// HTML/PHP pages are NEVER cached: a cached demo page could replay an old
// language switcher long after it was removed from the source.
const CACHE_NAME = 'skyweb-shell-v2';
const ASSETS_TO_CACHE = [
  './manifest.json',
  './assets/css/sky.css',
  './assets/js/main.js'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => cache.addAll(ASSETS_TO_CACHE))
      .then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys()
      .then((keys) => Promise.all(
        keys.map((key) => (key !== CACHE_NAME ? caches.delete(key) : Promise.resolve(false)))
      ))
      .then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', (event) => {
  const request = event.request;
  const url = new URL(request.url);

  if (request.method !== 'GET' || !url.protocol.startsWith('http')) {
    return;
  }

  // Never intercept documents — always go to the network so visitors see the
  // current HTML (no stale pills, no stale markup of any kind).
  const acceptsHtml = (request.headers.get('accept') || '').indexOf('text/html') !== -1;
  if (request.mode === 'navigate' || acceptsHtml || /\.php(?:[?#]|$)/.test(url.pathname)) {
    return;
  }

  event.respondWith(
    fetch(request)
      .then((response) => {
        if (response && response.status === 200 && (response.type === 'basic' || response.type === 'cors')) {
          const copy = response.clone();
          caches.open(CACHE_NAME).then((cache) => cache.put(request, copy));
        }
        return response;
      })
      .catch(() => caches.match(request).then((cached) => cached || Response.error()))
  );
});
