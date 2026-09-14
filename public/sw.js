const IZIFAI_CACHE = 'izifai-v1';
const APP_PRECACHE = ['/', '/' + 'manifest.webmanifest'];

self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(IZIFAI_CACHE)
            .then(function (cache) {
                return cache.addAll(APP_PRECACHE);
            })
            .then(function () {
                return self.skipWaiting();
            })
    );
});

self.addEventListener('activate', function (event) {
    event.waitUntil(
        caches.keys()
            .then(function (keys) {
                return Promise.all(
                    keys.filter(function (key) { return key !== IZIFAI_CACHE; })
                        .map(function (key) { return caches.delete(key); })
                );
            })
            .then(function () {
                return self.clients.claim();
            })
    );
});

self.addEventListener('fetch', function (event) {
    var request = event.request;
    if (request.method !== 'GET') return;

    var url = new URL(request.url);
    if (url.origin !== self.location.origin) return;

    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request).catch(function () {
                return caches.match('/');
            })
        );
        return;
    }

    event.respondWith(
        caches.open(IZIFAI_CACHE).then(function (cache) {
            return cache.match(request).then(function (cached) {
                var network = fetch(request).then(function (response) {
                    if (response && response.ok) {
                        cache.put(request, response.clone());
                    }
                    return response;
                }).catch(function () {
                    return cached;
                });
                return cached || network;
            });
        })
    );
});