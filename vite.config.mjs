import { defineConfig } from 'vite'
import { resolve } from 'path'

export default defineConfig({

    root: '',
    base: process.env.NODE_ENV === 'development'
        ? '/'
        : '/dist/',

    build: {
        outDir: 'dist',
        emptyOutDir: true,
        manifest: true,
        rollupOptions: {
            input: {
                main: resolve(__dirname, '/main.js')
            }
        },
        minify: true,
        write: true
    },

    server: {
        cors: true,
        port: 3000
    },

    plugins: [
        {
            name: 'php',
            handleHotUpdate({file, server}) {
                if (file.endsWith('.php')) {
                    server.ws.send({ type: 'full-reload' });
                }
            }
        }
    ]
})