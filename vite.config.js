import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    // servers: {
    //     host: "10.42.0.1",
    //     hmr: {
    //         host: "10.42.0.1",
    //     },
    // },
    server: {
        host: "0.0.0.0",
        port: 5173, // Change if needed
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
