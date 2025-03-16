import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        host: "tokojawahir.test", // Or '0.0.0.0' for all interfaces
        port: 5173,
        hmr: {
            host: "localhost",
        },
        cors: true, // Enable CORS
    },
});
