import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { resolve } from 'path';

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  base: '/wp-content/themes/athlete-dashboard-child/assets/dist/',
  build: {
    outDir: 'assets/dist',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: {
        dashboard: resolve(__dirname, 'assets/src/dashboard/js/index.ts'),
        styles: resolve(__dirname, 'assets/src/dashboard/scss/index.scss')
      },
      output: {
        entryFileNames: 'js/[name].[hash].js',
        chunkFileNames: 'js/[name].[hash].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name?.endsWith('.css')) {
            return 'css/[name].[hash][extname]';
          }
          return 'assets/[name].[hash][extname]';
        }
      }
    }
  },
  resolve: {
    alias: {
      '@': resolve(__dirname, 'assets/src'),
      '@components': resolve(__dirname, 'assets/src/dashboard/js/components'),
      '@features': resolve(__dirname, 'assets/src/dashboard/js/features'),
      '@utils': resolve(__dirname, 'assets/src/dashboard/js/utils'),
      '@styles': resolve(__dirname, 'assets/src/dashboard/scss')
    }
  },
  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `
          @use "@styles/variables" as *;
          @use "@styles/mixins" as *;
        `
      }
    }
  },
  server: {
    host: 'localhost',
    port: 3000,
    https: false,
    hmr: {
      host: 'localhost'
    }
  }
}); 