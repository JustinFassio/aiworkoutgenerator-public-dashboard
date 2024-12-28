import { defineConfig } from 'vitest/config';
import react from '@vitejs/plugin-react';
import { resolve } from 'path';

export default defineConfig({
  plugins: [react()],
  test: {
    globals: true,
    environment: 'jsdom',
    setupFiles: ['./vitest.setup.ts'],
    coverage: {
      provider: 'v8',
      reporter: ['text', 'json', 'html'],
      exclude: [
        'node_modules/',
        'vitest.setup.ts',
        '**/*.d.ts',
        '**/*.config.ts',
        '**/index.ts',
        'coverage/**'
      ]
    },
    include: ['assets/src/**/*.{test,spec}.{ts,tsx}']
  },
  resolve: {
    alias: {
      '@': resolve(__dirname, 'assets/src'),
      '@components': resolve(__dirname, 'assets/src/dashboard/js/components'),
      '@features': resolve(__dirname, 'assets/src/dashboard/js/features'),
      '@utils': resolve(__dirname, 'assets/src/dashboard/js/utils'),
      '@styles': resolve(__dirname, 'assets/src/dashboard/scss')
    }
  }
}); 