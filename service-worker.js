self.addEventListener("install", event => {
    event.waitUntil(
        caches.open("pekka-cache-v1").then(cache => {
            return cache.addAll([
                "index.php",
                // "includes/header.php",
                // "includes/footer.php",
                // "modules/admin/admin_dashboard.php",
                // "modules/user/user_dashboard.php",
                "assets/icons/icon.png",
            ]);
        })
    );
});

self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request).then(response => {
            return response || fetch(event.request);
        })
    );
});
