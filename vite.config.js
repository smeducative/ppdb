import react from "@vitejs/plugin-react";
import laravel from "laravel-vite-plugin";
import { resolve } from "path";
import { defineConfig } from "vite";

export default defineConfig({
	plugins: [
		laravel({
			input: ["resources/css/app.css", "resources/js/app.tsx"],
			refresh: true,
		}),
		react(),
	],
	resolve: {
		alias: {
			"@": resolve(__dirname, "resources/js"),
		},
	},
});
